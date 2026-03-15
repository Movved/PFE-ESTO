<!DOCTYPE html>
<html lang="fr">
<head>
    <script>if (localStorage.getItem('theme') === 'dark') { document.documentElement.classList.add('dark'); }</script>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Logs</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}
        .page-title{font-size:20px;font-weight:600;color:var(--text-primary)}
        .page-sub{font-size:13px;color:var(--text-secondary);margin-top:2px}
        .card{background:var(--surface);border:1px solid var(--border);border-radius:12px;overflow:hidden}
        .card-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border)}
        .card-title{font-size:14px;font-weight:600;color:var(--text-primary)}
        .card-sub{font-size:12px;color:var(--text-secondary);margin-top:2px}
        table{width:100%;border-collapse:collapse}
        thead tr{background:var(--background)}
        th{font-size:12px;font-weight:500;color:var(--text-secondary);padding:9px 16px;text-align:left;border-bottom:1px solid var(--border);white-space:nowrap}
        td{padding:0 16px;height:44px;font-size:13px;color:var(--text-primary);border-top:1px solid var(--border);vertical-align:middle}
        tbody tr:hover{background:var(--background)}
        .user-avatar-sm{width:26px;height:26px;border-radius:50%;background:var(--primary);color:white;font-size:10px;font-weight:600;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .empty-state{padding:36px 20px;text-align:center;color:var(--text-secondary);font-size:13px}
        .pagination-wrap{padding:14px 20px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;}
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo"><div class="sidebar-logo-icon"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/></svg></div><span class="sidebar-logo-text">Gestionnaire</span></div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>Dashboard</a>
        <a href="{{ route('admin.etudiants') }}" class="nav-item"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>Étudiants</a>
        <a href="{{ route('admin.enseignants') }}" class="nav-item"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Enseignants</a>
        <a href="{{ route('admin.notes') }}" class="nav-item"><svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>Notes</a>
        <a href="{{ route('admin.reclamations') }}" class="nav-item"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Réclamations</a>
        <a href="{{ route('admin.logs') }}" class="nav-item active"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>Logs</a>
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="nav-item"><svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Déconnexion</button></form>
    </nav>
    <div class="sidebar-footer"><div class="sidebar-user"><div class="user-avatar-small">{{ strtoupper(substr(Auth::user()->prenom,0,1)) }}{{ strtoupper(substr(Auth::user()->nom,0,1)) }}</div><div class="sidebar-user-info"><div class="sidebar-user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div><div class="sidebar-user-role">Administrateur</div></div></div></div>
</aside>
<div class="main">
    <header class="topbar"><span class="topbar-title">Journal d'activité</span></header>
    <main class="content">
        <div class="page-header">
            <div><div class="page-title">Logs système</div><div class="page-sub">Toutes les actions effectuées sur la plateforme</div></div>
        </div>
        <div class="card">
            <div class="card-header"><div><div class="card-title">Journal d'activité</div><div class="card-sub">25 entrées par page</div></div></div>
            <div style="overflow-x:auto;">
                <table>
                    <thead><tr><th>Action</th><th>Table</th><th>Enregistrement</th><th>Effectuée par</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>
                                @php $color = match(strtoupper($log->action)) { 'CREATE' => 'var(--success)', 'UPDATE' => 'var(--warning)', 'DELETE' => 'var(--danger)', default => 'var(--text-secondary)' }; @endphp
                                <span style="font-size:11px;font-weight:700;color:{{ $color }};font-family:'SF Mono','Fira Code',monospace;text-transform:uppercase;letter-spacing:0.05em;">{{ $log->action }}</span>
                            </td>
                            <td style="font-family:'SF Mono','Fira Code',monospace;font-size:12px;color:var(--text-secondary);">{{ $log->table_concernee }}</td>
                            <td style="font-size:12px;color:var(--text-secondary);">#{{ $log->id_enregistrement }}</td>
                            <td>
                                @if($log->nom)
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <div class="user-avatar-sm">{{ strtoupper(substr($log->prenom,0,1)) }}{{ strtoupper(substr($log->nom,0,1)) }}</div>
                                        <span>{{ $log->prenom }} {{ $log->nom }}</span>
                                    </div>
                                @else<span style="color:var(--text-secondary);font-size:12px;">Système</span>@endif
                            </td>
                            <td style="font-size:12px;color:var(--text-secondary);white-space:nowrap;">{{ \Carbon\Carbon::parse($log->date_action)->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty<tr><td colspan="5"><div class="empty-state">Aucun log disponible.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap">{{ $logs->links() }}</div>
        </div>
    </main>
</div>
</body>
</html>
