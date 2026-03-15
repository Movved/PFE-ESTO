<!DOCTYPE html>
<html lang="fr">
<head>
    <script>if (localStorage.getItem('theme') === 'dark') { document.documentElement.classList.add('dark'); }</script>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Réclamations</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}
        .page-title{font-size:20px;font-weight:600;color:var(--text-primary)}
        .page-sub{font-size:13px;color:var(--text-secondary);margin-top:2px}
        .card{background:var(--surface);border:1px solid var(--border);border-radius:12px;overflow:hidden}
        .card-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border)}
        .card-title{font-size:14px;font-weight:600;color:var(--text-primary)}
        .card-sub{font-size:12px;color:var(--text-secondary);margin-top:2px}
        .rec-item{padding:16px 20px;border-top:1px solid var(--border);display:flex;align-items:flex-start;justify-content:space-between;gap:16px}
        .rec-item:hover{background:var(--background)}
        .rec-meta{font-size:11px;color:var(--text-secondary);margin-top:4px;display:flex;gap:12px;flex-wrap:wrap}
        .rec-message{font-size:13px;color:var(--text-primary);margin-top:6px;line-height:1.5}
        .rec-actions{display:flex;flex-direction:column;gap:6px;flex-shrink:0}
        .grade-value{font-family:'SF Mono','Fira Code',monospace;font-weight:600}
        .grade-pass{color:var(--success)}.grade-fail{color:var(--danger)}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:none;text-decoration:none;transition:opacity 0.15s;white-space:nowrap}
        .btn:hover{opacity:0.85}
        .btn-ghost{background:var(--background);color:var(--text-primary);border:1px solid var(--border)}
        .btn-danger{background:#FFF2F1;color:#C0392B;border:1px solid #FECACA}
        .btn svg{width:13px;height:13px;stroke:currentColor;stroke-width:2;fill:none}
        .empty-state{padding:36px 20px;text-align:center;color:var(--text-secondary);font-size:13px}
        .alert-success{background:#F0FBF4;border:1px solid #BBF7D0;color:#1A7A34;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px}
        .tag{display:inline-flex;align-items:center;gap:4px;background:var(--background);border:1px solid var(--border);border-radius:6px;padding:2px 8px;font-size:11px;font-family:'SF Mono','Fira Code',monospace;color:var(--text-secondary)}
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
        <a href="{{ route('admin.reclamations') }}" class="nav-item active"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Réclamations</a>
        <a href="{{ route('admin.logs') }}" class="nav-item"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>Logs</a>
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="nav-item"><svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Déconnexion</button></form>
    </nav>
    <div class="sidebar-footer"><div class="sidebar-user"><div class="user-avatar-small">{{ strtoupper(substr(Auth::user()->prenom,0,1)) }}{{ strtoupper(substr(Auth::user()->nom,0,1)) }}</div><div class="sidebar-user-info"><div class="sidebar-user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div><div class="sidebar-user-role">Administrateur</div></div></div></div>
</aside>
<div class="main">
    <header class="topbar"><span class="topbar-title">Réclamations</span></header>
    <main class="content">
        @if(session('success'))<div class="alert-success">{{ session('success') }}</div>@endif
        <div class="page-header">
            <div><div class="page-title">Réclamations</div><div class="page-sub">{{ $reclamations->count() }} réclamation(s) au total</div></div>
        </div>
        <div class="card">
            <div class="card-header"><div><div class="card-title">Toutes les réclamations</div><div class="card-sub">Soumises par les étudiants</div></div></div>
            @forelse($reclamations as $r)
            <div class="rec-item">
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                        <span style="font-size:13px;font-weight:600;color:var(--text-primary);">{{ $r->prenom }} {{ $r->nom }}</span>
                        <span class="tag">{{ $r->cne }}</span>
                        <span style="font-size:12px;color:var(--text-secondary);">→ {{ $r->nom_module }}</span>
                        <span class="tag">{{ $r->code_module }}</span>
                    </div>
                    <div class="rec-meta">
                        <span>Note : <span class="grade-value {{ $r->note >= 10 ? 'grade-pass' : 'grade-fail' }}">{{ $r->note !== null ? number_format($r->note,2) : '—' }}</span></span>
                        @if($r->rattrapage !== null)<span>Rattrapage : <span class="grade-value {{ $r->rattrapage >= 10 ? 'grade-pass' : 'grade-fail' }}">{{ number_format($r->rattrapage,2) }}</span></span>@endif
                        @if($r->date_reclamation)<span>{{ \Carbon\Carbon::parse($r->date_reclamation)->format('d/m/Y à H:i') }}</span>@endif
                    </div>
                    <div class="rec-message">{{ $r->message }}</div>
                </div>
                <div class="rec-actions">
                    <a href="{{ route('admin.reclamations.show', $r->id_reclamation) }}" class="btn btn-ghost"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>Détail</a>
                    <form method="POST" action="{{ route('admin.reclamations.destroy', $r->id_reclamation) }}" onsubmit="return confirm('Supprimer cette réclamation ?')">@csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>Supprimer</button>
                    </form>
                </div>
            </div>
            @empty<div class="empty-state">Aucune réclamation.</div>@endforelse
        </div>
    </main>
</div>
</body>
</html>
