/* ================================================
   Enseignant Dashboard — component styles
   Theme variables are in app.css
   ================================================ */

*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

/* Dark mode overrides (theme vars in app.css) */
html.dark thead tr {
    background: #232325;
}
html.dark tbody tr:hover {
    background: #323234;
}
html.dark td {
    border-top-color: #3A3A3C;
}
html.dark .nav-item.active {
    background: #0a2e54;
}
html.dark .badge-pending {
    background: #2e1f00 !important;
    color: #FFB340 !important;
}
html.dark .btn-secondary {
    background: #3A3A3C !important;
    color: var(--text-primary) !important;
    border-color: #3A3A3C !important;
}
html.dark .btn-secondary:hover {
    background: #484848 !important;
}
html.dark .modal {
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
}
html.dark .alert-success {
    background: #0d2e18;
    border-color: #1a5c30;
    color: #4CD964;
}
html.dark .alert-error {
    background: #2e0d0d;
    border-color: #5c1a1a;
    color: #FF6B6B;
}
html.dark .user-avatar-small {
    background: #48484A;
}
html.dark .badge-resolved {
    background: #0d2e18 !important;
    color: #4CD964 !important;
}
html.dark .btn-voir {
    background: #3A3A3C !important;
    color: var(--text-primary) !important;
}
html.dark .btn-voir:hover {
    background: #484848 !important;
}
html.dark .stat-card:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
}

body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background: var(--background);
    color: var(--text-primary);
    font-size: 15px;
    display: flex;
    height: 100vh;
    overflow: hidden;
}

/* Sidebar */
.sidebar {
    width: 240px;
    min-width: 240px;
    background: var(--surface);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    height: 100vh;
    overflow-y: auto;
}
.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    height: 64px;
    min-height: 64px;
    padding: 0 20px;
    border-bottom: 1px solid var(--border);
}
.sidebar-logo-icon {
    width: 32px;
    height: 32px;
    background: var(--primary);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.sidebar-logo-icon svg {
    width: 18px;
    height: 18px;
    stroke: white;
    stroke-width: 1.5;
    fill: none;
}
.sidebar-logo-text {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
}
.sidebar-nav {
    padding: 12px;
    flex: 1;
}
.nav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 10px;
    border-radius: 8px;
    cursor: pointer;
    color: var(--text-secondary);
    font-size: 14px;
    font-weight: 400;
    text-decoration: none;
    transition: background 0.15s, color 0.15s;
    margin-bottom: 2px;
}
.nav-item svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    stroke-width: 1.5;
    fill: none;
    flex-shrink: 0;
}
.nav-item:hover {
    background: var(--background);
    color: var(--text-primary);
}
.nav-item.active {
    background: #EBF3FD;
    color: var(--primary);
    font-weight: 500;
}
.nav-badge {
    margin-left: auto;
    background: var(--danger);
    color: white;
    font-size: 11px;
    font-weight: 600;
    border-radius: 10px;
    padding: 1px 7px;
    line-height: 1.6;
}
.sidebar-footer {
    padding: 16px 12px;
    border-top: 1px solid var(--border);
}
.sidebar-user {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 10px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.15s;
}
.sidebar-user:hover {
    background: var(--background);
}
.user-avatar-small {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #1D1D1F;
    color: white;
    font-size: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.sidebar-user-info {
    flex: 1;
    min-width: 0;
}
.sidebar-user-name {
    font-size: 13px;
    font-weight: 500;
    color: var(--text-primary);
}
.sidebar-user-role {
    font-size: 12px;
    color: var(--text-secondary);
}
.sidebar-user-more svg {
    width: 16px;
    height: 16px;
    stroke: var(--text-secondary);
    stroke-width: 1.5;
    fill: none;
}

/* Main layout */
.main {
    flex: 1;
    display: flex;
    flex-direction: column;
    height: 100vh;
    overflow: hidden;
}
.topbar {
    height: 64px;
    min-height: 64px;
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    padding: 0 28px;
    gap: 16px;
}
.topbar-title {
    font-size: 20px;
    font-weight: 600;
    color: var(--text-primary);
    flex: 1;
}
.topbar-search {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--background);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 0 12px;
    width: 220px;
    height: 36px;
}
.topbar-search svg {
    width: 15px;
    height: 15px;
    stroke: var(--text-secondary);
    stroke-width: 1.5;
    fill: none;
    flex-shrink: 0;
}
.topbar-search input {
    border: none;
    background: transparent;
    font-size: 13px;
    font-family: inherit;
    color: var(--text-primary);
    outline: none;
    width: 100%;
    padding: 0;
}
.topbar-search input::placeholder {
    color: var(--text-secondary);
}
.topbar-icon-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: var(--surface);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.15s;
    position: relative;
}
.topbar-icon-btn:hover {
    background: var(--background);
}
.topbar-icon-btn svg {
    width: 17px;
    height: 17px;
    stroke: var(--text-primary);
    stroke-width: 1.5;
    fill: none;
}
.notif-dot {
    position: absolute;
    top: 7px;
    right: 7px;
    width: 7px;
    height: 7px;
    background: var(--danger);
    border-radius: 50%;
    border: 1.5px solid var(--surface);
}
.toggle-btn {
    width: 44px;
    height: 24px;
    border-radius: 12px;
    background: var(--border);
    border: none;
    cursor: pointer;
    position: relative;
    transition: background 0.15s;
    flex-shrink: 0;
}
.toggle-btn.on {
    background: var(--primary);
}
.toggle-knob {
    position: absolute;
    top: 3px;
    left: 3px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: white;
    transition: transform 0.15s;
    display: block;
}
.toggle-btn.on .toggle-knob {
    transform: translateX(20px);
}

