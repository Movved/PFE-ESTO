<!DOCTYPE html>
<html lang="fr">
<head>
    <script>if (localStorage.getItem('theme') === 'dark') { document.documentElement.classList.add('dark'); }</script>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Modifier Note</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}
        .page-title{font-size:20px;font-weight:600;color:var(--text-primary)}
        .page-sub{font-size:13px;color:var(--text-secondary);margin-top:2px}
        .card{background:var(--surface);border:1px solid var(--border);border-radius:12px;overflow:hidden;max-width:500px}
        .card-header{padding:16px 20px;border-bottom:1px solid var(--border)}
        .card-title{font-size:14px;font-weight:600;color:var(--text-primary)}
        .card-body{padding:20px;display:flex;flex-direction:column;gap:16px}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .form-group{display:flex;flex-direction:column;gap:6px}
        label{font-size:12px;font-weight:500;color:var(--text-secondary)}
        input[type=number]{padding:9px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;background:var(--background);color:var(--text-primary);outline:none;width:100%;box-sizing:border-box;font-family:'SF Mono','Fira Code',monospace}
        input:focus{border-color:var(--primary)}
        .form-error{font-size:11px;color:var(--danger);margin-top:2px}
        .info-row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);font-size:13px}
        .info-label{color:var(--text-secondary)}
        .info-value{font-weight:500;color:var(--text-primary)}
        .card-footer{padding:16px 20px;border-top:1px solid var(--border);display:flex;gap:10px}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;border:none;text-decoration:none;transition:opacity 0.15s}
        .btn:hover{opacity:0.85}
        .btn-primary{background:var(--primary);color:white}
        .btn-ghost{background:var(--background);color:var(--text-primary);border:1px solid var(--border)}
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
        <a href="{{ route('admin.reclamations') }}" class="nav-item"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>Réclamations</a>
        <a href="{{ route('admin.logs') }}" class="nav-item"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/></svg>Logs</a>
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="nav-item"><svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Déconnexion</button></form>
    </nav>
    <div class="sidebar-footer"><div class="sidebar-user"><div class="user-avatar-small">{{ strtoupper(substr(Auth::user()->prenom,0,1)) }}{{ strtoupper(substr(Auth::user()->nom,0,1)) }}</div><div class="sidebar-user-info"><div class="sidebar-user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div><div class="sidebar-user-role">Administrateur</div></div></div></div>
</aside>
<div class="main">
    <header class="topbar"><span class="topbar-title">Modifier une note</span></header>
    <main class="content">
        <div class="page-header">
            <div><div class="page-title">Modifier la note</div><div class="page-sub">{{ $note->nom_module }} — {{ $note->prenom }} {{ $note->nom }}</div></div>
            <a href="{{ route('admin.notes') }}" class="btn btn-ghost">← Retour</a>
        </div>
        <div class="card">
            <div class="card-header"><div class="card-title">Informations</div></div>
            <div style="padding:16px 20px;">
                <div class="info-row"><span class="info-label">Étudiant</span><span class="info-value">{{ $note->prenom }} {{ $note->nom }}</span></div>
                <div class="info-row"><span class="info-label">Module</span><span class="info-value">{{ $note->nom_module }} ({{ $note->code_module }})</span></div>
            </div>
            <form method="POST" action="{{ route('admin.notes.update', $note->id_note) }}">
                @csrf @method('PUT')
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Note (0 — 20)</label>
                            <input type="number" name="note" step="0.01" min="0" max="20" value="{{ old('note', $note->note) }}" placeholder="Ex: 14.50">
                            @error('note')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Rattrapage (0 — 20)</label>
                            <input type="number" name="rattrapage" step="0.01" min="0" max="20" value="{{ old('rattrapage', $note->rattrapage) }}" placeholder="—">
                            @error('rattrapage')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('admin.notes') }}" class="btn btn-ghost">Annuler</a>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>
