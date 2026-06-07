@extends('layouts.admin')

@section('page-title','History')
@section('sidebar-history','active')

@section('content')
<!-- Page header -->
<div class="page-head">
    <div>
        <div class="page-title">History</div>
        <div class="page-sub">Daftar aktivitas workflow</div>
    </div>
</div>
<!-- Main panels -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <table class="data-table" id="workflowTable">
                <thead>
                    <tr>
                        <th>Tenant</th>
                        <th>Nama Workflow</th>
                        <th>Version</th>
                        <th>Nama Aktivitas</th>
                        <th>Status Step</th>
                        <th>Konteks</th>
                        <th>Error Log</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $value)
                        {{-- {{ dd($value) }} --}}
                        {{-- node_step.workflow.user.tenant --}}
                        <tr>
                            <td>{{ $value->node_step->workflow->user->tenant->name }}</td>
                            <td>{{ $value->node_step->workflow->name }}</td>
                            <td>
                                <span class="pill pill-green">{{ $value->node_step->workflow->version }}</span>
                            </td>
                            <td class="text-capitalize">{{ str_replace('_', ' ', $value->node_id) }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2 text-capitalize">
                                    @if ($value->status == 'success')
                                        <i class="bi bi-check-lg" style="color:rgba(0,217,192,.08);color:var(--accent)"></i>
                                    @elseif ($value->status == 'failed')
                                        <i class="bi bi-exclamation-lg" style="color:rgba(255,77,106,.08);color:var(--accent-4)"></i>
                                    @elseif ($value->status == 'running')
                                        <i class="bi bi-clock" style="color:rgba(245,166,35,.08);color:var(--accent-3)"></i>
                                    @endif
                                    {{ $value->status }}
                                </div>
                            </td>
                            <td>{{ $value->output }}</td>
                            <td>{{ $value->error ?? '-' }}</td>
                            <td>{{ diffForHuman($value->created_at) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        const table = $('#workflowTable').DataTable({
            pageLength: 10,
            ordering: true,
            searching: true,
            lengthChange: true,
            info: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                zeroRecords: "Data tidak ditemukan",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "→",
                    previous: "←"
                }
            }
        });

        $('#workflowTable tbody').on('click', 'tr', function () {
            $(this).toggleClass('selected');
        });
    });
</script>
@endsection