/* Content */
.content {
    flex: 1;
    overflow-y: auto;
    padding: 28px;
    background: var(--background);
}
.alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 14px;
    margin-bottom: 20px;
}
.alert svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    stroke-width: 1.5;
    fill: none;
    flex-shrink: 0;
}
.alert-success {
    background: #F0FBF4;
    border: 1px solid #A8E6BA;
    color: #1A7A34;
}
.alert-error {
    background: #FFF2F1;
    border: 1px solid #FFBDBA;
    color: #C0392B;
}

/* Cards */
.card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 20px;
}
.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    border-bottom: 1px solid var(--border);
}
.card-header-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
}
.card-header-sub {
    font-size: 13px;
    color: var(--text-secondary);
    margin-top: 2px;
}
.card-body {
    padding: 24px;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
}
thead tr {
    background: #FAFAFA;
}
th {
    font-size: 13px;
    font-weight: 500;
    color: var(--text-secondary);
    padding: 10px 20px;
    text-align: left;
    border-bottom: 1px solid var(--border);
    white-space: nowrap;
}
th.center,
td.center {
    text-align: center;
}
td {
    padding: 0 20px;
    height: 44px;
    font-size: 14px;
    color: var(--text-primary);
    border-top: 1px solid #E5E5EA;
    vertical-align: middle;
}
tbody tr {
    transition: background 0.15s;
}
tbody tr:hover {
    background: #F9F9FB;
}
.module-name {
    font-weight: 500;
    color: var(--text-primary);
}
.code-badge {
    font-size: 12px;
    color: var(--text-secondary);
    font-family: "SF Mono", monospace;
}
.grade-value {
    font-family: "SF Mono", monospace;
    font-size: 14px;
}
.grade-pass {
    color: var(--success);
    font-weight: 600;
}
.grade-warn {
    color: var(--warning);
    font-weight: 600;
}
.grade-fail {
    color: var(--danger);
    font-weight: 600;
}
.grade-empty {
    color: var(--text-secondary);
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    border: none;
    transition: background 0.15s;
    text-decoration: none;
    font-family: inherit;
}
.btn-primary {
    background: var(--primary);
    color: white;
}
.btn-primary:hover {
    background: var(--primary-hover);
}
.btn-secondary {
    background: var(--surface);
    border: 1px solid var(--border);
    color: var(--text-primary);
}
.btn-secondary:hover {
    background: var(--background);
}
.btn-voir {
    background: var(--surface);
    border: 1px solid var(--border);
    color: var(--text-primary);
    padding: 5px 12px;
    font-size: 12px;
    border-radius: 8px;
    cursor: pointer;
    font-family: inherit;
    font-weight: 500;
    transition: background 0.15s;
    display: inline-flex;
    align-items: center;
}
.btn-voir:hover {
    background: var(--background);
}

