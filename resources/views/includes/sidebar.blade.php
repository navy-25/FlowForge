<!-- ═══════════ SIDEBAR ═══════════ -->
<aside class="sidebar" id="sidebar">
    <a href="{{ route('admin.dashboard.index') }}" class="sb-brand">
        <div class="sb-brand-mark">
            <svg viewBox="0 0 14 14" fill="none">
                <path d="M2 7h3.5M7 2v3.5M7 7l3.5 3.5M7 7L3.5 10.5" stroke="#000" stroke-width="1.5" stroke-linecap="round" />
            </svg>
        </div>
        <span class="sb-brand-name">FlowForge</span>
    </a>
    <nav class="sb-nav">
        <div class="sb-section">// utama</div>
        <a href="{{ route('admin.dashboard.index') }}" class="sb-link @yield('sidebar-monitoring')">
            <i class="bi bi-grid-1x2"></i>
            <span>Monitoring</span>
        </a>
        <a href="{{ route('admin.workflow.index') }}" class="sb-link @yield('sidebar-workflow')">
            <i class="bi bi-diagram-3"></i>
            <span>Workflow</span>
            <span class="sb-badge">12</span>
        </a>
        <a href="{{ route('admin.history') }}" class="sb-link @yield('sidebar-history')">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat</span>
        </a>
        {{-- <div class="sb-section">// manajemen</div>
        <a href="#" class="sb-link">
            <i class="bi bi-people"></i>
            <span>Pengguna</span>
        </a>
        <a href="#" class="sb-link">
            <i class="bi bi-sliders"></i>
            <span>Pengaturan</span>
        </a> --}}
    </nav>
    <div class="sb-footer">
        <div class="sb-avatar">AD</div>
        <div class="sb-user-info">
            <div class="sb-user-name">Administrator</div>
            <div class="sb-user-role">Super Admin</div>
        </div>
        <a href="/" class="sb-logout" title="Keluar">
            <i class="bi bi-box-arrow-right"></i>
        </a>
    </div>
</aside>
