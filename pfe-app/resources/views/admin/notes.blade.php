<!DOCTYPE html>
<html lang="fr">
<head>
    <script>if (localStorage.getItem('theme') === 'dark') { document.documentElement.classList.add('dark'); }</script>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Notes</title>
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
        th.center,td.center{text-align:center}
        td{padding:0 16px;height:44px;font-size:13px;color:var(--text-primary);border-top:1px solid var(--border);vertical-align:middle}
        tbody tr:hover{background:var(--background)}
        .grade-value{font-family:'SF Mono','Fira Code',monospace;font-weight:600}
        .grade-pass{color:var(--success)}.grade-warn{color:var(--warning)}.grade-fail{color:var(--danger)}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:none;text-decoration:none;transition:opacity 0.15s}
        .btn:hover{opacity:0.85}
        .btn-ghost{background:var(--background);color:var(--text-primary);border:1px solid var(--border)}
        .btn svg{width:13px;height:13px;stroke:currentColor;stroke-width:2;fill:none}
        .search-bar{display:flex;gap:10px;padding:16px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap}
        .search-input{flex:1;min-width:200px;padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;background:var(--background);color:var(--text-primary);outline:none}
        .search-input:focus{border-color:var(--primary)}
        select.search-input{min-width:160px;flex:0}
        .alert-success{background:#F0FBF4;border:1px solid #BBF7D0;color:#1A7A34;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px}
        .empty-state{padding:36px 20px;text-align:center;color:var(--text-secondary);font-size:13px}
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo"><div class="sidebar-logo-icon"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/></svg></div><span class="sidebar-logo-text">Gestionnaire</span></div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>Dashboard</a>
        <a href="{{ route('admin.etudiants') }}" class="nav-item"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>Étudiants</a>
        <a href="{{ route('admin.enseignants') }}" class="nav-item"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Enseignants</a>
        <a href="{{ route('admin.notes') }}" class="nav-item active"><svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>Notes</a>
        <a href="{{ route('admin.reclamations') }}" class="nav-item"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Réclamations</a>
        <a href="{{ route('admin.logs') }}" class="nav-item"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>Logs</a>
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="nav-item"><svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Déconnexion</button></form>
    </nav>
    <div class="sidebar-footer"><div class="sidebar-user"><div class="user-avatar-small">{{ strtoupper(substr(Auth::user()->prenom,0,1)) }}{{ strtoupper(substr(Auth::user()->nom,0,1)) }}</div><div class="sidebar-user-info"><div class="sidebar-user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div><div class="sidebar-user-role">Administrateur</div></div></div></div>
</aside>
<div class="main">
    <header class="topbar"><span class="topbar-title">Notes</span></header>
    <main class="content">
        @if(session('success'))<div class="alert-success">{{ session('success') }}</div>@endif
        <div class="page-header">
            <div><div class="page-title">Gestion des notes</div><div class="page-sub">{{ $notes->count() }} note(s) enregistrée(s)</div></div>
        </div>
        <div class="card">
            <div class="card-header"><div><div class="card-title">Toutes les notes</div><div class="card-sub">Filtrer par module ou étudiant</div></div></div>
            <form method="GET" class="search-bar">
                <input type="text" name="search" class="search-input" placeholder="Rechercher étudiant ou CNE..." value="{{ request('search') }}">
                <select name="module" class="search-input">
                    <option value="">Tous les modules</option>
                    @foreach($modules as $m)
                        <option value="{{ $m->id_module }}" {{ request('module') == $m->id_module ? 'selected' : '' }}>{{ $m->nom_module }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-ghost">Filtrer</button>
                @if(request('search') || request('module'))<a href="{{ route('admin.notes') }}" class="btn btn-ghost">Réinitialiser</a>@endif
            </form>
            <div style="overflow-x:auto;">
                <table>
                    <thead><tr><th>Étudiant</th><th>CNE</th><th>Module</th><th>Code</th><th class="center">Note</th><th class="center">Rattrapage</th><th class="center">Statut</th><th>Actions</th></tr></thead>
                    <tbody>
                        @forelse($notes as $n)
                        <tr>
                            <td style="font-weight:500;">{{ $n->prenom }} {{ $n->nom }}</td>
                            <td style="font-family:'SF Mono','Fira Code',monospace;font-size:12px;color:var(--text-secondary);">{{ $n->cne }}</td>
                            <td style="font-size:13px;">{{ $n->nom_module }}</td>
                            <td style="font-family:'SF Mono','Fira Code',monospace;font-size:12px;color:var(--text-secondary);">{{ $n->code_module }}</td>
                            <td class="center">
                                @if($n->note !== null)
                                    <span class="grade-value {{ $n->note >= 12 ? 'grade-pass' : ($n->note >= 10 ? 'grade-warn' : 'grade-fail') }}">{{ number_format($n->note, 2) }}</span>
                                @else<span style="color:var(--text-secondary);">—</span>@endif
                            </td>
                            <td class="center">
                                @if($n->rattrapage !== null)
                                    <span class="grade-value {{ $n->rattrapage >= 10 ? 'grade-pass' : 'grade-fail' }}">{{ number_format($n->rattrapage, 2) }}</span>
                                @else<span style="color:var(--text-secondary);">—</span>@endif
                            </td>
                            <td class="center">
                                @if($n->note === null)<span style="font-size:12px;color:var(--text-secondary);">En attente</span>
                                @elseif($n->note >= 10 || ($n->rattrapage !== null && $n->rattrapage >= 10))<span style="font-size:12px;color:var(--success);font-weight:500;">✓ Validé</span>
                                @else<span style="font-size:12px;color:var(--danger);font-weight:500;">✗ Échoué</span>@endif
                            </td>
                            <td><a href="{{ route('admin.notes.edit', $n->id_note) }}" class="btn btn-ghost"><svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>Modifier</a></td>
                        </tr>
                        @empty<tr><td colspan="8"><div class="empty-state">Aucune note trouvée.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
</html>