/* Badges */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}
.badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}
.badge-pending {
    background: #FFF8EC;
    color: #B25F00;
}
.badge-pending .badge-dot {
    background: var(--warning);
}
.badge-resolved {
    background: #F0FBF4;
    color: #1A7A34;
}
.badge-resolved .badge-dot {
    background: var(--success);
}

/* Empty state */
.empty-state {
    padding: 48px 24px;
    text-align: center;
    color: var(--text-secondary);
    font-size: 14px;
}
.empty-state svg {
    width: 36px;
    height: 36px;
    stroke: var(--border);
    stroke-width: 1.5;
    fill: none;
    margin: 0 auto 12px;
    display: block;
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.35);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 50;
}
.modal-overlay.open {
    display: flex;
}
.modal {
    background: var(--surface);
    border-radius: 12px;
    width: 100%;
    max-width: 480px;
    margin: 16px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
}
.modal-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 20px 24px 0;
}
.modal-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
}
.modal-sub {
    font-size: 13px;
    color: var(--text-secondary);
    margin-top: 3px;
    line-height: 1.5;
}
.modal-close {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    border: 1px solid var(--border);
    background: transparent;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-secondary);
    font-size: 16px;
    transition: background 0.15s;
}
.modal-close:hover {
    background: var(--background);
}
.modal-body {
    padding: 16px 24px 20px;
}
.modal-footer {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
    padding: 0 24px 20px;
}
.modal-note-row {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--background);
    border-radius: 8px;
    padding: 10px 14px;
    margin-bottom: 14px;
}
.modal-note-row svg {
    width: 15px;
    height: 15px;
    stroke: var(--text-secondary);
    stroke-width: 1.5;
    fill: none;
    flex-shrink: 0;
}
.modal-msg-box {
    font-size: 14px;
    color: var(--text-primary);
    line-height: 1.6;
    background: var(--background);
    border-radius: 8px;
    padding: 12px 14px;
    margin-bottom: 4px;
    white-space: pre-wrap;
}
.modal-textarea {
    width: 100%;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 14px;
    font-family: inherit;
    resize: none;
    color: var(--text-primary);
    background: var(--surface);
    outline: none;
    transition: border-color 0.15s;
}
.modal-textarea:focus {
    border-color: var(--primary);
}
.modal-textarea::placeholder {
    color: var(--text-secondary);
}

/* Welcome banner */
.welcome-banner {
    background: linear-gradient(135deg, #0071E3 0%, #0051a8 100%);
    border-radius: 12px;
    padding: 24px 28px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    overflow: hidden;
    position: relative;
}
.welcome-banner::before {
    content: '';
    position: absolute;
    right: -20px;
    top: -30px;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.06);
    pointer-events: none;
}
.welcome-banner::after {
    content: '';
    position: absolute;
    right: 60px;
    bottom: -50px;
    width: 130px;
    height: 130px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
    pointer-events: none;
}
.welcome-text-title {
    font-size: 18px;
    font-weight: 700;
    color: white;
    margin-bottom: 4px;
}
.welcome-text-sub {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.75);
}
.welcome-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    font-size: 18px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
}

