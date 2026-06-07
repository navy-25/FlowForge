<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Workflow;
use Illuminate\Http\Request;

use App\Services\WorkflowEngineServices;
use App\Http\Requests\StoreWorkflowRequest;

class WorkflowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Workflow::all();
    }

    /**
     * Run all workflow (Stress Test)
     */
    public function stressTest(WorkflowEngineServices $engine)
    {
        $runs = [];

        $all_workflow = Workflow::get();

        foreach ($all_workflow as $value) {
            $runs[] = $engine->run($value);
        }

        return response()->json([
            'message' => 'Stress test started',
            'total_workflows' => count($all_workflow),
            'runs' => $runs
        ]);
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
    public function store(StoreWorkflowRequest $request)
    {
        return Workflow::create($request->validated());
    }

    /**
     * Run workflow by ID
     */
    public function run($id, WorkflowEngineServices $engine)
    {
        $workflow = Workflow::findOrFail($id);
        return $engine->run($workflow);
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
