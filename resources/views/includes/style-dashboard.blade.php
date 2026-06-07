<style>
    :root {
        --bg-base: #0a0a0c;
        --bg-sidebar: #0d0d10;
        --bg-panel: #111114;
        --bg-raised: #18181d;
        --bg-hover: #1e1e25;
        --border: #1e1e28;
        --border-lit: #2e2e40;
        --accent: #00d9c0;
        --accent-dim: rgba(0, 217, 192, .10);
        --accent-glow: rgba(0, 217, 192, .2);
        --accent-2: #4d7cfe;
        --accent-3: #f5a623;
        --accent-4: #ff4d6a;
        --text-hi: #ededf5;
        --text-mid: #7070a0;
        --text-lo: #363650;
        --sidebar-w: 228px;
        --nav-h: 56px;
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
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
        height: 100vh;
        overflow: hidden;
    }

    /* ════════════════════════════
SHELL
════════════════════════════ */
    .shell {
        display: flex;
        height: 100vh;
    }

    /* ════════════════════════════
SIDEBAR
════════════════════════════ */
    .sidebar {
        width: var(--sidebar-w);
        background: var(--bg-sidebar);
        border-right: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        transition: transform .25s var(--ease);
        z-index: 400;
    }

    /* Brand */
    .sb-brand {
        height: var(--nav-h);
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 18px;
        border-bottom: 1px solid var(--border);
        text-decoration: none;
    }

    .sb-brand-mark {
        width: 28px;
        height: 28px;
        background: var(--accent);
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .sb-brand-mark svg {
        width: 14px;
        height: 14px;
    }

    .sb-brand-name {
        font-family: var(--ff-mono);
        font-size: .85rem;
        font-weight: 500;
        color: var(--text-hi);
        letter-spacing: -.01em;
    }

    /* Nav */
    .sb-nav {
        flex: 1;
        padding: 16px 10px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 1px;
    }

    .sb-section {
        font-family: var(--ff-mono);
        font-size: 9px;
        font-weight: 500;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--text-lo);
        padding: 14px 10px 6px;
    }

    .sb-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 10px;
        border-radius: var(--radius-sm);
        color: var(--text-mid);
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 500;
        transition: background .15s, color .15s;
        position: relative;
    }

    .sb-link i {
        font-size: 15px;
        width: 16px;
        text-align: center;
        flex-shrink: 0;
    }

    .sb-link .sb-badge {
        margin-left: auto;
        font-family: var(--ff-mono);
        font-size: 10px;
        background: var(--bg-raised);
        color: var(--text-mid);
        border-radius: 4px;
        padding: 1px 6px;
    }

    .sb-link:hover {
        background: var(--bg-hover);
        color: var(--text-hi);
    }

    .sb-link.active {
        background: var(--accent-dim);
        color: var(--accent);
    }

    .sb-link.active i {
        color: var(--accent);
    }

    .sb-link.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 6px;
        bottom: 6px;
        width: 2.5px;
        background: var(--accent);
        border-radius: 0 3px 3px 0;
    }

    /* Sidebar footer */
    .sb-footer {
        padding: 14px 18px;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sb-avatar {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: var(--bg-raised);
        border: 1px solid var(--border-lit);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--ff-mono);
        font-size: 12px;
        color: var(--accent);
        font-weight: 500;
        flex-shrink: 0;
    }

    .sb-user-info {
        flex: 1;
        min-width: 0;
    }

    .sb-user-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-hi);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sb-user-role {
        font-size: 11px;
        color: var(--text-mid);
    }

    .sb-logout {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        background: none;
        border: 1px solid var(--border-lit);
        color: var(--text-mid);
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .15s, color .15s, border-color .15s;
        text-decoration: none;
    }

    .sb-logout:hover {
        background: rgba(255, 77, 106, .12);
        border-color: rgba(255, 77, 106, .3);
        color: var(--accent-4);
    }

    /* ════════════════════════════
OVERLAY (mobile)
════════════════════════════ */
    .overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .6);
        z-index: 390;
        backdrop-filter: blur(2px);
    }

    /* ════════════════════════════
MAIN
════════════════════════════ */
    .main {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        min-width: 0;
    }

    /* ── Topbar ── */
    .topbar {
        height: var(--nav-h);
        background: var(--bg-sidebar);
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        padding: 0 24px;
        gap: 14px;
        flex-shrink: 0;
    }

    .topbar-toggle {
        display: none;
        width: 32px;
        height: 32px;
        background: var(--bg-raised);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        color: var(--text-mid);
        font-size: 16px;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background .15s;
        flex-shrink: 0;
    }

    .topbar-toggle:hover {
        background: var(--bg-hover);
    }

    .topbar-path {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: var(--ff-mono);
        font-size: 12px;
        color: var(--text-mid);
    }

    .topbar-path span.active {
        color: var(--text-hi);
    }

    .topbar-path i {
        font-size: 10px;
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tb-btn {
        width: 32px;
        height: 32px;
        background: var(--bg-raised);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        color: var(--text-mid);
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background .15s, color .15s;
        position: relative;
        text-decoration: none;
    }

    .tb-btn:hover {
        background: var(--bg-hover);
        color: var(--text-hi);
    }

    .tb-btn .dot {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 6px;
        height: 6px;
        background: var(--accent-4);
        border-radius: 50%;
        border: 1.5px solid var(--bg-sidebar);
    }

    .tb-divider {
        width: 1px;
        height: 20px;
        background: var(--border);
    }

    .tb-time {
        font-family: var(--ff-mono);
        font-size: 11px;
        color: var(--text-mid);
    }

    /* ── Content ── */
    .content {
        flex: 1;
        overflow-y: auto;
        padding: 28px 28px 40px;
    }

    /* ── Page header ── */
    .page-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 28px;
        gap: 16px;
    }

    .page-title {
        font-size: 1.35rem;
        font-weight: 600;
        color: var(--text-hi);
        letter-spacing: -.02em;
        margin-bottom: 3px;
    }

    .page-sub {
        font-size: 12.5px;
        color: var(--text-mid);
    }

    .page-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }

    .btn-ghost {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: var(--bg-raised);
        border: 1px solid var(--border-lit);
        border-radius: var(--radius-sm);
        color: var(--text-mid);
        font-family: var(--ff-sans);
        font-size: 12.5px;
        font-weight: 500;
        cursor: pointer;
        transition: background .15s, color .15s;
        text-decoration: none;
    }

    .btn-ghost:hover {
        background: var(--bg-hover);
        color: var(--text-hi);
    }

    .btn-accent {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: var(--accent);
        border: none;
        border-radius: var(--radius-sm);
        color: #000;
        font-family: var(--ff-sans);
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        transition: opacity .15s;
        text-decoration: none;
    }

    .btn-accent:hover {
        opacity: .85;
        color: #000;
    }

    /* ════════════════════════════
STAT CARDS
════════════════════════════ */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: var(--bg-panel);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 20px;
        position: relative;
        overflow: hidden;
        transition: border-color .2s, transform .2s;
    }

    .stat-card:hover {
        border-color: var(--border-lit);
        transform: translateY(-1px);
    }

    .stat-card .sc-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .sc-icon {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .sc-trend {
        font-family: var(--ff-mono);
        font-size: 11px;
        font-weight: 500;
        padding: 3px 8px;
        border-radius: 5px;
    }

    .sc-value {
        font-family: var(--ff-mono);
        font-size: 1.75rem;
        font-weight: 500;
        color: var(--text-hi);
        line-height: 1;
        margin-bottom: 5px;
    }

    .sc-label {
        font-size: 12px;
        color: var(--text-mid);
    }

    .sc-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
    }

    /* Card variants */
    .card-teal .sc-icon {
        background: rgba(0, 217, 192, .1);
        color: var(--accent);
    }

    .card-teal .sc-trend {
        background: rgba(0, 217, 192, .1);
        color: var(--accent);
    }

    .card-teal .sc-bar {
        background: linear-gradient(90deg, transparent, var(--accent));
    }

    .card-blue .sc-icon {
        background: rgba(77, 124, 254, .1);
        color: var(--accent-2);
    }

    .card-blue .sc-trend {
        background: rgba(77, 124, 254, .1);
        color: var(--accent-2);
    }

    .card-blue .sc-bar {
        background: linear-gradient(90deg, transparent, var(--accent-2));
    }

    .card-amber .sc-icon {
        background: rgba(245, 166, 35, .1);
        color: var(--accent-3);
    }

    .card-amber .sc-trend {
        background: rgba(245, 166, 35, .1);
        color: var(--accent-3);
    }

    .card-amber .sc-bar {
        background: linear-gradient(90deg, transparent, var(--accent-3));
    }

    .card-red .sc-icon {
        background: rgba(255, 77, 106, .1);
        color: var(--accent-4);
    }

    .card-red .sc-trend {
        background: rgba(255, 77, 106, .1);
        color: var(--accent-4);
    }

    .card-red .sc-bar {
        background: linear-gradient(90deg, transparent, var(--accent-4));
    }

    /* ════════════════════════════
PANELS
════════════════════════════ */
    .panels {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 14px;
    }

    .panel, .card {
        background: var(--bg-panel);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        overflow: hidden;
    }

    .panel-head, .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
    }

    .panel-title, .card-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-hi);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .panel-title i, .card-title i {
        font-size: 14px;
        color: var(--text-mid);
    }

    .panel-meta, .card-meta {
        font-family: var(--ff-mono);
        font-size: 11px;
        color: var(--text-mid);
    }

    /* ── Table ── */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead tr {
        border-bottom: 1px solid var(--border);
    }

    .data-table thead th {
        padding: 10px 20px;
        text-align: left;
        font-family: var(--ff-mono);
        font-size: 10px;
        font-weight: 500;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--text-lo);
    }

    .data-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .12s;
    }

    .data-table tbody tr:last-child {
        border-bottom: none;
    }

    .data-table tbody tr:hover {
        background: var(--bg-raised);
    }

    .data-table tbody td {
        padding: 13px 20px;
        font-size: 13px;
        color: var(--text-mid);
        vertical-align: middle;
    }

    .data-table tbody td:first-child {
        color: var(--text-hi);
        font-weight: 500;
    }

    .pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 9px;
        border-radius: 5px;
        font-family: var(--ff-mono);
        font-size: 11px;
        font-weight: 500;
    }

    .pill::before {
        content: '';
        width: 5px;
        height: 5px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .pill-green {
        background: rgba(0, 217, 192, .08);
        color: var(--accent);
    }

    .pill-green::before {
        background: var(--accent);
    }

    .pill-blue {
        background: rgba(77, 124, 254, .08);
        color: var(--accent-2);
    }

    .pill-blue::before {
        background: var(--accent-2);
    }

    .pill-amber {
        background: rgba(245, 166, 35, .08);
        color: var(--accent-3);
    }

    .pill-amber::before {
        background: var(--accent-3);
    }

    .pill-red {
        background: rgba(255, 77, 106, .08);
        color: var(--accent-4);
    }

    .pill-red::before {
        background: var(--accent-4);
    }

    /* ── Side panel ── */
    .side-panels {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    /* Gauge / donut */
    .donut-wrap {
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .donut-svg {
        overflow: visible;
    }

    .donut-text-val {
        font-family: var(--ff-mono);
        font-size: 22px;
        font-weight: 500;
        fill: var(--text-hi);
    }

    .donut-text-lbl {
        font-size: 11px;
        fill: var(--text-mid);
        font-family: var(--ff-sans);
    }

    .donut-legend {
        width: 100%;
        margin-top: 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .legend-row {
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 12px;
    }

    .legend-dot {
        width: 8px;
        height: 8px;
        border-radius: 2px;
        flex-shrink: 0;
    }

    .legend-label {
        color: var(--text-mid);
        flex: 1;
    }

    .legend-val {
        font-family: var(--ff-mono);
        font-size: 12px;
        color: var(--text-hi);
    }

    /* Activity feed */
    .activity-list {
        padding: 6px 0;
    }

    .activity-item {
        display: flex;
        gap: 12px;
        padding: 12px 20px;
        transition: background .12s;
    }

    .activity-item:hover {
        background: var(--bg-raised);
    }

    .act-icon {
        width: 30px;
        height: 30px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .act-body {
        flex: 1;
        min-width: 0;
    }

    .act-title {
        font-size: 13px;
        color: var(--text-hi);
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .act-meta {
        font-family: var(--ff-mono);
        font-size: 11px;
        color: var(--text-mid);
        margin-top: 2px;
    }

    /* ════════════════════════════
SCROLLBAR
════════════════════════════ */
    ::-webkit-scrollbar {
        width: 5px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--border-lit);
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--text-lo);
    }

    /* ════════════════════════════
RESPONSIVE
════════════════════════════ */
    @media (max-width: 1100px) {
        .panels {
            grid-template-columns: 1fr;
        }

        .side-panels {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 900px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            transform: translateX(-100%);
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .overlay.open {
            display: block;
        }

        .topbar-toggle {
            display: flex;
        }

        .content {
            padding: 18px 16px 32px;
        }
    }

    @media (max-width: 520px) {
        .stat-grid {
            grid-template-columns: 1fr 1fr;
        }

        .side-panels {
            grid-template-columns: 1fr;
        }

        .page-actions {
            display: none;
        }
    }

    /* ════════════════════════════
ANIMATE IN
════════════════════════════ */
    .fade-in {
        animation: fadeUp .4s var(--ease) both;
    }

    .fade-in:nth-child(1) {
        animation-delay: .05s;
    }

    .fade-in:nth-child(2) {
        animation-delay: .1s;
    }

    .fade-in:nth-child(3) {
        animation-delay: .15s;
    }

    .fade-in:nth-child(4) {
        animation-delay: .2s;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
