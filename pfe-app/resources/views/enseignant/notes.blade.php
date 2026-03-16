<!DOCTYPE html>
<html lang="fr">
<head>
    <script>if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie des notes</title>
    @vite(['resources/css/app.css', 'resources/css/enseignant/dashboard.css', 'resources/js/app.js'])
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo"><div class="sidebar-logo-icon"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/></svg></div><span class="sidebar-logo-text">Gestionnaire</span></div>
    <nav class="sidebar-nav">
        <a href="{{ route('enseignant.dashboard') }}" class="nav-item {{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg> Dashboard</a>
        <a href="{{ route('enseignant.modules') }}" class="nav-item {{ request()->routeIs('enseignant.modules*') ? 'active' : '' }}"><svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg> Mes Modules</a>
        <a href="{{ route('enseignant.notes') }}" class="nav-item {{ request()->routeIs('enseignant.notes*') ? 'active' : '' }}"><svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg> Saisie des Notes</a>
        <a href="{{ route('enseignant.reclamations') }}" class="nav-item {{ request()->routeIs('enseignant.reclamations*') ? 'active' : '' }}"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg> Réclamations @if(isset($pendingCount) && $pendingCount > 0)<span class="nav-badge">{{ $pendingCount }}</span>@endif</a>
        <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> Profil</a>
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="nav-item" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;font-size:14px;font-family:inherit;color:var(--text-secondary);"><svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg> Déconnexion</button></form>
    </nav>
    <div class="sidebar-footer"><div class="sidebar-user"><div class="user-avatar-small">{{ strtoupper(substr(Auth::user()->prenom,0,1)) }}{{ strtoupper(substr(Auth::user()->nom,0,1)) }}</div><div class="sidebar-user-info"><div class="sidebar-user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div><div class="sidebar-user-role">Enseignant</div></div><span class="sidebar-user-more"><svg viewBox="0 0 24 24"><circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/></svg></span></div></div>
</aside>
<div class="main">
    <header class="topbar">
        <span class="topbar-title">Saisie des notes</span>
        <button class="toggle-btn" id="theme-toggle" onclick="toggleTheme()"><span class="toggle-knob"></span></button>
    </header>
    <main class="content">
        @if(session('success'))<div class="alert alert-success"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-error"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ session('error') }}</div>@endif
        <div class="card">
            <div class="card-header"><div><div class="card-header-title">Choisir un module</div><div class="card-header-sub">Saisir les notes puis générer le PV (procès-verbal)</div></div></div>
            <div class="modules-grid">
                @forelse($modules ?? [] as $m)
                <a href="{{ route('enseignant.notes.form', $m->id_module) }}" class="module-card">
                    <div class="module-card-icon"><svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg></div>
                    <div class="module-card-body"><div class="module-card-name">{{ $m->nom_module }}</div><div class="module-card-code">{{ $m->code_module }}</div><div class="module-card-meta">Sem. {{ $m->semestre_numero }} · {{ $m->annee_libelle }} · {{ $m->nom_filiere }}</div></div>
                    <div class="module-card-count"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>{{ $m->nb_etudiants ?? 0 }} étudiant(s)</div>
                </a>
                @empty
                <div class="empty-state" style="grid-column:1/-1;">Aucun module assigné.</div>
                @endforelse
            </div>
        </div>
    </main>
</div>
<script>function toggleTheme(){var h=document.documentElement,b=document.getElementById('theme-toggle');h.classList.toggle('dark');b.classList.toggle('on');localStorage.setItem('theme',h.classList.contains('dark')?'dark':'light');}if(localStorage.getItem('theme')==='dark')document.getElementById('theme-toggle').classList.add('on');</script>
</body>
</html>
