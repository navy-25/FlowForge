<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Workflow;
use Illuminate\Database\Seeder;

class WorkflowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flows  = config('flow');
        $user   = User::where('role', 'admin')->first();

        foreach ($flows as $key => $flow) {
            $nodes = collect($flow['definition']['nodes'])->map(function ($node) {
                return [
                    'id'        => $node['id'],
                    'type'      => $node['type'],
                    'label'     => $node['label'],
                    'config'    => $node['config'],
                ];
            })->toArray();


            $edges = $flow['definition']['edges'] ?? [];

            $trigger_type = $flow['label'] == 'Kirim Email Otomatis' ? 'manual' : 'cron';
            $cron_expression = null;
            if ($trigger_type === 'cron') {
                $cron_expression = "*/10 * * * *"; # setiap 10 menit
            }
            Workflow::create([
                'user_id'           => $user?->id,
                'name'              => $flow['label'],
                'version'           => 'v1',
                'trigger_type'      => $trigger_type,
                'cron_expression'   => $cron_expression,
                'definition'    => [
                    'nodes'     => $nodes,
                    'edges'     => $edges,
                ],
            ]);
        }
    }
}
