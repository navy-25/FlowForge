<?php

namespace App\Services;

use App\Helpers\DagHelper;

use App\Models\Workflow;
use App\Models\WorkflowRun;

use App\Jobs\ExecuteNodeJob;

class WorkflowEngineServices
{
    /**
     * Mulai eksekusi workflow dengan membuat WorkflowRun dan mendorong job untuk
     * setiap start node.
     *
     * Input:
     * - $workflow: instance App\Models\Workflow (harus memiliki properti `definition`)
     *
     * Efek samping / output:
     * - Membuat record `WorkflowRun` dengan status 'running'.
     * - Men-dispatch job `ExecuteNodeJob` untuk setiap start node. Context awal kosong.
     * - Mengembalikan instance `WorkflowRun` yang baru dibuat.
     *
     * Catatan implementasi:
     * - Context awal diset ke array kosong — node pertama diharapkan mengisi context
     *   pada saat job dijalankan.
     */
    public function run(Workflow $workflow)
    {
        $run = WorkflowRun::create([
            'workflow_id' => $workflow->id,
            'status' => 'running',
            'started_at' => now(),
            'context' => [],
        ]);

        $definition = $workflow->definition;

        // Ambil node awal dari DAG (node dengan no incoming edge)
        $startNodes = DagHelper::getStartNodes($definition);

        // Dispatch job eksekusi untuk setiap start node. Jobs akan berjalan
        // asinkron (queue) sesuai konfigurasi queue aplikasi.
        foreach ($startNodes as $node) {
            dispatch(new ExecuteNodeJob(
                $run,
                $node,
                []
            ));
        }

        return $run;
    }

    /**
     * Validasi struktur definisi workflow.
     *
     * Periksa:
     * - Semua edge menunjuk ke node yang ada.
     * - Tidak adanya siklus (DAG requirement).
     *
     * Behavior / error modes:
     * - Jika ada edge yang menunjuk node yang tidak ada, akan melempar Exception.
     * - Jika siklus terdeteksi, akan melempar Exception.
     *
     * Edge cases:
     * - Mengasumsikan $definition['nodes'] adalah array node yang memiliki kunci 'id'.
     * - Mengasumsikan $definition['edges'] adalah array dengan elemen berisi 'from' dan 'to'.
     */
    public function validate($definition)
    {
        $nodes = collect($definition['nodes'])->pluck('id');
        $edges = $definition['edges'];

        // Validasi referensi edge
        foreach ($edges as $edge) {
            if (!$nodes->contains($edge['from']) || !$nodes->contains($edge['to'])) {
                throw new \Exception("Invalid edge reference");
            }
        }

        // Deteksi siklus menggunakan DFS dan stack rekursif
        $visited = [];
        $stack = [];

        $graph = [];

        foreach ($edges as $edge) {
            $graph[$edge['from']][] = $edge['to'];
        }

        $hasCycle = function ($node) use (&$hasCycle, &$visited, &$stack, $graph) {
            if (!isset($visited[$node])) {
                $visited[$node] = true;
                $stack[$node] = true;

                foreach ($graph[$node] ?? [] as $neighbor) {
                    if (
                        (!isset($visited[$neighbor]) && $hasCycle($neighbor)) ||
                        ($stack[$neighbor] ?? false)
                    ) {
                        return true;
                    }
                }
            }

            $stack[$node] = false;
            return false;
        };

        foreach ($nodes as $node) {
            if ($hasCycle($node)) {
                throw new \Exception("Cycle detected in workflow");
            }
        }
    }
}
