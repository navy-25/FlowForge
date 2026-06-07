<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkflowRun extends Model
{
    protected $fillable = [
        'workflow_id',
        'status',
        'started_at',
        'finished_at'
    ];

    /**
     * Ambil detail data workflow parent
     */
    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }

    /**
     * Ambil data node secara keseluruhan
     */
    public function nodes()
    {
        return $this->hasMany(WorkflowRunSteps::class);
    }
}
