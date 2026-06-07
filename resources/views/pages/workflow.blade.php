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
        <button class="btn-accent" data-bs-toggle="modal" data-bs-target="#modalCreateWorkflow">
            <i class="bi bi-plus"></i> Workflow Baru </button>
    </div>
</div>
<!-- Main panels -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tenant</th>
                        <th>Nama Workflow</th>
                        <th>Trigger</th>
                        <th>Status</th>
                        <th>Pengguna</th>
                        <th>Waktu</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $value)
                        <tr>
                            <td>{{ $value->user->tenant->name }}</td>
                            <td>{{ $value->name }} <span class="pill pill-green">{{ $value->version }}</span></td>
                            <td class="text-capitalize">
                                {{ $value->trigger_type }}
                                <br>
                                @if ($value->cron_expression)
                                    <code>
                                        ({{ $value->cron_expression }})
                                    </code>
                                @endif
                            </td>
                            <td>
                                @php
                                    $status = $value->workflow_run->status ?? "pending";
                                @endphp
                                <div class="d-flex align-items-center gap-2 text-capitalize">
                                    @if ($status == 'completed')
                                        <i class="bi bi-check-lg" style="color:rgba(0,217,192,.08);color:var(--accent)"></i>
                                    @elseif ($status == 'failed')
                                        <i class="bi bi-exclamation-lg" style="color:rgba(255,77,106,.08);color:var(--accent-4)"></i>
                                    @elseif ($status == 'running')
                                        <i class="bi bi-clock" style="color:rgba(245,166,35,.08);color:var(--accent-3)"></i>
                                    @elseif ($status == 'pending')
                                        <i class="bi bi-clock" style="color:rgba(245,166,35,.08);color:var(--accent-3)"></i>
                                    @endif
                                    {{ $status }}
                                </div>
                            </td>
                            <td>{{ $value->user->name }}</td>
                            <td>{{ diffForHuman($value->created_at) }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if ($status == 'running')
                                    @else
                                        <form action="{{ route('admin.workflow.run',['id' => $value->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-accent p-0 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                <i class="bi bi-play"></i>
                                            </button>
                                        </form>
                                    @endif
                                    {{-- <button class="btn-ghost p-0 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="bi bi-x"></i>
                                    </button> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Workflow -->
<div class="modal fade" id="modalCreateWorkflow" tabindex="-1" aria-labelledby="modalCreateWorkflowLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <form action="{{ route('admin.workflow.store') }}" method="POST" id="createWorkflowForm">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="modalCreateWorkflowLabel">Tambah Workflow Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body border-0">
                    <div class="row">
                        <div class="col-12 col-md-8 mb-3 field-group">
                            <label class="field-label">Nama Workflow</label>
                            <div class="field-wrap">
                                <input class="field-input"  name="name" type="text" placeholder="Contoh: Kirim Email Otomatis" required/>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-3 field-group">
                            <label class="field-label">Version</label>
                            <div class="field-wrap">
                                <input class="field-input"  name="version" type="text" placeholder="Contoh: 1.0.0" required/>
                            </div>
                        </div>
                        <div class="mb-3 field-group">
                            <label class="field-label">Trigger Type</label>
                            <div class="field-wrap">
                                <select name="trigger_type" id="triggerType" class="field-input" required>
                                    <option value="manual">Manual</option>
                                    {{-- <option value="cron">Cron / Terjadwal</option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 field-group d-none" id="cronExpressionWrapper">
                            <label class="field-label">Cron Expression</label>
                            <div class="field-wrap">
                                <input class="field-input" name="cron_expression" type="text" placeholder="Contoh: * * * * *" />
                            <small class="text-muted">Isi jika workflow dijalankan secara terjadwal.</small>
                            </div>
                        </div>
                        <div class="mb-3 field-group">
                            <label class="field-label">Layanan Workflow</label>
                            <div class="field-wrap">
                                <select name="definition" id="definition" class="field-input" required>
                                    <option value="">Pilih layanan</option>
                                    <option value="email">Kirim Email Otomatis</option>
                                    <option value="crawling">Crawl Data</option>
                                </select>
                                <small>Sementara hanya tersedia layanan workflow email.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn-ghost" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn-accent">
                        Simpan Workflow
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const triggerType = document.getElementById('triggerType');
        const cronWrapper = document.getElementById('cronExpressionWrapper');

        triggerType.addEventListener('change', function () {
            if (this.value === 'cron') {
                cronWrapper.classList.remove('d-none');
            } else {
                cronWrapper.classList.add('d-none');
            }
        });
    });
</script>
@endsection
