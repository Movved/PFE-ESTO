<!DOCTYPE html>
<html lang="fr">
<head>
    <script>
        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css', 'resources/js/admin/admin.js'])
</head>
<body>
    @include('layouts.sidebar-admin')
    <div class="main" id="main-content">
        @include('layouts.topbar', ['title' => 'Dashboard'])
        <main class="content">

            <div class="dept-banner">
                <div>
                    <div class="dept-banner-eyebrow">Administration</div>
                    <div class="dept-banner-title">Bonjour, {{ Auth::user()->prenom }}</div>
                    <div class="dept-banner-sub">Vue administrateur — état général de la plateforme</div>
                </div>
                <div class="dept-banner-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                        <path d="M2 17l10 5 10-5"/>
                        <path d="M2 12l10 5 10-5"/>
                    </svg>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Étudiants</span>
                        <span class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></span>
                    </div>
                    <div class="stat-value">{{ $totalEtudiants }}</div>
                    <div class="stat-sub">inscrits</div>
                </div>
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Enseignants</span>
                        <span class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
                    </div>
                    <div class="stat-value">{{ $totalEnseignants }}</div>
                    <div class="stat-sub">actifs</div>
                </div>
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Modules</span>
                        <span class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg></span>
                    </div>
                    <div class="stat-value">{{ $totalModules }}</div>
                    <div class="stat-sub">tous semestres</div>
                </div>
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Réclamations</span>
                        <span class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg></span>
                    </div>
                    <div class="stat-value">{{ $totalReclamations }}</div>
                    <div class="stat-sub {{ $totalReclamations > 0 ? 'warn' : '' }}">en attente</div>
                </div>
            </div>

            <div class="two-col">
                <div class="card">
                    <div class="card-header">
                        <div><div class="card-title">Utilisateurs récents</div><div class="card-sub">Derniers comptes créés</div></div>
                    </div>
                    <table>
                        <thead><tr><th>Utilisateur</th><th>Rôle</th><th>Statut</th></tr></thead>
                        <tbody>
                            @forelse($recentUsers as $u)
                                <tr>
                                    <td>
                                        <div class="etu-cell">
                                            <div class="user-avatar-small">{{ strtoupper(substr($u->prenom,0,1)) }}{{ strtoupper(substr($u->nom,0,1)) }}</div>
                                            <div><div class="etu-name">{{ $u->prenom }} {{ $u->nom }}</div><div class="cell-secondary">{{ $u->email }}</div></div>
                                        </div>
                                    </td>
                                    <td><span class="badge badge-pending"><span class="badge-dot"></span>{{ $u->role }}</span></td>
                                    <td><span class="badge {{ $u->actif ? 'badge-open' : 'badge-closed' }}"><span class="badge-dot"></span>{{ $u->actif ? 'Actif' : 'Inactif' }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="3"><div class="empty-state">Aucun utilisateur.</div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div><div class="card-title">Filières</div><div class="card-sub">Répartition étudiants</div></div>
                    </div>
                    <div class="card-body">
                        <div class="rep-list">
                            @forelse($filiereStats as $f)
                                <div class="rep-row">
                                    <div class="rep-label"><span>{{ Str::limit($f->nom_filiere, 18) }}</span><small>{{ $f->nb_etudiants }}</small></div>
                                    <div class="rep-bar-wrap"><div class="rep-bar rep-bar-pass" style="width:{{ $totalEtudiants > 0 ? round(($f->nb_etudiants/$totalEtudiants)*100) : 0 }}%"></div></div>
                                    <span class="rep-count" style="color:var(--text-3)">{{ $totalEtudiants > 0 ? round(($f->nb_etudiants/$totalEtudiants)*100) : 0 }}%</span>
                                </div>
                            @empty
                                <div class="empty-state">Aucune filière.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div><div class="card-title">Réclamations en attente</div><div class="card-sub">À traiter</div></div>
                    <a href="{{ route('admin.reclamations') }}" class="card-link">Voir tout →</a>
                </div>
                <div class="table-scroll">
                    <table>
                        <thead><tr><th>Étudiant</th><th>Module</th><th>Message</th><th>Date</th><th class="center">Action</th></tr></thead>
                        <tbody>
                            @forelse($reclamationsEnAttente as $rec)
                                <tr>
                                    <td><div class="etu-cell"><div class="user-avatar-small">{{ strtoupper(substr($rec->prenom,0,1)) }}{{ strtoupper(substr($rec->nom,0,1)) }}</div><div class="etu-name">{{ $rec->prenom }} {{ $rec->nom }}</div></div></td>
                                    <td><span class="module-name">{{ $rec->nom_module }}</span></td>
                                    <td class="cell-secondary">{{ Str::limit($rec->message, 60) }}</td>
                                    <td class="cell-secondary">{{ \Carbon\Carbon::parse($rec->date_reclamation)->format('d/m/Y') }}</td>
                                    <td class="center"><a href="{{ route('admin.reclamations.show', $rec->id_reclamation) }}" class="btn btn-secondary btn-sm">Voir</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5"><div class="empty-state">Aucune réclamation en attente.</div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div><div class="card-title">Journal d'activité récent</div><div class="card-sub">Dernières actions</div></div>
                    <a href="{{ route('admin.logs') }}" class="card-link">Voir tout →</a>
                </div>
                <div class="table-scroll">
                    <table>
                        <thead><tr><th>Action</th><th>Table</th><th>Enregistrement</th><th>Effectuée par</th><th>Date</th></tr></thead>
                        <tbody>
                            @forelse($recentLogs as $log)
                                <tr>
                                    <td>@php $c=match(strtoupper($log->action)){'CREATE'=>'var(--green)','UPDATE'=>'var(--gold)','DELETE'=>'var(--red)',default=>'var(--text-3)'}; @endphp<span style="font-family:'JetBrains Mono',monospace;font-size:10px;font-weight:700;color:{{ $c }};letter-spacing:0.08em;text-transform:uppercase;">{{ $log->action }}</span></td>
                                    <td><span class="code-badge">{{ $log->table_concernee }}</span></td>
                                    <td class="cell-secondary">#{{ $log->id_enregistrement }}</td>
                                    <td>@if($log->user)<div class="etu-cell"><div class="user-avatar-small">{{ strtoupper(substr($log->user->prenom,0,1)) }}{{ strtoupper(substr($log->user->nom,0,1)) }}</div><span class="etu-name">{{ $log->user->prenom }} {{ $log->user->nom }}</span></div>@else<span class="cell-secondary">Système</span>@endif</td>
                                    <td class="cell-secondary">{{ \Carbon\Carbon::parse($log->date_action)->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5"><div class="empty-state">Aucun log.</div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</body>
</html>