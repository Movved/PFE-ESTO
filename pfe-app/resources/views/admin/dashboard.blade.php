<!DOCTYPE html>
<html lang="fr">

<head>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 20px 22px; display: flex; flex-direction: column; gap: 10px; }
        .stat-top { display: flex; align-items: center; justify-content: space-between; }
        .stat-label { font-size: 13px; color: var(--text-secondary); }
        .stat-icon svg { width: 18px; height: 18px; stroke: var(--text-secondary); stroke-width: 1.5; fill: none; }
        .stat-value { font-size: 30px; font-weight: 600; color: var(--text-primary); line-height: 1; }
        .stat-sub { font-size: 12px; color: var(--text-secondary); }
        .stat-sub.up   { color: var(--success); }
        .stat-sub.down { color: var(--danger); }
        .stat-sub.warn { color: var(--warning); }
        .two-col   { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
        .three-col { display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 24px; }
        .full-col  { margin-bottom: 24px; }
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .card-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--border); }
        .card-header-left { display: flex; flex-direction: column; gap: 2px; }
        .card-title { font-size: 14px; font-weight: 600; color: var(--text-primary); }
        .card-sub { font-size: 12px; color: var(--text-secondary); }
        .card-link { font-size: 12px; font-weight: 500; color: var(--primary); text-decoration: none; }
        .card-link:hover { text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: var(--background); }
        th { font-size: 12px; font-weight: 500; color: var(--text-secondary); padding: 9px 16px; text-align: left; border-bottom: 1px solid var(--border); white-space: nowrap; }
        th.center, td.center { text-align: center; }
        td { padding: 0 16px; height: 42px; font-size: 13px; color: var(--text-primary); border-top: 1px solid var(--border); vertical-align: middle; }
        tbody tr { transition: background 0.15s ease; }
        tbody tr:hover { background: var(--background); }
        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 500; }
        .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
        .badge-pending  { background: #FFF8EC; color: #B25F00; }
        .badge-pending .badge-dot  { background: var(--warning); }
        .badge-resolved { background: #F0FBF4; color: #1A7A34; }
        .badge-resolved .badge-dot { background: var(--success); }
        .badge-rejected { background: #FFF2F1; color: #C0392B; }
        .badge-rejected .badge-dot { background: var(--danger); }
        .badge-admin    { background: #EEF2FF; color: #3730A3; }
        .badge-admin .badge-dot    { background: #6366F1; }
        .badge-teacher  { background: #F0F9FF; color: #0369A1; }
        .badge-teacher .badge-dot  { background: #0EA5E9; }
        .badge-student  { background: #F0FBF4; color: #1A7A34; }
        .badge-student .badge-dot  { background: var(--success); }
        .badge-inactive { background: var(--background); color: var(--text-secondary); }
        .badge-inactive .badge-dot { background: var(--border); }
        .welcome-banner { background: var(--primary); border-radius: 12px; padding: 24px 28px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; }
        .welcome-text-title { font-size: 18px; font-weight: 600; color: white; margin-bottom: 4px; }
        .welcome-text-sub { font-size: 13px; color: rgba(255,255,255,0.75); }
        .welcome-banner-icon svg { width: 48px; height: 48px; stroke: rgba(255,255,255,0.4); stroke-width: 1.5; fill: none; }
        .progress-row { padding: 12px 20px; border-top: 1px solid var(--border); display: flex; flex-direction: column; gap: 6px; }
        .progress-label { display: flex; justify-content: space-between; font-size: 12px; color: var(--text-secondary); }
        .progress-label span:last-child { font-weight: 500; color: var(--text-primary); }
        .progress-bar { height: 5px; background: var(--border); border-radius: 4px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 4px; background: var(--primary); }
        .progress-fill.success { background: var(--success); }
        .progress-fill.warning { background: var(--warning); }
        .progress-fill.danger  { background: var(--danger); }
        .empty-state { padding: 36px 20px; text-align: center; color: var(--text-secondary); font-size: 13px; }
        .empty-state svg { width: 28px; height: 28px; stroke: var(--border); stroke-width: 1.5; fill: none; margin: 0 auto 8px; display: block; }
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: opacity 0.15s; }
        .btn:hover { opacity: 0.85; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-ghost { background: var(--background); color: var(--text-primary); border: 1px solid var(--border); }
        .btn svg { width: 13px; height: 13px; stroke: currentColor; stroke-width: 2; fill: none; }
        .quick-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; padding: 16px 20px; }
        .quick-action-item { display: flex; align-items: center; gap: 10px; padding: 12px 14px; border: 1px solid var(--border); border-radius: 10px; text-decoration: none; background: var(--background); transition: border-color 0.15s, background 0.15s; cursor: pointer; }
        .quick-action-item:hover { border-color: var(--primary); background: var(--surface); }
        .quick-action-icon { width: 32px; height: 32px; border-radius: 8px; background: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .quick-action-icon svg { width: 15px; height: 15px; stroke: white; stroke-width: 1.8; fill: none; }
        .quick-action-icon.green  { background: var(--success); }
        .quick-action-icon.orange { background: var(--warning); }
        .quick-action-icon.red    { background: var(--danger); }
        .quick-action-icon.purple { background: #7C3AED; }
        .quick-action-label { font-size: 12px; font-weight: 500; color: var(--text-primary); }
        .quick-action-sub   { font-size: 11px; color: var(--text-secondary); margin-top: 1px; }
        .user-avatar-sm { width: 28px; height: 28px; border-radius: 50%; background: var(--primary); color: white; font-size: 10px; font-weight: 600; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                    <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5" />
                </svg>
            </div>
            <span class="sidebar-logo-text">Gestionnaire</span>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>

            <div class="nav-section-label">Utilisateurs</div>

            <a href="{{ route('admin.etudiants') }}" class="nav-item {{ request()->routeIs('admin.etudiants*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                Étudiants
            </a>
            <a href="{{ route('admin.enseignants') }}" class="nav-item {{ request()->routeIs('admin.enseignants*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Enseignants
            </a>

            <div class="nav-section-label">Structure</div>

            <a href="{{ route('admin.filieres') }}" class="nav-item {{ request()->routeIs('admin.filieres*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Filières
            </a>
            <a href="{{ route('admin.modules') }}" class="nav-item {{ request()->routeIs('admin.modules*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                Modules
            </a>
            <a href="{{ route('admin.semestres') }}" class="nav-item {{ request()->routeIs('admin.semestres*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Semestres
            </a>

            <div class="nav-section-label">Académique</div>

            <a href="{{ route('admin.notes') }}" class="nav-item {{ request()->routeIs('admin.notes*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                Notes
            </a>
            <a href="{{ route('admin.reclamations') }}" class="nav-item {{ request()->routeIs('admin.reclamations*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Réclamations
                @if($pendingReclamations > 0)
                    <span style="margin-left:auto; background:var(--danger); color:white; font-size:10px; font-weight:600; padding:1px 6px; border-radius:10px;">{{ $pendingReclamations }}</span>
                @endif
            </a>
            <a href="{{ route('admin.logs') }}" class="nav-item {{ request()->routeIs('admin.logs') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                Logs
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Déconnexion
                </button>
            </form>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar-small">
                    {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}{{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                    <div class="sidebar-user-role">Administrateur</div>
                </div>
                <div style="position:relative;">
                    <button onclick="toggleUserMenu()" class="sidebar-user-more">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                    </button>
                    <div id="user-menu">
                        <button onclick="toggleThemeFromMenu()">
                            <svg viewBox="0 0 24 24" id="theme-icon"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                            <span id="theme-label">Mode sombre</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Dashboard Admin</span>
            <div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
                <span id="topbar-time" style="font-size:14px; font-weight:600; color:var(--text-primary); font-family:'SF Mono','Fira Code',monospace;"></span>
                <span id="topbar-date" style="font-size:11px; color:var(--text-secondary);"></span>
            </div>
        </header>

        <main class="content">

            {{-- WELCOME BANNER --}}
            <div class="welcome-banner">
                <div>
                    <div class="welcome-text-title">Bonjour, {{ Auth::user()->prenom }} — Vue administrateur</div>
                    <div class="welcome-text-sub">Voici l'état général de la plateforme pour aujourd'hui.</div>
                </div>
                <div class="welcome-banner-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                </div>
            </div>

            {{-- STAT CARDS --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Étudiants</span>
                        <span class="stat-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></span>
                    </div>
                    <div class="stat-value">{{ $totalEtudiants }}</div>
                    <div class="stat-sub up">{{ $etudiantsActifs }} actifs</div>
                </div>
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Enseignants</span>
                        <span class="stat-icon"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
                    </div>
                    <div class="stat-value">{{ $totalEnseignants }}</div>
                    <div class="stat-sub">{{ $totalDepartements }} départements</div>
                </div>
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Réclamations</span>
                        <span class="stat-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></span>
                    </div>
                    <div class="stat-value">{{ $totalReclamations }}</div>
                    <div class="stat-sub {{ $pendingReclamations > 0 ? 'warn' : '' }}">
                        {{ $pendingReclamations > 0 ? $pendingReclamations . ' en attente' : 'Toutes traitées' }}
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Modules actifs</span>
                        <span class="stat-icon"><svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg></span>
                    </div>
                    <div class="stat-value">{{ $totalModules }}</div>
                    <div class="stat-sub">{{ $totalFilieres }} filières</div>
                </div>
            </div>

            {{-- TWO COL: RECENT USERS + QUICK ACTIONS --}}
            <div class="two-col">

                {{-- RECENT USERS --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-title">Utilisateurs récents</div>
                            <div class="card-sub">Derniers comptes créés</div>
                        </div>
                        <a href="{{ route('admin.etudiants') }}" class="card-link">Voir tout →</a>
                    </div>
                    @forelse($recentUsers as $user)
                        <div style="display:flex; align-items:center; gap:12px; padding:10px 20px; border-top:1px solid var(--border);">
                            <div class="user-avatar-sm">
                                {{ strtoupper(substr($user->prenom, 0, 1)) }}{{ strtoupper(substr($user->nom, 0, 1)) }}
                            </div>
                            <div style="flex:1; min-width:0;">
                                <div style="font-size:13px; font-weight:500; color:var(--text-primary);">{{ $user->prenom }} {{ $user->nom }}</div>
                                <div style="font-size:11px; color:var(--text-secondary); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $user->email }}</div>
                            </div>
                            @if($user->role === 'ADMIN')
                                <span class="badge badge-admin"><span class="badge-dot"></span>Admin</span>
                            @elseif($user->role === 'ENSEIGNANT')
                                <span class="badge badge-teacher"><span class="badge-dot"></span>Enseignant</span>
                            @else
                                <span class="badge badge-student {{ !$user->actif ? 'badge-inactive' : '' }}"><span class="badge-dot"></span>{{ $user->actif ? 'Étudiant' : 'Inactif' }}</span>
                            @endif
                        </div>
                    @empty
                        <div class="empty-state">Aucun utilisateur.</div>
                    @endforelse
                </div>

                {{-- QUICK ACTIONS --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-title">Actions rapides</div>
                            <div class="card-sub">Raccourcis de gestion</div>
                        </div>
                    </div>
                    <div class="quick-actions">
                        <a href="{{ route('admin.etudiants.create') }}" class="quick-action-item">
                            <div class="quick-action-icon green">
                                <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                            </div>
                            <div>
                                <div class="quick-action-label">Ajouter étudiant</div>
                                <div class="quick-action-sub">Nouveau compte</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.enseignants.create') }}" class="quick-action-item">
                            <div class="quick-action-icon">
                                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/><line x1="12" y1="14" x2="12" y2="20"/><line x1="9" y1="17" x2="15" y2="17"/></svg>
                            </div>
                            <div>
                                <div class="quick-action-label">Ajouter enseignant</div>
                                <div class="quick-action-sub">Nouveau compte</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.modules.create') }}" class="quick-action-item">
                            <div class="quick-action-icon purple">
                                <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/><line x1="12" y1="8" x2="12" y2="14"/><line x1="9" y1="11" x2="15" y2="11"/></svg>
                            </div>
                            <div>
                                <div class="quick-action-label">Créer module</div>
                                <div class="quick-action-sub">Nouveau module</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.reclamations') }}" class="quick-action-item">
                            <div class="quick-action-icon orange">
                                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            </div>
                            <div>
                                <div class="quick-action-label">Réclamations</div>
                                <div class="quick-action-sub">{{ $pendingReclamations }} en attente</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.filieres.create') }}" class="quick-action-item">
                            <div class="quick-action-icon red">
                                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><line x1="12" y1="10" x2="12" y2="16"/><line x1="9" y1="13" x2="15" y2="13"/></svg>
                            </div>
                            <div>
                                <div class="quick-action-label">Nouvelle filière</div>
                                <div class="quick-action-sub">Structure pédagogique</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.notes') }}" class="quick-action-item">
                            <div class="quick-action-icon green">
                                <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                            </div>
                            <div>
                                <div class="quick-action-label">Gérer les notes</div>
                                <div class="quick-action-sub">Saisie & correction</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            {{-- FILIERE OVERVIEW + PENDING RECLAMATIONS --}}
            <div class="three-col">

                {{-- RECLAMATIONS EN ATTENTE --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-title">Réclamations en attente</div>
                            <div class="card-sub">À traiter en priorité</div>
                        </div>
                        <a href="{{ route('admin.reclamations') }}" class="card-link">Gérer →</a>
                    </div>
                    @forelse($reclamationsEnAttente as $rec)
                        <div style="padding:12px 20px; border-top:1px solid var(--border);">
                            <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:12px;">
                                <div style="flex:1; min-width:0;">
                                    <div style="font-size:13px; font-weight:500; color:var(--text-primary); margin-bottom:2px;">
                                        {{ $rec->prenom }} {{ $rec->nom }}
                                        <span style="font-size:11px; color:var(--text-secondary); font-weight:400; margin-left:6px;">{{ $rec->nom_module }}</span>
                                    </div>
                                    <div style="font-size:12px; color:var(--text-secondary); line-height:1.5; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                        {{ Str::limit($rec->message, 70) }}
                                    </div>
                                    <div style="font-size:11px; color:var(--text-secondary); margin-top:4px;">
                                        {{ \Carbon\Carbon::parse($rec->date_reclamation)->format('d/m/Y à H:i') }}
                                    </div>
                                </div>
                                <div style="display:flex; flex-direction:column; gap:6px; flex-shrink:0;">
                                    <span class="badge badge-pending"><span class="badge-dot"></span>En attente</span>
                                    <a href="{{ route('admin.reclamations.show', $rec->id_reclamation) }}" class="btn btn-ghost" style="font-size:11px; padding:4px 10px;">Traiter</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                            Aucune réclamation en attente.
                        </div>
                    @endforelse
                </div>

                {{-- FILIERE STATS --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-title">Filières</div>
                            <div class="card-sub">Répartition étudiants</div>
                        </div>
                    </div>
                    @forelse($filiereStats as $filiere)
                        <div class="progress-row">
                            <div class="progress-label">
                                <span style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:140px;">{{ $filiere->nom_filiere }}</span>
                                <span>{{ $filiere->nb_etudiants }} étudiants</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill success" style="width: {{ $totalEtudiants > 0 ? round(($filiere->nb_etudiants / $totalEtudiants) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">Aucune filière.</div>
                    @endforelse
                </div>
            </div>

            {{-- RECENT LOGS --}}
            <div class="card full-col">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-title">Journal d'activité récent</div>
                        <div class="card-sub">Dernières actions effectuées sur la plateforme</div>
                    </div>
                    <a href="{{ route('admin.logs') }}" class="card-link">Voir tout →</a>
                </div>
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Table</th>
                                <th>Enregistrement</th>
                                <th>Effectuée par</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLogs as $log)
                                <tr>
                                    <td>
                                        @php
                                            $actionColor = match(strtoupper($log->action)) {
                                                'CREATE' => 'var(--success)',
                                                'UPDATE' => 'var(--warning)',
                                                'DELETE' => 'var(--danger)',
                                                default  => 'var(--text-secondary)',
                                            };
                                        @endphp
                                        <span style="font-size:11px; font-weight:600; color:{{ $actionColor }}; font-family:'SF Mono','Fira Code',monospace; text-transform:uppercase;">
                                            {{ $log->action }}
                                        </span>
                                    </td>
                                    <td style="font-size:12px; font-family:'SF Mono','Fira Code',monospace; color:var(--text-secondary);">
                                        {{ $log->table_concernee }}
                                    </td>
                                    <td style="font-size:12px; color:var(--text-secondary);">
                                        #{{ $log->id_enregistrement }}
                                    </td>
                                    <td>
                                        @if($log->user)
                                            <div style="display:flex; align-items:center; gap:8px;">
                                                <div class="user-avatar-sm" style="width:22px; height:22px; font-size:9px;">
                                                    {{ strtoupper(substr($log->user->prenom, 0, 1)) }}{{ strtoupper(substr($log->user->nom, 0, 1)) }}
                                                </div>
                                                <span style="font-size:13px;">{{ $log->user->prenom }} {{ $log->user->nom }}</span>
                                            </div>
                                        @else
                                            <span style="color:var(--text-secondary); font-size:12px;">Système</span>
                                        @endif
                                    </td>
                                    <td style="font-size:12px; color:var(--text-secondary); white-space:nowrap;">
                                        {{ \Carbon\Carbon::parse($log->date_action)->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5"><div class="empty-state">Aucun log disponible.</div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

</body>
</html>