@extends('layouts.admin')

@section('page-title','Monitoring')
@section('sidebar-monitoring','active')

@section('content')
<!-- Page header -->
<div class="page-head">
    <div>
        <div class="page-title">Monitoring</div>
        <div class="page-sub">Status sistem &amp; aktivitas real-time</div>
    </div>
    <div class="page-actions">
        <a class="btn-ghost text-decoration-none" target="_blank" href="/docs/api">
            <i class="bi bi-plus"></i> Dokumentasi API</a>
        <a class="btn-accent text-decoration-none" href="{{ route('admin.workflow.index') }}">
            <i class="bi bi-plus"></i> Workflow Baru </a>
    </div>
</div>
<!-- Stat cards -->
<div class="stat-grid">
    <div class="stat-card card-teal fade-in">
        <div class="sc-top">
            <div class="sc-icon">
                <i class="bi bi-lightning-charge-fill"></i>
            </div>
            <div class="sc-value">{{ $data['active_workflows'] }}</div>
        </div>
        <div class="sc-label">Workflow Aktif</div>
        <div class="sc-bar"></div>
    </div>
    <div class="stat-card card-blue fade-in">
        <div class="sc-top">
            <div class="sc-icon">
                <i class="bi bi-check2-circle"></i>
            </div>
            <div class="sc-value">{{ $data['completed_workflows'] }}</div>
        </div>
        <div class="sc-label">Tugas Selesai</div>
        <div class="sc-bar"></div>
    </div>
    <div class="stat-card card-amber fade-in">
        <div class="sc-top">
            <div class="sc-icon">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="sc-value">{{ $data['running_workflows'] }}</div>
        </div>
        <div class="sc-label">Berjalan</div>
        <div class="sc-bar"></div>
    </div>
    <div class="stat-card card-red fade-in">
        <div class="sc-top">
            <div class="sc-icon">
                <i class="bi bi-x-circle"></i>
            </div>
            <div class="sc-value">{{ $data['failed_workflows'] }}</div>
        </div>
        <div class="sc-label">Gagal / Error</div>
        <div class="sc-bar"></div>
    </div>
</div>
<!-- Main panels -->
<div class="panels">
    <!-- Activity table -->
    <div class="panel">
        <div class="panel-head">
            <div class="panel-title">
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
                @foreach ($last_activity as $key => $value)
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
    <div class="panel">
        <div class="panel-head">
            <div class="panel-title">
                <i class="bi bi-rss"></i> Log Sistem
            </div>
        </div>
        <div class="activity-list">
            @foreach ($log_workflow as $key => $value)
                <div class="activity-item">
                    @if ($value->status == 'success')
                        <div class="act-icon" style="background:rgba(0,217,192,.08);color:var(--accent)">
                            <i class="bi bi-check-lg"></i>
                        </div>
                    @elseif ($value->status == 'failed')
                        <div class="act-icon" style="background:rgba(255,77,106,.08);color:var(--accent-4)">
                            <i class="bi bi-exclamation-lg"></i>
                        </div>
                    @elseif ($value->status == 'running')
                        <div class="act-icon" style="background:rgba(245,166,35,.08);color:var(--accent-3)">
                            <i class="bi bi-clock"></i>
                        </div>
                    @endif
                    <div class="act-body">
                        @php
                            $messages = $value->output ? json_decode($value->output) : $value->error;
                            $type = gettype($messages);
                        @endphp
                        <div class="act-title text-capitalize">{{str_replace('_', ' ', $value->node_id) }} -
                            @if ($type == 'object')
                                @foreach ($messages as $item => $message)
                                    @if ($item != 'message')
                                        {{ $item }}
                                    @endif
                                    {{ $message == null ? 'Sedang diproses' : $message }}
                                @endforeach
                            @else
                                {{ $messages }}
                            @endif
                        </div>
                        <div class="act-meta text-capitalize">{{ $value->status }} #{{ $value->id }} · {{ diffForHuman($value->created_at) }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Donut chart -->
    <div class="panel">
        <div class="panel-head">
            <div class="panel-title">
                <i class="bi bi-pie-chart"></i> Distribusi Status
            </div>
        </div>
        <div class="donut-wrap">
            <div style="height: 260px;">
                <canvas id="workflowDoughnutChart"></canvas>
            </div>
            <div class="donut-legend">
                <div class="legend-row">
                    <div class="legend-dot" style="background:var(--accent)"></div>
                    <span class="legend-label">Selesai</span>
                    <span class="legend-val">{{ $data['completed_percentage'] }}%</span>
                </div>
                <div class="legend-row">
                    <div class="legend-dot" style="background:var(--accent-2)"></div>
                    <span class="legend-label">Berjalan</span>
                    <span class="legend-val">{{ $data['running_percentage'] }}%</span>
                </div>
                <div class="legend-row">
                    <div class="legend-dot" style="background:var(--accent-4)"></div>
                    <span class="legend-label">Gagal</span>
                    <span class="legend-val">{{ $data['failed_percentage'] }}%</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('workflowDoughnutChart');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Failed', 'Running'],
            datasets: [{
                data: [
                    {{ $data['completed_workflows'] ?? 0 }},
                    {{ $data['failed_workflows'] ?? 0 }},
                    {{ $data['running_workflows'] ?? 0 }}
                ],
                backgroundColor: [
                    '#00d9c0',
                    '#ff4d6a',
                    '#f5a623'
                ],
                borderColor: '#111114',
                borderWidth: 3,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            cutout: '72%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#ededf5',
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 18
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const value = context.raw;
                            const percentage = total > 0
                                ? ((value / total) * 100).toFixed(1)
                                : 0;

                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