/* Stats grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: box-shadow 0.15s;
}
.stat-card:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
}
.stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.stat-icon svg {
    width: 20px;
    height: 20px;
    stroke: white;
    stroke-width: 1.5;
    fill: none;
}
.stat-icon.blue {
    background: var(--primary);
}
.stat-icon.green {
    background: var(--success);
}
.stat-icon.orange {
    background: var(--warning);
}
.stat-icon.red {
    background: var(--danger);
}
.stat-value {
    font-size: 26px;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1;
    margin-bottom: 4px;
}
.stat-label {
    font-size: 13px;
    color: var(--text-secondary);
}

/* Section grid */
.section-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 24px;
}
@media (max-width: 900px) {
    .section-grid {
        grid-template-columns: 1fr;
    }
}

/* Module list */
.module-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 24px;
    border-top: 1px solid var(--border);
    transition: background 0.15s;
}
.module-item:first-child {
    border-top: none;
}
.module-item:hover {
    background: var(--background);
}
.module-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--primary);
    flex-shrink: 0;
}
.module-item-info {
    flex: 1;
    min-width: 0;
}
.module-item-name {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary);
}
.module-item-sem {
    font-size: 12px;
    color: var(--text-secondary);
    margin-top: 2px;
}
.module-item-count {
    font-size: 13px;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 4px;
}
.module-item-count svg {
    width: 13px;
    height: 13px;
    stroke: currentColor;
    stroke-width: 1.5;
    fill: none;
}

/* Grade repartition */
.rep-list {
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.rep-row {
    display: flex;
    align-items: center;
    gap: 12px;
}
.rep-label {
    width: 68px;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
}
.rep-label span {
    font-size: 13px;
    font-weight: 500;
    color: var(--text-primary);
}
.rep-label small {
    font-size: 11px;
    color: var(--text-secondary);
}
.rep-bar-wrap {
    flex: 1;
    height: 7px;
    background: var(--border);
    border-radius: 4px;
    overflow: hidden;
}
.rep-bar {
    height: 100%;
    border-radius: 4px;
    transition: width 0.5s ease;
}
.rep-bar-pass {
    background: var(--success);
}
.rep-bar-warn {
    background: var(--warning);
}
.rep-bar-fail {
    background: var(--danger);
}
.rep-count {
    width: 32px;
    text-align: right;
    font-size: 13px;
    font-weight: 600;
    flex-shrink: 0;
}
.rep-total {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 14px;
    border-top: 1px solid var(--border);
    font-size: 13px;
    color: var(--text-secondary);
}
.rep-total strong {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}

/* Reclamation table cells */
.etu-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}
.rec-msg {
    font-size: 13px;
    color: var(--text-secondary);
    max-width: 260px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Modules list — card grid */
.modules-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 16px;
    padding: 24px;
}
.module-card {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 20px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.module-card:hover {
    border-color: var(--primary);
    box-shadow: 0 4px 12px rgba(0, 113, 227, 0.12);
}
.module-card-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.module-card-icon svg {
    width: 20px;
    height: 20px;
    stroke: white;
    stroke-width: 1.5;
    fill: none;
}
.module-card-body {
    flex: 1;
    min-width: 0;
}
.module-card-name {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 2px;
}
.module-card-code {
    font-size: 12px;
    font-family: "SF Mono", monospace;
    color: var(--text-secondary);
    margin-bottom: 6px;
}
.module-card-meta {
    font-size: 12px;
    color: var(--text-secondary);
    margin-top: 2px;
}
.module-card-count {
    font-size: 12px;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}
.module-card-count svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    stroke-width: 1.5;
    fill: none;
}

/* Module detail — info block */
.module-detail-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.module-detail-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-secondary);
    text-decoration: none;
    margin-bottom: 16px;
}
.module-detail-back:hover {
    color: var(--primary);
}
.module-detail-back svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    stroke-width: 1.5;
    fill: none;
}
.module-detail-title {
    font-size: 22px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 4px;
}
.module-detail-code {
    font-size: 14px;
    font-family: "SF Mono", monospace;
    color: var(--text-secondary);
}
.module-detail-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.module-detail-info-item {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 14px 18px;
}
.module-detail-info-label {
    font-size: 12px;
    color: var(--text-secondary);
    margin-bottom: 4px;
}
.module-detail-info-value {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}
