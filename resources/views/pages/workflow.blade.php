@extends('layouts.admin')

@section('page-title','Workflow')
@section('sidebar-workflow','active')

@section('content')
<!-- Page header -->
<div class="page-head">
    <div>
        <div class="page-title">Workflow</div>
        <div class="page-sub">Daftar alur kerja yang di buat atau di jadwalkan</div>
    </div>
    <div class="page-actions">
        <button class="btn-ghost">
            <i class="bi bi-arrow-clockwise"></i> Refresh </button>
        <button class="btn-accent">
            <i class="bi bi-plus"></i> Workflow Baru </button>
    </div>
</div>
<!-- Main panels -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="bi bi-activity"></i> Aktivitas Terkini
                </div>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tenant</th>
                        <th>Nama Workflow</th>
                        <th>Version</th>
                        <th>Pengguna</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $value)
                        <tr>
                            <td>{{ $value->user->tenant->name }}</td>
                            <td>{{ $value->name }}</td>
                            <td>
                                <span class="pill pill-green">{{ $value->version }}</span>
                            </td>
                            <td>{{ $value->user->name }}</td>
                            <td>{{ diffForHuman($value->created_at) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
