<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkflowRunSteps extends Model
{
    protected $fillable = [
        'workflow_run_id',
        'node_id',
        'status',
        'output',
        'context',
        'error'
    ];

    /**
     * Ambil detail data node parent
     */
    public function node_step()
    {
        return $this->belongsTo(WorkflowRun::class, 'workflow_run_id');
    }
}
