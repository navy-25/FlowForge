<?php

namespace App\Jobs;

use App\Helpers\DagHelper;
use App\Models\WorkflowRun;
use App\Models\WorkflowRunSteps;
use App\Services\NodeExecutorServices;
use App\Services\WorkflowCompletionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ExecuteNodeJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    /**
     * Job untuk mengeksekusi satu node pada workflow run.
     *
     * Contract / input:
     * - $run: App\Models\WorkflowRun instance (representasi run saat ini)
     * - $node: array definisi node (harus berisi 'id' dan 'type' + config)
     * - $context: array (opsional) — context immutable yang dibawa dari node sebelumnya
     *
     * Efek samping:
     * - Membuat record WorkflowRunSteps untuk melacak status tiap node.
     * - Menulis beberapa log untuk observability.
     * - Men-dispatch job ExecuteNodeJob baru untuk next nodes ketika dependencies terpenuhi.
     * - Memanggil WorkflowCompletionService->check() untuk mengecek akhir workflow.
     *
     * Retry / timeout:
     * - $tries dan $backoff menentukan retry behavior (exponential backoff).
     * - $timeout menentukan timeout eksekusi job (detik).
     *
     * Catatan concurrency:
     * - Job mengambil fresh copy dari $run pada awal handle() untuk mengurangi race.
     * - Dependency check menggunakan DagHelper::isNodeReady yang memeriksa DB agar
     *   dispatch terhadap next node aman dijalankan secara paralel oleh beberapa worker.
     */

    /**
     * 🔁 Retry config (exponential backoff)
     */
    public $tries = 3;
    public $backoff = [1, 2, 4];

    /**
     * ⏱️ Timeout per job
     */
    public $timeout = 30;

    protected $run;
    protected $node;
    protected $context;

    public function __construct(WorkflowRun $run, $node, $context = [])
    {
        $this->run     = $run;
        $this->node    = $node;
        $this->context = $context;
    }
    /**
     * Jalankan job eksekusi node.
     *
     * Behaviour ringkas langkah demi langkah:
     * 1) Buat WorkflowRunSteps dengan status 'running'.
     * 2) Ambil context dari payload job (tidak dari DB) — deterministik untuk retry.
     * 3) Panggil NodeExecutorServices->execute(node, context).
     * 4) Normalisasi output menjadi array agar cocok dengan kolom JSON.
     * 5) Update step sebagai 'success' dengan output dan context terbaru.
     * 6) Hit DAG untuk menentukan next nodes dan dispatch job baru jika ready.
     * 7) Jika terjadi exception: update step 'failed', mark run 'failed' (fail-fast),
     *    lalu rethrow agar mekanisme retry queue bekerja.
     * 8) Setelah sukses, panggil WorkflowCompletionService->check() untuk cek apakah
     *    seluruh workflow sudah selesai.
     *
     * Note tentang idempotency and retries:
     * - Karena job bisa di-retry oleh queue, penulisan state (WorkflowRunSteps) dibuat
     *   deterministik: langkah dibuat sebelum eksekusi dan diupdate kemudian.
     * - Rethrow exception agar sistem queue melakukan retry sesuai konfigurasi $tries.
     */
    public function handle(
        NodeExecutorServices $executor,
        WorkflowCompletionService $completionService
    ): void
    {
        // selalu ambil fresh data (hindari race condition)
        $this->run = $this->run->fresh();

        /**
         * 1. CREATE STEP
         */
        $step = WorkflowRunSteps::create([
            'workflow_run_id' => $this->run->id,
            'node_id'         => $this->node['id'],
            'status'          => 'running',
        ]);

        try {

            /**
             * 2. AMBIL CONTEXT DARI JOB PAYLOAD
             * (bukan dari DB supaya deterministic)
             */
            $currentContext = $this->context ?? [];

            Log::info('[Workflow] CONTEXT BEFORE EXECUTE', [
                'run_id'  => $this->run->id,
                'node'    => $this->node['id'],
                'context' => $currentContext
            ]);

            /**
             * 3. EXECUTE NODE
             */
            $result = $executor->execute(
                $this->node,
                $currentContext
            );

            /**
             * 4. NORMALIZE OUTPUT (wajib array untuk JSON column)
             */
            if (!is_array($result)) {
                $result = ['value' => $result];
            }

            Log::info('[Workflow] NODE RESULT', [
                'node'   => $this->node['id'],
                'result' => $result
            ]);

            /**
             * 5. UPDATE CONTEXT (immutable-style)
             */
            $updatedContext = array_merge(
                $currentContext,
                [$this->node['id'] => $result]
            );

            /**
             * 6. UPDATE STEP
             */
            $step->update([
                'status'  => 'success',
                'output'  => $result,
                'context' => $updatedContext
            ]);

            /**
             * 7. GET NEXT NODES (DAG)
             */
            $definition = $this->run->workflow->definition;

            $nextNodes = DagHelper::getNextNodes(
                $definition,
                $this->node['id']
            );

            /**
             * 8. DISPATCH NEXT NODES (PARALLEL SAFE)
             */
            foreach ($nextNodes as $nextNode) {

                // hanya jalan kalau dependency selesai
                if (
                    DagHelper::isNodeReady(
                        $this->run->id,
                        $definition,
                        $nextNode['id']
                    )
                ) {
                    dispatch(new self(
                        $this->run->fresh(),
                        $nextNode,
                        $updatedContext
                    ));
                }
            }

        } catch (\Throwable $e) {

            /**
             * ❌ HANDLE ERROR
             */
            $step->update([
                'status' => 'failed',
                'error'  => $e->getMessage()
            ]);

            Log::error('[Workflow] NODE FAILED', [
                'node'  => $this->node['id'],
                'error' => $e->getMessage()
            ]);

            /**
             * ❌ FAIL FAST (optional strategy)
             */
            $this->run->update([
                'status'      => 'failed',
                'finished_at' => now()
            ]);

            throw $e; // biar retry jalan
        }

        /**
         * 9. CHECK WORKFLOW COMPLETION
         */
        $completionService->check($this->run->id);
    }
}
