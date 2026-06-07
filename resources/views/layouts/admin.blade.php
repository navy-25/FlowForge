<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>FlowForge</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />

        @include('includes.style-dashboard')
    </head>
    <body>
        <div class="shell">
            @include('includes.sidebar')
            <!-- overlay -->
            <div class="overlay" id="overlay"></div>
            <!-- ═══════════ MAIN ═══════════ -->
            <div class="main">
                <!-- Topbar -->
                <header class="topbar">
                    <button class="topbar-toggle" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="topbar-path">
                        <span>FlowForge</span>
                        <i class="bi bi-chevron-right"></i>
                        <span class="active">@yield('page-title')</span>
                    </div>
                    <div class="topbar-right">
                        <span class="tb-time" id="clock">—</span>
                        {{-- <div class="tb-divider"></div>
                        <div class="tb-btn">
                            <i class="bi bi-bell"></i>
                            <span class="dot"></span>
                        </div>
                        <div class="tb-btn">
                            <i class="bi bi-terminal"></i>
                        </div> --}}
                    </div>
                </header>
                <!-- Content -->
                <main class="content">
                    @yield('content')
                </main>
            </div>
            <!-- /main -->
        </div>
        <!-- /shell -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script><script>
            // Clock
            (function tick() {
                var el = document.getElementById('clock');
                var now = new Date();
                el.textContent = now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
                setTimeout(tick, 1000);
            })();
            // Sidebar toggle
            var toggle = document.getElementById('sidebarToggle');
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('overlay');
            toggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('open');
            });
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
            });
            // pulse keyframe for live dot
            var style = document.createElement('style');
            style.textContent = '@keyframes pulse{0%,100%{opacity:1}50%{opacity:.3}}';
            document.head.appendChild(style);
        </script>

        @yield('scripts')
    </body>
</html>
