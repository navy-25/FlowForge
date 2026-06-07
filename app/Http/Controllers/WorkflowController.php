<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkFlowRequest;
use App\Models\Workflow;
use App\Services\WorkflowEngineServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkflowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Workflow::with(['user.tenant','workflow_run'])
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('pages.workflow', compact('data'));
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
        $flows  = config('flow');
        $nodes = collect($flows[$request->definition]['definition']['nodes'])->map(function ($node) {
            return [
                'id'        => $node['id'],
                'type'      => $node['type'],
                'label'     => $node['label'],
                'config'    => $node['config'],
            ];
        })->toArray();
        $edges = $flows[$request->definition]['definition']['edges'] ?? [];

        $trigger_type = $flows[$request->definition]['label'] == 'Kirim Email Otomatis' ? 'manual' : 'cron';
        $cron_expression = null;
        if ($trigger_type === 'cron') {
            $cron_expression = "*/10 * * * *"; # setiap 10 menit
        }
        Workflow::create([
            'user_id'           => 1,
            // 'user_id'           => Auth::user()->id,
            'name'              =>  $flows[$request->definition]['label'],
            'version'           => 'v1',
            'trigger_type'      => $trigger_type,
            'cron_expression'   => $cron_expression,
            'definition'    => [
                'nodes'     => $nodes,
                'edges'     => $edges,
            ],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Workflow berhasil dibuat.');
    }
    public function run($id, WorkflowEngineServices $engine)
    {
        $workflow = Workflow::findOrFail($id);
        $engine->run($workflow);

        return redirect()
            ->back()
            ->with('success', 'Workflow berhasil dijalankan.');
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
