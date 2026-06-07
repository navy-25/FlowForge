
<style>
    :root {
        --bg-base: #0a0a0c;
        --bg-panel: #111114;
        --bg-raised: #18181d;
        --border: #252530;
        --border-lit: #35354a;
        --accent: #00d9c0;
        --accent-dim: rgba(0, 217, 192, .12);
        --accent-glow: rgba(0, 217, 192, .25);
        --text-hi: #f0f0f5;
        --text-mid: #8888a0;
        --text-lo: #44445a;
        --danger: #ff4d6a;
        --ff-mono: 'DM Mono', monospace;
        --ff-sans: 'DM Sans', sans-serif;
        --ease: cubic-bezier(.4, 0, .2, 1);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: var(--ff-sans);
        background: var(--bg-base);
        color: var(--text-hi);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    /* ── Animated grid background ── */
    .bg-grid {
        position: fixed;
        inset: 0;
        z-index: 0;
        background-image:
            linear-gradient(rgba(0, 217, 192, .03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 217, 192, .03) 1px, transparent 1px);
        background-size: 48px 48px;
    }

    .bg-glow {
        position: fixed;
        width: 600px;
        height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(0, 217, 192, .06) 0%, transparent 70%);
        top: -200px;
        left: -150px;
        pointer-events: none;
        z-index: 0;
    }

    .bg-glow-2 {
        position: fixed;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(0, 80, 200, .07) 0%, transparent 70%);
        bottom: -100px;
        right: -100px;
        pointer-events: none;
        z-index: 0;
    }

    /* ── Wrapper ── */
    .login-wrapper {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 420px;
        padding: 24px;
        animation: fadeUp .5s var(--ease) both;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(24px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ── Brand ── */
    .brand {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 36px;
    }

    .brand-mark {
        width: 36px;
        height: 36px;
        background: var(--accent);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .brand-mark svg {
        width: 18px;
        height: 18px;
    }

    .brand-name {
        font-family: var(--ff-mono);
        font-size: 1.1rem;
        font-weight: 500;
        color: var(--text-hi);
        letter-spacing: -.02em;
    }

    /* ── Card ── */
    .login-card {
        background: var(--bg-panel);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 36px;
        position: relative;
        overflow: hidden;
    }

    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--accent), transparent);
        opacity: .6;
    }

    .card-tag {
        font-family: var(--ff-mono);
        font-size: 10px;
        color: var(--accent);
        letter-spacing: .12em;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-hi);
        margin-bottom: 6px;
        letter-spacing: -.02em;
    }

    .card-sub {
        font-size: 13px;
        color: var(--text-mid);
        margin-bottom: 32px;
    }

    /* ── Form ── */
    .field-group {
        margin-bottom: 18px;
    }

    .field-label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: var(--text-mid);
        margin-bottom: 8px;
    }

    .field-wrap {
        position: relative;
    }

    .field-wrap i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 15px;
        color: var(--text-lo);
        pointer-events: none;
        transition: color .2s;
    }

    .field-input {
        width: 100%;
        background: var(--bg-raised);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 12px 14px 12px 42px;
        color: var(--text-hi);
        font-family: var(--ff-sans);
        font-size: 14px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        -webkit-appearance: none;
    }

    .field-input::placeholder {
        color: var(--text-lo);
    }

    .field-input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-dim);
    }

    .field-input:focus+i,
    .field-wrap:focus-within i {
        color: var(--accent);
    }

    /* icon inside uses sibling, reorder for CSS trick */
    .field-wrap .field-input {
        order: 1;
    }

    .field-wrap i {
        order: 0;
    }

    .eye-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-lo);
        cursor: pointer;
        font-size: 15px;
        padding: 4px;
        transition: color .2s;
    }

    .eye-btn:hover {
        color: var(--text-mid);
    }

    .forgot-row {
        display: flex;
        justify-content: flex-end;
        margin-top: -6px;
        margin-bottom: 24px;
    }

    .forgot-link {
        font-size: 12px;
        color: var(--text-mid);
        text-decoration: none;
        transition: color .2s;
    }

    .forgot-link:hover {
        color: var(--accent);
    }

    /* ── Button ── */
    .btn-login {
        width: 100%;
        background: var(--accent);
        color: #000;
        border: none;
        border-radius: 10px;
        padding: 13px;
        font-family: var(--ff-sans);
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        letter-spacing: .01em;
        position: relative;
        overflow: hidden;
        transition: opacity .2s, transform .15s;
    }

    .btn-login:hover {
        opacity: .88;
        transform: translateY(-1px);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .btn-login::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, .15), transparent);
    }

    /* ── Divider ── */
    .divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 24px 0;
        font-size: 11px;
        color: var(--text-lo);
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    /* ── Footer note ── */
    .login-foot {
        margin-top: 24px;
        text-align: center;
        font-size: 12px;
        color: var(--text-lo);
    }

    /* ── Status strip ── */
    .status-strip {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
        font-size: 11px;
        color: var(--text-mid);
        font-family: var(--ff-mono);
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--accent);
        box-shadow: 0 0 6px var(--accent-glow);
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: .4;
        }
    }
</style>
