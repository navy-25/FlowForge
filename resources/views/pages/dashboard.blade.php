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
        <button class="btn-ghost">
            <i class="bi bi-arrow-clockwise"></i> Refresh </button>
        <button class="btn-accent">
            <i class="bi bi-plus"></i> Workflow Baru </button>
    </div>
</div>
<!-- Stat cards -->
<div class="stat-grid">
    <div class="stat-card card-teal fade-in">
        <div class="sc-top">
            <div class="sc-icon">
                <i class="bi bi-lightning-charge-fill"></i>
            </div>
            <span class="sc-trend">↑ 12%</span>
        </div>
        <div class="sc-value">{{ $data['active_workflows'] }}</div>
        <div class="sc-label">Workflow Aktif</div>
        <div class="sc-bar"></div>
    </div>
    <div class="stat-card card-blue fade-in">
        <div class="sc-top">
            <div class="sc-icon">
                <i class="bi bi-check2-circle"></i>
            </div>
            <span class="sc-trend">↑ ---</span>
        </div>
        <div class="sc-value">---</div>
        <div class="sc-label">Tugas Selesai</div>
        <div class="sc-bar"></div>
    </div>
    <div class="stat-card card-amber fade-in">
        <div class="sc-top">
            <div class="sc-icon">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <span class="sc-trend">→ ---</span>
        </div>
        <div class="sc-value">---</div>
        <div class="sc-label">Menunggu Review</div>
        <div class="sc-bar"></div>
    </div>
    <div class="stat-card card-red fade-in">
        <div class="sc-top">
            <div class="sc-icon">
                <i class="bi bi-x-circle"></i>
            </div>
            <span class="sc-trend">↓ ---</span>
        </div>
        <div class="sc-value">---</div>
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
    <!-- Side panels -->
    <div class="side-panels">
        <!-- Donut chart -->
        <div class="panel">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="bi bi-pie-chart"></i> Distribusi Status
                </div>
            </div>
            <div class="donut-wrap">
                <svg class="donut-svg" width="140" height="140" viewBox="0 0 140 140">
                    <!-- bg ring -->
                    <circle cx="70" cy="70" r="52" fill="none" stroke="#1e1e28" stroke-width="18" />
                    <!-- segments (circumference = 2π×52 ≈ 326.7) -->
                    <!-- green: 86% = 280.9 -->
                    <circle cx="70" cy="70" r="52" fill="none" stroke="#00d9c0" stroke-width="18" stroke-dasharray="281 326.7" stroke-dashoffset="81.7" stroke-linecap="butt" transform="rotate(-90 70 70)" />
                    <!-- blue: 9% = 29.4 -->
                    <circle cx="70" cy="70" r="52" fill="none" stroke="#4d7cfe" stroke-width="18" stroke-dasharray="29.4 326.7" stroke-dashoffset="-199.3" stroke-linecap="butt" transform="rotate(-90 70 70)" />
                    <!-- red: 5% = 16.3 -->
                    <circle cx="70" cy="70" r="52" fill="none" stroke="#ff4d6a" stroke-width="18" stroke-dasharray="16.3 326.7" stroke-dashoffset="-228.7" stroke-linecap="butt" transform="rotate(-90 70 70)" />
                    <!-- center text -->
                    <text x="70" y="66" text-anchor="middle" class="donut-text-val">86%</text>
                    <text x="70" y="82" text-anchor="middle" class="donut-text-lbl">Sukses</text>
                </svg>
                <div class="donut-legend">
                    <div class="legend-row">
                        <div class="legend-dot" style="background:var(--accent)"></div>
                        <span class="legend-label">Selesai</span>
                        <span class="legend-val">86%</span>
                    </div>
                    <div class="legend-row">
                        <div class="legend-dot" style="background:var(--accent-2)"></div>
                        <span class="legend-label">Berjalan</span>
                        <span class="legend-val">9%</span>
                    </div>
                    <div class="legend-row">
                        <div class="legend-dot" style="background:var(--accent-4)"></div>
                        <span class="legend-label">Gagal</span>
                        <span class="legend-val">5%</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Quick feed -->
        <div class="panel">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="bi bi-rss"></i> Log Sistem
                </div>
                <span class="panel-meta" style="display:flex;align-items:center;gap:5px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:var(--accent);display:inline-block;animation:pulse 2s infinite;box-shadow:0 0 5px var(--accent-glow)"></span> Live </span>
            </div>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="act-icon" style="background:rgba(0,217,192,.08);color:var(--accent)">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <div class="act-body">
                        <div class="act-title">Workflow berhasil dijalankan</div>
                        <div class="act-meta">Approval #128 · 2 mnt lalu</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="act-icon" style="background:rgba(255,77,106,.08);color:var(--accent-4)">
                        <i class="bi bi-exclamation-lg"></i>
                    </div>
                    <div class="act-body">
                        <div class="act-title">Koneksi database timeout</div>
                        <div class="act-meta">Sistem · 18 mnt lalu</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="act-icon" style="background:rgba(77,124,254,.08);color:var(--accent-2)">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <div class="act-body">
                        <div class="act-title">Pengguna baru ditambahkan</div>
                        <div class="act-meta">Admin · 1 jam lalu</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="act-icon" style="background:rgba(245,166,35,.08);color:var(--accent-3)">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="act-body">
                        <div class="act-title">Jadwal backup diperbarui</div>
                        <div class="act-meta">Cron · 2 jam lalu</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
