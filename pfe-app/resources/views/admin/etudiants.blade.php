<!DOCTYPE html>
<html lang="fr">
<head>
    <script>if (localStorage.getItem('theme') === 'dark') { document.documentElement.classList.add('dark'); }</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Étudiants</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
        .page-title { font-size:20px; font-weight:600; color:var(--text-primary); }
        .page-sub { font-size:13px; color:var(--text-secondary); margin-top:2px; }
        .card { background:var(--surface); border:1px solid var(--border); border-radius:12px; overflow:hidden; }
        .card-header { display:flex; align-items:center; justify-content:space-between; padding:16px 20px; border-bottom:1px solid var(--border); }
        .card-title { font-size:14px; font-weight:600; color:var(--text-primary); }
        .card-sub { font-size:12px; color:var(--text-secondary); margin-top:2px; }
        table { width:100%; border-collapse:collapse; }
        thead tr { background:var(--background); }
        th { font-size:12px; font-weight:500; color:var(--text-secondary); padding:9px 16px; text-align:left; border-bottom:1px solid var(--border); white-space:nowrap; }
        td { padding:0 16px; height:44px; font-size:13px; color:var(--text-primary); border-top:1px solid var(--border); vertical-align:middle; }
        tbody tr:hover { background:var(--background); }
        .badge { display:inline-flex; align-items:center; gap:5px; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:500; }
        .badge-dot { width:5px; height:5px; border-radius:50%; }
        .badge-active { background:#F0FBF4; color:#1A7A34; }
        .badge-active .badge-dot { background:var(--success); }
        .badge-inactive { background:var(--background); color:var(--text-secondary); }
        .badge-inactive .badge-dot { background:var(--border); }
        .btn { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:500; cursor:pointer; border:none; text-decoration:none; transition:opacity 0.15s; }
        .btn:hover { opacity:0.85; }
        .btn-primary { background:var(--primary); color:white; }
        .btn-ghost { background:var(--background); color:var(--text-primary); border:1px solid var(--border); }
        .btn-danger { background:#FFF2F1; color:#C0392B; border:1px solid #FECACA; }
        .btn svg { width:13px; height:13px; stroke:currentColor; stroke-width:2; fill:none; }
        .search-bar { display:flex; gap:10px; padding:16px 20px; border-bottom:1px solid var(--border); }
        .search-input { flex:1; padding:8px 12px; border:1px solid var(--border); border-radius:8px; font-size:13px; background:var(--background); color:var(--text-primary); outline:none; }
        .search-input:focus { border-color:var(--primary); }
        .user-avatar-sm { width:30px; height:30px; border-radius:50%; background:var(--primary); color:white; font-size:11px; font-weight:600; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .alert-success { background:#F0FBF4; border:1px solid #BBF7D0; color:#1A7A34; padding:12px 16px; border-radius:8px; font-size:13px; margin-bottom:16px; }
        .empty-state { padding:36px 20px; text-align:center; color:var(--text-secondary); font-size:13px; }
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/></svg>
        </div>
        <span class="sidebar-logo-text">Gestionnaire</span>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>Dashboard</a>
        <a href="{{ route('admin.etudiants') }}" class="nav-item active"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>Étudiants</a>
        <a href="{{ route('admin.enseignants') }}" class="nav-item"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Enseignants</a>
        <a href="{{ route('admin.notes') }}" class="nav-item"><svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>Notes</a>
        <a href="{{ route('admin.reclamations') }}" class="nav-item"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Réclamations</a>
        <a href="{{ route('admin.logs') }}" class="nav-item"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>Logs</a>
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="nav-item"><svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Déconnexion</button></form>
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="user-avatar-small">{{ strtoupper(substr(Auth::user()->prenom,0,1)) }}{{ strtoupper(substr(Auth::user()->nom,0,1)) }}</div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                <div class="sidebar-user-role">Administrateur</div>
            </div>
        </div>
    </div>
</aside>

<div class="main">
    <header class="topbar">
        <span class="topbar-title">Étudiants</span>
        <div style="display:flex;flex-direction:column;align-items:center;gap:2px;">
            <span id="topbar-time" style="font-size:14px;font-weight:600;color:var(--text-primary);font-family:'SF Mono','Fira Code',monospace;"></span>
            <span id="topbar-date" style="font-size:11px;color:var(--text-secondary);"></span>
        </div>
    </header>
    <main class="content">

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-header">
            <div>
                <div class="page-title">Étudiants</div>
                <div class="page-sub">{{ $etudiants->count() }} étudiant(s) enregistré(s)</div>
            </div>
            <a href="{{ route('admin.etudiants.create') }}" class="btn btn-primary">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Ajouter un étudiant
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Liste des étudiants</div>
                    <div class="card-sub">Tous les comptes étudiants de la plateforme</div>
                </div>
            </div>
            <form method="GET" class="search-bar">
                <input type="text" name="search" class="search-input" placeholder="Rechercher par nom, prénom ou CNE..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-ghost">Rechercher</button>
                @if(request('search'))
                    <a href="{{ route('admin.etudiants') }}" class="btn btn-ghost">Réinitialiser</a>
                @endif
            </form>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>CNE</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Créé le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($etudiants as $e)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div class="user-avatar-sm">{{ strtoupper(substr($e->prenom,0,1)) }}{{ strtoupper(substr($e->nom,0,1)) }}</div>
                                    <div>
                                        <div style="font-weight:500;">{{ $e->prenom }} {{ $e->nom }}</div>
                                        <div style="font-size:11px;color:var(--text-secondary);">#{{ $e->id_etudiant }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-family:'SF Mono','Fira Code',monospace;font-size:12px;color:var(--text-secondary);">{{ $e->cne }}</td>
                            <td style="font-size:12px;">{{ $e->email }}</td>
                            <td>
                                @if($e->actif)
                                    <span class="badge badge-active"><span class="badge-dot"></span>Actif</span>
                                @else
                                    <span class="badge badge-inactive"><span class="badge-dot"></span>Inactif</span>
                                @endif
                            </td>
                            <td style="font-size:12px;color:var(--text-secondary);">{{ \Carbon\Carbon::parse($e->date_creation)->format('d/m/Y') }}</td>
                            <td>
                                <div style="display:flex;gap:6px;">
                                    <a href="{{ route('admin.etudiants.edit', $e->id_etudiant) }}" class="btn btn-ghost">
                                        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('admin.etudiants.destroy', $e->id_etudiant) }}" onsubmit="return confirm('Supprimer cet étudiant ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6"><div class="empty-state">Aucun étudiant trouvé.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
</html>
