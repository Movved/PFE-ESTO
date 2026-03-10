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
    <title>{{ $module->nom_module }} — Enseignant</title>
    @vite(['resources/css/app.css', 'resources/css/enseignant/dashboard.css', 'resources/js/app.js'])
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
            </svg>
        </div>
        <span class="sidebar-logo-text">Gestionnaire</span>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('enseignant.dashboard') }}" class="nav-item {{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>
        <a href="{{ route('enseignant.modules') }}" class="nav-item {{ request()->routeIs('enseignant.modules*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
            Mes Modules
        </a>
        <a href="{{ route('enseignant.notes') }}" class="nav-item {{ request()->routeIs('enseignant.notes*') ? 'active' : '' }}"><svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg> Saisie des Notes</a>
        <a href="{{ route('enseignant.reclamations') }}" class="nav-item {{ request()->routeIs('enseignant.reclamations*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
            Réclamations
            @if(isset($pendingCount) && $pendingCount > 0)<span class="nav-badge">{{ $pendingCount }}</span>@endif
        </a>
        <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Profil
        </a>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="nav-item" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;font-size:14px;font-family:inherit;color:var(--text-secondary);">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Déconnexion
            </button>
        </form>
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="user-avatar-small">{{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}{{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}</div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                <div class="sidebar-user-role">Enseignant</div>
            </div>
            <span class="sidebar-user-more"><svg viewBox="0 0 24 24"><circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/></svg></span>
        </div>
    </div>
</aside>

<div class="main">
    <header class="topbar">
        <span class="topbar-title">{{ $module->nom_module }}</span>
        <div class="topbar-search">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="text" placeholder="Rechercher un étudiant..." />
        </div>
        <button class="toggle-btn" id="theme-toggle" onclick="toggleTheme()" title="Thème sombre"><span class="toggle-knob"></span></button>
        <div class="topbar-icon-btn" style="position:relative;">
            <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
            @if(isset($pendingCount) && $pendingCount > 0)<span class="notif-dot"></span>@endif
        </div>
        <div class="topbar-icon-btn"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
    </header>

    <main class="content">
        @if(session('success'))
            <div class="alert alert-success">
                <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('enseignant.modules') }}" class="module-detail-back">
            <svg viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Retour aux modules
        </a>

        <div class="module-detail-header">
            <div>
                <h1 class="module-detail-title">{{ $module->nom_module }}</h1>
                <div class="module-detail-code">{{ $module->code_module }}</div>
            </div>
        </div>

        <div class="module-detail-info-grid">
            <div class="module-detail-info-item">
                <div class="module-detail-info-label">Semestre</div>
                <div class="module-detail-info-value">Semestre {{ $module->semestre_numero }}</div>
            </div>
            <div class="module-detail-info-item">
                <div class="module-detail-info-label">Année académique</div>
                <div class="module-detail-info-value">{{ $module->annee_libelle }}</div>
            </div>
            <div class="module-detail-info-item">
                <div class="module-detail-info-label">Filière</div>
                <div class="module-detail-info-value">{{ $module->nom_filiere }}</div>
            </div>
            <div class="module-detail-info-item">
                <div class="module-detail-info-label">Statut semestre</div>
                <div class="module-detail-info-value">{{ $module->semestre_cloture ? 'Clôturé' : 'En cours' }}</div>
            </div>
            <div class="module-detail-info-item">
                <div class="module-detail-info-label">Nombre d'étudiants</div>
                <div class="module-detail-info-value">{{ $etudiants->count() }}</div>
            </div>
            <div class="module-detail-info-item">
                <div class="module-detail-info-label">Moyenne du module</div>
                <div class="module-detail-info-value">{{ $moyenne !== null ? number_format($moyenne, 2) . ' / 20' : '—' }}</div>
            </div>
            <div class="module-detail-info-item">
                <div class="module-detail-info-label">Réclamations</div>
                <div class="module-detail-info-value">{{ $reclamationsCount }}</div>
            </div>
        </div>

        <div class="section-grid">
            <div class="card">
                <div class="card-header">
                    <div><div class="card-header-title">Répartition des notes</div><div class="card-header-sub">Ce module</div></div>
                </div>
                <div class="card-body">
                    @php
                        $rep = $repartition ?? ['pass'=>0,'warn'=>0,'fail'=>0,'total'=>0];
                        $tot = max($rep['total'], 1);
                        $pW  = round(($rep['pass']/$tot)*100);
                        $wW  = round(($rep['warn']/$tot)*100);
                        $fW  = max(0, 100-$pW-$wW);
                    @endphp
                    <div class="rep-list">
                        <div class="rep-row">
                            <div class="rep-label"><span>Admis</span><small>≥ 12</small></div>
                            <div class="rep-bar-wrap"><div class="rep-bar rep-bar-pass" style="width:{{ $pW }}%"></div></div>
                            <span class="grade-pass rep-count">{{ $rep['pass'] }}</span>
                        </div>
                        <div class="rep-row">
                            <div class="rep-label"><span>Limite</span><small>10 – 12</small></div>
                            <div class="rep-bar-wrap"><div class="rep-bar rep-bar-warn" style="width:{{ $wW }}%"></div></div>
                            <span class="grade-warn rep-count">{{ $rep['warn'] }}</span>
                        </div>
                        <div class="rep-row">
                            <div class="rep-label"><span>Échec</span><small>&lt; 10</small></div>
                            <div class="rep-bar-wrap"><div class="rep-bar rep-bar-fail" style="width:{{ $fW }}%"></div></div>
                            <span class="grade-fail rep-count">{{ $rep['fail'] }}</span>
                        </div>
                        <div class="rep-total"><span>Total notes</span><strong>{{ $rep['total'] }}</strong></div>
                    </div>
                </div>
            </div>
            @if($module->filiere_description ?? null)
            <div class="card">
                <div class="card-header"><div class="card-header-title">Filière</div></div>
                <div class="card-body"><p style="font-size:14px;color:var(--text-secondary);line-height:1.6;">{{ $module->filiere_description }}</p></div>
            </div>
            @endif
        </div>

        <div class="card">
            <div class="card-header">
                <div><div class="card-header-title">Étudiants inscrits</div><div class="card-header-sub">Notes pour ce module</div></div>
            </div>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Étudiant</th><th class="center">CNE</th><th class="center">Note</th><th class="center">Rattrapage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($etudiants as $etu)
                        <tr>
                            <td>
                                <div class="etu-cell">
                                    <div class="user-avatar-small" style="width:28px;height:28px;font-size:11px;">
                                        {{ strtoupper(substr($etu->prenom ?? 'E', 0, 1)) }}{{ strtoupper(substr($etu->nom ?? 'T', 0, 1)) }}
                                    </div>
                                    <div><div style="font-size:14px;font-weight:500;">{{ $etu->prenom ?? '—' }} {{ $etu->nom ?? '' }}</div></div>
                                </div>
                            </td>
                            <td class="center"><span class="code-badge">{{ $etu->cne ?? '—' }}</span></td>
                            <td class="center">
                                @if(isset($etu->note))
                                    <span class="grade-value {{ $etu->note >= 12 ? 'grade-pass' : ($etu->note >= 10 ? 'grade-warn' : 'grade-fail') }}">{{ number_format($etu->note, 2) }}</span>
                                @else
                                    <span class="grade-empty">—</span>
                                @endif
                            </td>
                            <td class="center">
                                @if(isset($etu->rattrapage))
                                    <span class="grade-value">{{ number_format($etu->rattrapage, 2) }}</span>
                                @else
                                    <span class="grade-empty">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4"><div class="empty-state">Aucun étudiant inscrit pour ce module.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script>
    (function() { if (localStorage.getItem('theme') === 'dark') document.getElementById('theme-toggle').classList.add('on'); })();
    function toggleTheme() {
        var html = document.documentElement, btn = document.getElementById('theme-toggle');
        html.classList.toggle('dark'); btn.classList.toggle('on');
        localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
    }
</script>
</body>
</html>
