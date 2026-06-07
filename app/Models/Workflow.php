<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'version',
        'trigger_type',
        'cron_expression',
        'definition',
    ];

    protected $casts = [
        'definition' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workflow_run()
    {
        return $this->hasOne(WorkflowRun::class, 'workflow_id')->latestOfMany();
    }
}
