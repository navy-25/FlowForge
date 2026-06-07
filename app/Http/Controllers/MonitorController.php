<?php

namespace App\Http\Controllers;

use App\Models\Workflow;
use App\Models\WorkflowRun;
use App\Models\WorkflowRunSteps;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['active_workflows'] = Workflow::count();
        $data['completed_workflows'] = WorkflowRun::where('status', 'completed')->count();
        $data['failed_workflows'] = WorkflowRun::where('status', 'failed')->count();
        $data['running_workflows'] = WorkflowRun::where('status', 'running')->count();

        $total = $data['completed_workflows'] + $data['failed_workflows'] + $data['running_workflows'];
        $data['completed_percentage'] = $total > 0
            ? round(($data['completed_workflows'] / $total) * 100, 2)
            : 0;

        $data['failed_percentage'] = $total > 0
            ? round(($data['failed_workflows'] / $total) * 100, 2)
            : 0;

        $data['running_percentage'] = $total > 0
            ? round(($data['running_workflows'] / $total) * 100, 2)
            : 0;

        $log_workflow = WorkflowRunSteps::orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
        $last_activity = Workflow::with('user','user.tenant')
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
        return view('pages.dashboard', compact(
            'data',
            'log_workflow',
            'last_activity',
            'total'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
