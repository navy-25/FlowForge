<?php

namespace App\Helpers;

use App\Models\WorkflowRunSteps;

class DagHelper
{
    public static function getStartNodes($definition)
    {
        $targets = collect($definition['edges'])->pluck('to');

        return collect($definition['nodes'])
            ->whereNotIn('id', $targets)
            ->values();
    }

    public static function getNextNodes($definition, $nodeId)
    {
        $nextIds = collect($definition['edges'])
            ->where('from', $nodeId)
            ->pluck('to');

        return collect($definition['nodes'])
            ->whereIn('id', $nextIds)
            ->values();
    }

    public static function isNodeReady($runId, $definition, $nodeId): bool
    {
        $parents = collect($definition['edges'])
            ->where('to', $nodeId)
            ->pluck('from');

        if ($parents->isEmpty()) {
            return true;
        }

        $completed = WorkflowRunSteps::where('workflow_run_id', $runId)
            ->whereIn('node_id', $parents)
            ->where('status', 'success')
            ->count();

        return $completed === $parents->count();
    }
}
