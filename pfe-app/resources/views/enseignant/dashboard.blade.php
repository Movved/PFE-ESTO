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
    <title>Dashboard Enseignant</title>
    @vite(['resources/css/app.css', 'resources/css/enseignant/dashboard.css', 'resources/js/app.js'])
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
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
        <a href="{{ route('enseignant.notes') }}" class="nav-item {{ request()->routeIs('enseignant.notes*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            Saisie des Notes
        </a>
        <a href="{{ route('enseignant.reclamations') }}" class="nav-item {{ request()->routeIs('enseignant.reclamations*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
            Réclamations
            @if(isset($pendingCount) && $pendingCount > 0)
                <span class="nav-badge">{{ $pendingCount }}</span>
            @endif
        </a>
        <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Profil
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;font-size:14px;font-family:inherit;color:var(--text-secondary);">
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
                <div class="sidebar-user-role">Enseignant</div>
            </div>
            <span class="sidebar-user-more">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/></svg>
            </span>
        </div>
    </div>
</aside>

<div class="main">
    <header class="topbar">
        <span class="topbar-title">Dashboard</span>
        <div class="topbar-search">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="text" placeholder="Rechercher un étudiant..." />
        </div>
        <button class="toggle-btn" id="theme-toggle" onclick="toggleTheme()" title="Thème sombre">
            <span class="toggle-knob"></span>
        </button>
        <div class="topbar-icon-btn" style="position:relative;">
            <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
            @if(isset($pendingCount) && $pendingCount > 0)
                <span class="notif-dot"></span>
            @endif
        </div>
        <div class="topbar-icon-btn">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
    </header>

    <main class="content">

        @if(session('success'))
            <div class="alert alert-success">
                <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue"><svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg></div>
                <div><div class="stat-value">{{ $totalModules ?? 0 }}</div><div class="stat-label">Modules enseignés</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></div>
                <div><div class="stat-value">{{ $totalEtudiants ?? 0 }}</div><div class="stat-label">Étudiants suivis</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg></div>
                <div><div class="stat-value">{{ $pendingCount ?? 0 }}</div><div class="stat-label">Réclamations en attente</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red"><svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
                <div><div class="stat-value">{{ isset($moyenneGlobale) ? number_format($moyenneGlobale, 1) : '—' }}</div><div class="stat-label">Moyenne générale</div></div>
            </div>
        </div>

        <div class="section-grid">
            <div class="card">
                <div class="card-header">
                    <div><div class="card-header-title">Mes Modules</div><div class="card-header-sub">Année académique en cours</div></div>
                    <a href="{{ route('enseignant.modules') }}" class="btn btn-secondary" style="padding:5px 12px;font-size:13px;">Voir tout</a>
                </div>
                @forelse($modules ?? [] as $module)
                <a href="{{ route('enseignant.module.show', $module->id_module) }}" class="module-item" style="text-decoration:none;color:inherit;">
                    <div class="module-dot"></div>
                    <div class="module-item-info">
                        <div class="module-item-name">{{ $module->nom_module }}</div>
                        <div class="module-item-sem"><span class="code-badge">{{ $module->code_module }}</span> · Semestre {{ $module->semestre_numero ?? '—' }}</div>
                    </div>
                    <div class="module-item-count">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        {{ $module->nb_etudiants ?? 0 }}
                    </div>
                </a>
                @empty
                <div class="empty-state" style="padding:40px 24px;">
                    <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                    Aucun module assigné pour le moment.
                </div>
                @endforelse
            </div>

            <div class="card">
                <div class="card-header">
                    <div><div class="card-header-title">Répartition des notes</div><div class="card-header-sub">Tous modules confondus</div></div>
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
                        <div class="rep-total"><span>Total notes saisies</span><strong>{{ $rep['total'] }}</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-header-title">Réclamations des étudiants</div>
                    <div class="card-header-sub">
                        @if(isset($pendingCount) && $pendingCount > 0)
                            <span style="color:var(--warning);font-weight:500;">{{ $pendingCount }} en attente</span>
                        @else
                            Toutes les réclamations ont été traitées
                        @endif
                    </div>
                </div>
                <a href="{{ route('enseignant.reclamations') }}" class="btn btn-secondary" style="padding:5px 12px;font-size:13px;">Voir tout</a>
            </div>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Étudiant</th><th>Module</th><th class="center">Note</th>
                            <th>Message</th><th class="center">Date</th><th class="center">Statut</th><th class="center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reclamations ?? [] as $rec)
                        <tr>
                            <td>
                                <div class="etu-cell">
                                    <div class="user-avatar-small" style="width:28px;height:28px;font-size:11px;">
                                        {{ strtoupper(substr($rec->prenom_etudiant ?? 'E', 0, 1)) }}{{ strtoupper(substr($rec->nom_etudiant ?? 'T', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-size:14px;font-weight:500;">{{ $rec->prenom_etudiant ?? '—' }} {{ $rec->nom_etudiant ?? '' }}</div>
                                        <div style="font-size:12px;color:var(--text-secondary);">{{ $rec->cne_etudiant ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="module-name">{{ $rec->nom_module ?? '—' }}</span><br><span class="code-badge">{{ $rec->code_module ?? '' }}</span></td>
                            <td class="center">
                                @if(isset($rec->note))
                                    <span class="grade-value {{ $rec->note >= 12 ? 'grade-pass' : ($rec->note >= 10 ? 'grade-warn' : 'grade-fail') }}">{{ number_format($rec->note, 2) }}</span>
                                @else
                                    <span class="grade-empty">—</span>
                                @endif
                            </td>
                            <td><div class="rec-msg" title="{{ $rec->message ?? '' }}">{{ $rec->message ?? '—' }}</div></td>
                            <td class="center"><span style="font-size:13px;color:var(--text-secondary);">{{ isset($rec->date_reclamation) ? \Carbon\Carbon::parse($rec->date_reclamation)->format('d/m/Y') : '—' }}</span></td>
                            <td class="center">
                                @if(isset($rec->traite) && $rec->traite)
                                    <span class="badge badge-resolved"><span class="badge-dot"></span>Traitée</span>
                                @else
                                    <span class="badge badge-pending"><span class="badge-dot"></span>En attente</span>
                                @endif
                            </td>
                            <td class="center">
                                <button class="btn-voir" onclick="openModal({{ $rec->id_reclamation }}, '{{ addslashes(($rec->prenom_etudiant ?? '').' '.($rec->nom_etudiant ?? '')) }}', '{{ addslashes($rec->nom_module ?? '') }}', {{ $rec->note ?? 'null' }}, `{{ addslashes($rec->message ?? '') }}`)">
                                    Voir
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7"><div class="empty-state"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>Aucune réclamation pour le moment.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

<div class="modal-overlay" id="rec-modal" onclick="if(event.target===this)closeModal()">
    <div class="modal">
        <div class="modal-header">
            <div><div class="modal-title">Détail de la réclamation</div><div class="modal-sub" id="modal-sub"></div></div>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="modal-note-row">
                <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                <span style="font-size:13px;color:var(--text-secondary);">Note actuelle :&nbsp;</span>
                <span id="modal-note" style="font-size:14px;font-weight:600;"></span>
            </div>
            <div style="font-size:13px;color:var(--text-secondary);margin-bottom:6px;font-weight:500;">Message de l'étudiant</div>
            <div id="modal-msg" class="modal-msg-box"></div>
            <form method="POST" action="{{ route('enseignant.reclamations.traiter', ['id' => 0]) }}" id="rec-form" style="margin-top:16px;">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id_reclamation" id="modal-rec-id">
                <div style="display:flex;flex-direction:column;gap:6px;">
                    <label style="font-size:13px;font-weight:500;color:var(--text-primary);">Réponse / Commentaire</label>
                    <textarea name="reponse" rows="3" placeholder="Expliquez votre décision..." class="modal-textarea"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Fermer</button>
            <button type="submit" form="rec-form" class="btn btn-primary">Marquer comme traitée</button>
        </div>
    </div>
</div>

<script>
    (function() {
        if (localStorage.getItem('theme') === 'dark') {
            document.getElementById('theme-toggle').classList.add('on');
        }
    })();
    function toggleTheme() {
        const html = document.documentElement, btn = document.getElementById('theme-toggle');
        html.classList.toggle('dark'); btn.classList.toggle('on');
        localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
    }
    function openModal(id, etudiant, module, note, message) {
        document.getElementById('modal-sub').textContent = etudiant + ' · ' + module;
        document.getElementById('modal-msg').textContent = message || '—';
        document.getElementById('modal-rec-id').value    = id;
        document.getElementById('rec-form').action = '{{ url("enseignant/reclamations") }}/' + id + '/traiter';
        const el = document.getElementById('modal-note');
        el.textContent = (note !== null && note !== undefined) ? parseFloat(note).toFixed(2) + ' / 20' : '—';
        el.className   = note >= 12 ? 'grade-pass' : (note >= 10 ? 'grade-warn' : 'grade-fail');
        document.getElementById('rec-modal').classList.add('open');
    }
    function closeModal() { document.getElementById('rec-modal').classList.remove('open'); }
</script>
</body>
</html>