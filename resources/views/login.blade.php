<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>FlowForge — Masuk</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />

        @include('includes.style-auth')
    </head>
    <body>
        <div class="bg-grid"></div>
        <div class="bg-glow"></div>
        <div class="bg-glow-2"></div>
        <div class="login-wrapper">
            <div class="brand">
                <div class="brand-mark">
                    <svg viewBox="0 0 18 18" fill="none">
                        <path d="M3 9h4.5M9 3v4.5M9 9l4.5 4.5M9 9l-4.5 4.5" stroke="#000" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                </div>
                <span class="brand-name">FlowForge</span>
            </div>
            <div class="login-card">
                <div class="card-tag">// sistem masuk</div>
                <h1 class="card-title">Selamat datang kembali</h1>
                <p class="card-sub">Masuk ke panel admin FlowForge.</p>
                <div class="field-group"><label class="field-label">Email</label>
                    <div class="field-wrap">
                        <input class="field-input" type="email"  placeholder="admin@flowforge.id" value="admin@flowforge.id" autocomplete="email" />
                        <i class="bi bi-envelope"></i>
                    </div>
                </div>
                <div class="field-group"><label class="field-label">Password</label>
                    <div class="field-wrap">
                        <input class="field-input" type="password" id="passInput" placeholder="••••••••" value="admin123" autocomplete="current-password" />
                        <i class="bi bi-lock"></i>
                        <button class="eye-btn" onclick="togglePass()" tabindex="-1" type="button">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
                <div class="forgot-row">
                    <a href="#" class="forgot-link">Lupa password?</a>
                </div>
                <a class="btn-login text-decoration-none" href="{{ route('admin.dashboard.index') }}"> Masuk ke Dashboard </a>
                {{-- <button class="btn-login" type="submit" > Masuk ke Dashboard </button> --}}
                <div class="status-strip">
                    <span class="status-dot"></span>
                        Sistem online &nbsp;·&nbsp; v1.0.0
                    </div>
            </div>
            <div class="login-foot"> &copy; 2025 FlowForge. Hak cipta dilindungi. </div>
        </div>
        <script>
            function togglePass() {
                var inp = document.getElementById('passInput');
                var ico = document.getElementById('eyeIcon');
                if (inp.type === 'password') {
                    inp.type = 'text';
                    ico.className = 'bi bi-eye-slash';
                } else {
                    inp.type = 'password';
                    ico.className = 'bi bi-eye';
                }
            }
        </script>
    </body>
</html>
