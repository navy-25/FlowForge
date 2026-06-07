<?php

namespace App\Services;

use App\Models\WorkflowRun;
use App\Models\WorkflowRunSteps;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkflowCompletionService
{
    /**
     * Periksa apakah sebuah workflow run sudah selesai dan update statusnya.
     *
     * Input:
     * - $runId (int): id dari WorkflowRun yang ingin diperiksa.
     *
     * Output / efek samping:
     * - Jika semua node telah selesai, update kolom `status` dan `finished_at` pada
     *   model WorkflowRun.
     * - Menuliskan log ketika status menjadi 'completed' atau 'failed'.
     *
     * Perilaku:
     * - Fungsi ini menjalankan seluruh operasi dalam sebuah DB transaction dan
     *   melakukan SELECT ... FOR UPDATE pada row WorkflowRun untuk menghindari
     *   race condition (beberapa proses yang memeriksa/menyelesaikan run yang sama).
     * - Idempotent: jika run sudah berstatus 'completed' atau 'failed', fungsi
     *   akan langsung kembali tanpa melakukan perubahan.
     * - Menganggap sebuah node selesai bila step-nya memiliki status 'success' atau 'failed'.
     */
    public function check($runId)
    {
        DB::transaction(function () use ($runId) {

            // Lock row WorkflowRun agar proses lain tidak memodifikasi bersamaan.
            $run = WorkflowRun::lockForUpdate()->find($runId);

            // Jika run tidak ada, hentikan.
            if (!$run) {
                return;
            }

            // Sudah selesai? (idempotency)
            if (in_array($run->status, ['completed', 'failed'])) {
                return;
            }

            // Ambil definisi workflow dan hitung jumlah node yang harus diselesaikan.
            $definition = $run->workflow->definition;
            $totalNodes = count($definition['nodes']);

            // Ambil semua step terkait workflow run ini sekaligus untuk efisiensi.
            $steps = WorkflowRunSteps::where('workflow_run_id', $runId)->get();

            // Hitung berapa step yang sudah selesai (baik success maupun failed).
            $finishedSteps = $steps
                ->whereIn('status', ['success', 'failed'])
                ->count();

            // Jika belum semua node selesai, keluar tanpa update.
            if ($finishedSteps < $totalNodes) {
                return;
            }

            // Jika ada step yang failed, final status menjadi 'failed', selain itu 'completed'.
            $hasFailed = $steps->contains('status', 'failed');

            $finalStatus = $hasFailed ? 'failed' : 'completed';

            // Update status dan timestamp selesai hanya sekali.
            $run->update([
                'status'      => $finalStatus,
                'finished_at' => now()
            ]);

            // Tuliskan log ringkas supaya operator/monitoring bisa melihat hasilnya.
            Log::info('[Workflow] COMPLETED', [
                'run_id' => $runId,
                'status' => $finalStatus
            ]);
        });
    }
}
