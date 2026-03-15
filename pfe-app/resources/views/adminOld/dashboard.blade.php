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
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* STAT CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px 22px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .stat-icon svg {
            width: 18px;
            height: 18px;
            stroke: var(--text-secondary);
            stroke-width: 1.5;
            fill: none;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-sub {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .stat-sub.up {
            color: var(--success);
        }

        .stat-sub.down {
            color: var(--danger);
        }

        .stat-sub.warn {
            color: var(--warning);
        }

        /* TWO COLUMN LAYOUT */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .full-col {
            margin-bottom: 24px;
        }

        /* CARD */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
        }

        .card-header-left {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .card-sub {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .card-link {
            font-size: 12px;
            font-weight: 500;
            color: var(--primary);
            text-decoration: none;
        }

        .card-link:hover {
            text-decoration: underline;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: var(--background);
        }

        th {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            padding: 9px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        th.center,
        td.center {
            text-align: center;
        }

        td {
            padding: 0 16px;
            height: 42px;
            font-size: 13px;
            color: var(--text-primary);
            border-top: 1px solid var(--border);
            vertical-align: middle;
        }

        tbody tr {
            transition: background 0.15s ease;
        }

        tbody tr:hover {
            background: var(--background);
        }

        .grade-value {
            font-family: "SF Mono", "Fira Code", monospace;
            font-weight: 600;
        }

        .grade-pass {
            color: var(--success);
        }

        .grade-warn {
            color: var(--warning);
        }

        .grade-fail {
            color: var(--danger);
        }

        /* BADGE */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }

        .badge-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
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

        .badge-rejected {
            background: #FFF2F1;
            color: #C0392B;
        }

        .badge-rejected .badge-dot {
            background: var(--danger);
        }

        /* WELCOME BANNER */
        .welcome-banner {
            background: var(--primary);
            border-radius: 12px;
            padding: 24px 28px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .welcome-text-title {
            font-size: 18px;
            font-weight: 600;
            color: white;
            margin-bottom: 4px;
        }

        .welcome-text-sub {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.75);
        }

        .welcome-banner-icon svg {
            width: 48px;
            height: 48px;
            stroke: rgba(255, 255, 255, 0.4);
            stroke-width: 1.5;
            fill: none;
        }

        /* PROGRESS BAR */
        .progress-row {
            padding: 12px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: var(--text-secondary);
        }

        .progress-label span:last-child {
            font-weight: 500;
            color: var(--text-primary);
        }

        .progress-bar {
            height: 5px;
            background: var(--border);
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 4px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .progress-fill.success {
            background: var(--success);
        }

        .progress-fill.warning {
            background: var(--warning);
        }

        .progress-fill.danger {
            background: var(--danger);
        }

        /* EMPTY */
        .empty-state {
            padding: 36px 20px;
            text-align: center;
            color: var(--text-secondary);
            font-size: 13px;
        }

        .empty-state svg {
            width: 28px;
            height: 28px;
            stroke: var(--border);
            stroke-width: 1.5;
            fill: none;
            margin: 0 auto 8px;
            display: block;
        }

        /* ACTIVITY ITEM */
        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 20px;
            border-top: 1px solid var(--border);
        }

        .activity-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--border);
            flex-shrink: 0;
            margin-top: 5px;
        }

        .activity-dot.blue {
            background: var(--primary);
        }

        .activity-dot.green {
            background: var(--success);
        }

        .activity-dot.orange {
            background: var(--warning);
        }

        .activity-text {
            font-size: 13px;
            color: var(--text-primary);
            line-height: 1.5;
        }

        .activity-time {
            font-size: 11px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        /* CNE BADGE */
        .cne-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--background);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 3px 10px;
            font-size: 12px;
            font-family: "SF Mono", "Fira Code", monospace;
            color: var(--text-secondary);
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                    <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5" />
                </svg>
            </div>
            <span class="sidebar-logo-text">Gestionnaire</span>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" />
                    <rect x="14" y="3" width="7" height="7" />
                    <rect x="3" y="14" width="7" height="7" />
                    <rect x="14" y="14" width="7" height="7" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.notes') }}"
                class="nav-item {{ request()->routeIs('admin.notes') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24">
                    <path d="M9 11l3 3L22 4" />
                    <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
                </svg>
                Mes Notes
            </a>
            <a href="{{ route('admin.cours') }}"
                class="nav-item {{ request()->routeIs('admin.cours') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24">
                    <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                </svg>
                Mes Cours
            </a>
            <a href="{{ route('profile.edit') }}"
                class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                Profil
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
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
                    <div class="sidebar-user-role">Étudiant</div>
                </div>


                <div style="position:relative;">
                    <button onclick="toggleUserMenu()" class="sidebar-user-more">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="5" r="1" />
                            <circle cx="12" cy="12" r="1" />
                            <circle cx="12" cy="19" r="1" />
                        </svg>
                    </button>

                    <div id="user-menu">
                        <a href="{{ route('profile.edit') }}">
                            <svg viewBox="0 0 24 24">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Profil
                        </a>

                        <button onclick="toggleThemeFromMenu()">
                            <svg viewBox="0 0 24 24" id="theme-icon">
                                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                            </svg>
                            <span id="theme-label">Mode sombre</span>
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Dashboard</span>
            <div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
                <span id="topbar-time"
                    style="font-size:14px; font-weight:600; color:var(--text-primary); font-family:'SF Mono','Fira Code',monospace;"></span>
                <span id="topbar-date" style="font-size:11px; color:var(--text-secondary);"></span>
            </div>
        </header>

        <main class="content">

            {{-- WELCOME BANNER --}}
            <div class="welcome-banner">
                <div>
                    <div class="welcome-text-title">Bonjour, {{ Auth::user()->prenom }} </div>
                    <div class="welcome-text-sub">
                        Voici un aperçu de votre situation académique.
                        
                            <span class="cne-tag"
                                style="margin-left:10px; background:rgba(255,255,255,0.15); border-color:rgba(255,255,255,0.2); color:rgba(255,255,255,0.8);">
                                
                            </span>
                        
                    </div>
                </div>
                <div class="welcome-banner-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                        <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5" />
                    </svg>
                </div>
            </div>

            {{-- STAT CARDS --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Modules</span>
                        <span class="stat-icon"><svg viewBox="0 0 24 24">
                                <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                            </svg></span>
                    </div>
                    
                    <div class="stat-sub">ce semestre</div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Moyenne générale</span>
                        <span class="stat-icon"><svg viewBox="0 0 24 24">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                            </svg></span>
                    </div>
                    
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Notes saisies</span>
                        <span class="stat-icon"><svg viewBox="0 0 24 24">
                                <path d="M9 11l3 3L22 4" />
                                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
                            </svg></span>
                    </div>
                    
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Réclamations</span>
                        <span class="stat-icon"><svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg></span>
                    </div>
                    
                </div>
            </div>

            {{-- TWO COLUMNS --}}
            <div class="two-col">

                {{-- RECENT NOTES --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-title">Notes récentes</div>
                            <div class="card-sub">Derniers résultats enregistrés</div>
                        </div>
                        <a href="{{ route('etudiant.notes') }}" class="card-link">Voir tout →</a>
                    </div>
                    
                        <div class="progress-row">
                            <div class="progress-label">
                                <span>{{ $note->nom_module }}</span>
                                <span
                                    class="{{ $note->note >= 12 ? 'grade-pass' : ($note->note >= 10 ? 'grade-warn' : 'grade-fail') }}"
                                    style="font-family:'SF Mono','Fira Code',monospace; font-size:13px; font-weight:600;">
                                    
                                </span>
                            </div>
                            
                                <div class="progress-bar">
                                    <div class="progress-fill {{ $note->note >= 12 ? 'success' : ($note->note >= 10 ? 'warning' : 'danger') }}"
                                        style="width: {{ min(($note->note / 20) * 100, 100) }}%"></div>
                                </div>
                            
                        </div>
                    
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24">
                                <path d="M9 11l3 3L22 4" />
                                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
                            </svg>
                            Aucune note disponible.
                        </div>
                    
                </div>

                {{-- RECLAMATIONS --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-title">Mes réclamations</div>
                            <div class="card-sub">Historique de vos signalements</div>
                        </div>
                    </div>
                    
                        <div style="padding: 12px 20px; border-top: 1px solid var(--border);">
                            <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:12px;">
                                <div>
                                    <div
                                        style="font-size:13px; font-weight:500; color:var(--text-primary); margin-bottom:3px;">
                                        
                                    </div>
                                    <div style="font-size:12px; color:var(--text-secondary); line-height:1.5;">
                                        
                                    </div>
                                    <div style="font-size:11px; color:var(--text-secondary); margin-top:4px;">
                                        
                                    </div>
                                </div>
                                <span class="badge badge-pending">
                                    <span class="badge-dot"></span>
                                    En attente
                                </span>
                            </div>
                        </div>
                    
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            Aucune réclamation soumise.
                        </div>
                    
                </div>
            </div>

            {{-- MODULES PROGRESSION --}}
            <div class="card full-col">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-title">Progression par module</div>
                        <div class="card-sub">Vue d'ensemble de vos résultats</div>
                    </div>
                    <a href="{{ route('etudiant.notes') }}" class="card-link">Détails →</a>
                </div>
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th>Code</th>
                                <th class="center">Note</th>
                                <th class="center">Rattrapage</th>
                                <th class="center">Progression</th>
                                <th class="center">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                <tr>
                                    <td style="font-weight:500;">{{ $row->nom_module }}</td>
                                    <td
                                        style="font-size:12px; color:var(--text-secondary); font-family:'SF Mono','Fira Code',monospace;">
                                        
                                    </td>
                                    <td class="center">
                                        
                                            <span
                                                class="grade-value {{ $row->note >= 12 ? 'grade-pass' : ($row->note >= 10 ? 'grade-warn' : 'grade-fail') }}">
                                                
                                            </span>
                                        
                                            <span style="color:var(--text-secondary);">—</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        @if($row->rattrapage !== null)
                                            <span
                                                class="grade-value {{ $row->rattrapage >= 12 ? 'grade-pass' : ($row->rattrapage >= 10 ? 'grade-warn' : 'grade-fail') }}">
                                                {{ number_format($row->rattrapage, 2) }}
                                            </span>
                                        @else
                                            <span style="color:var(--text-secondary);">—</span>
                                        @endif
                                    </td>
                                    <td class="center" style="min-width:120px;">
                                        @if($row->note !== null)
                                            <div style="display:flex; align-items:center; gap:8px; justify-content:center;">
                                                <div
                                                    style="flex:1; height:5px; background:var(--border); border-radius:4px; overflow:hidden; max-width:80px;">
                                                    <div
                                                        style="height:100%; border-radius:4px; width:{{ min(($row->note / 20) * 100, 100) }}%;
                                                                            background:{{ $row->note >= 12 ? 'var(--success)' : ($row->note >= 10 ? 'var(--warning)' : 'var(--danger)') }};">
                                                    </div>
                                                </div>
                                                <span
                                                    style="font-size:11px; color:var(--text-secondary);">{{ round(($row->note / 20) * 100) }}%</span>
                                            </div>
                                        @else
                                            <span style="color:var(--text-secondary); font-size:13px;">—</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        @if($row->note === null)
                                            <span style="color:var(--text-secondary); font-size:12px;">En attente</span>
                                        @elseif($row->note >= 10 || ($row->rattrapage !== null && $row->rattrapage >= 10))
                                            <span class="badge badge-resolved"><span class="badge-dot"></span>Validé</span>
                                        @else
                                            <span class="badge badge-rejected"><span class="badge-dot"></span>Échoué</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                                            </svg>
                                            Aucun module inscrit pour ce semestre.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</body>

</html>