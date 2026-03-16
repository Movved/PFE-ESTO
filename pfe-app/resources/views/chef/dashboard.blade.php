<!DOCTYPE html>
<html lang="fr">

<head>
    <script>if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Chef</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    {{-- SIDEBAR --}}
    @include('layouts.sidebar-chef')

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
            {{-- DEPT BANNER --}}
            <div class="dept-banner">
                <div>
                    <div class="dept-banner-title">{{ $departement->nom_departement }}</div>
                    <div class="dept-banner-sub">Bonjour, {{ Auth::user()->prenom }} — Chef de département</div>
                </div>
                <div class="dept-banner-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                        <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5" />
                    </svg>
                </div>
            </div>

            {{-- STATS --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Filières</span>
                        <span class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z" />
                            </svg>
                        </span>
                    </div>
                    <div class="stat-value">{{ $totalFilieres }}</div>
                    <div class="stat-sub">dans votre département</div>
                </div>
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Modules</span>
                        <span class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                            </svg>
                        </span>
                    </div>
                    <div class="stat-value">{{ $totalModules }}</div>
                    <div class="stat-sub">tous semestres confondus</div>
                </div>
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Enseignants</span>
                        <span class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </span>
                    </div>
                    <div class="stat-value">{{ $totalEnseignants }}</div>
                    <div class="stat-sub">dans votre département</div>
                </div>
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Étudiants</span>
                        <span class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 00-3-3.87" />
                                <path d="M16 3.13a4 4 0 010 7.75" />
                            </svg>
                        </span>
                    </div>
                    <div class="stat-value">{{ $totalEtudiants }}</div>
                    <div class="stat-sub">inscrits</div>
                </div>
            </div>

            {{-- TWO COLUMNS --}}
            <div class="two-col">
                {{-- RECENT MODULES --}}
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Modules récents</div>
                            <div class="card-sub">Aperçu des modules de votre département</div>
                        </div>
                        <a href="{{ route('chef.modules') }}" class="card-link">Voir tout →</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th>Filière</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentModules as $m)
                                <tr>
                                    <td>
                                        <div style="font-weight:500;">{{ $m->nom_module }}</div>
                                        <div><span class="code-badge">{{ $m->code_module }}</span></div>
                                    </td>
                                    <td style="font-size:12px; color:var(--text-secondary);">{{ $m->nom_filiere }}</td>
                                    <td>
                                        <span class="badge {{ $m->cloture ? 'badge-closed' : 'badge-open' }}">
                                            <span class="badge-dot"></span>
                                            {{ $m->cloture ? 'Clôturé' : 'En cours' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <div class="empty-state">Aucun module.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- FILIERES --}}
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Filières</div>
                            <div class="card-sub">Filières de votre département</div>
                        </div>
                        <a href="{{ route('chef.filieres') }}" class="card-link">Gérer →</a>
                    </div>
                    <div class="filiere-list">
                        @forelse($filieres as $f)
                            <div class="filiere-item">
                                <div>
                                    <div>{{ $f->nom_filiere }}</div>
                                    <div class="filiere-desc">{{ Str::limit($f->description, 50) }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">Aucune filière.</div>
                        @endforelse
                    </div>
                </div>
            </div>

        </main>
    </div>

</body>

</html>