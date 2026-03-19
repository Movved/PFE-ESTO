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
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/etudiant/etudiant.css', 'resources/js/etudiant/etudiant.js'])
</head>

<body>
    @include('layouts.sidebar-etudiant')
    <div class="sb-tooltip" id="sb-tooltip"></div>

    <div class="main" id="main-content">
        @include('layouts.topbar', ['title' => 'Dashboard'])

        <main class="content">

            {{-- WELCOME BANNER --}}
            <div class="welcome-banner">
                <div>
                    <div class="welcome-text-title">Bonjour, {{ Auth::user()->prenom }}</div>
                    <div class="welcome-text-sub">
                        Voici un aperçu de votre situation académique.
                        @if($etudiant)
                            <span class="cne-tag" style="margin-left:10px;">{{ $etudiant->cne }}</span>
                        @endif
                    </div>
                </div>
                <div class="welcome-banner-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
                    </svg>
                </div>
            </div>

            {{-- STAT CARDS --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Modules</span>
                        <span class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                            </svg>
                        </span>
                    </div>
                    <div class="stat-value">{{ $totalModules }}</div>
                    <div class="stat-sub">ce semestre</div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Moyenne générale</span>
                        <span class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                            </svg>
                        </span>
                    </div>
                    <div class="stat-value {{ $moyenne >= 12 ? 'grade-pass' : ($moyenne >= 10 ? 'grade-warn' : 'grade-fail') }}">
                        {{ number_format($moyenne, 2) }}
                    </div>
                    <div class="stat-sub {{ $moyenne >= 12 ? 'up' : ($moyenne >= 10 ? 'warn' : 'down') }}">
                        {{ $moyenne >= 12 ? '✓ Validé' : ($moyenne >= 10 ? '⚠ Limite' : '✗ Insuffisant') }}
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Notes saisies</span>
                        <span class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 11l3 3L22 4"/>
                                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                            </svg>
                        </span>
                    </div>
                    <div class="stat-value">
                        {{ $notesCount }}
                        <span class="stat-value-suffix">/ {{ $totalModules }}</span>
                    </div>
                    <div class="stat-sub">
                        {{ $totalModules > 0 ? round(($notesCount / max($totalModules, 1)) * 100) : 0 }}% complété
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Réclamations</span>
                        <span class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                        </span>
                    </div>
                    <div class="stat-value">{{ $reclamationsCount }}</div>
                    <div class="stat-sub {{ $pendingCount > 0 ? 'warn' : '' }}">
                        {{ $pendingCount > 0 ? $pendingCount . ' en attente' : 'Aucune en attente' }}
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
                    @forelse($recentNotes as $note)
                        <div class="progress-row">
                            <div class="progress-label">
                                <span>{{ $note->nom_module }}</span>
                                <span class="{{ $note->note >= 12 ? 'grade-pass' : ($note->note >= 10 ? 'grade-warn' : 'grade-fail') }}">
                                    {{ $note->note !== null ? number_format($note->note, 2) . '/20' : '—' }}
                                </span>
                            </div>
                            @if($note->note !== null)
                                <div class="progress-bar">
                                    <div class="progress-fill {{ $note->note >= 12 ? 'success' : ($note->note >= 10 ? 'warning' : 'danger') }}"
                                        style="width:{{ min(($note->note / 20) * 100, 100) }}%"></div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24">
                                <path d="M9 11l3 3L22 4"/>
                                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                            </svg>
                            Aucune note disponible.
                        </div>
                    @endforelse
                </div>

                {{-- RECLAMATIONS --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-title">Mes réclamations</div>
                            <div class="card-sub">Historique de vos signalements</div>
                        </div>
                    </div>
                    @forelse($reclamations as $rec)
                        <div class="rec-item">
                            <div>
                                <div class="rec-module">{{ $rec->nom_module }}</div>
                                <div class="rec-message">{{ Str::limit($rec->message, 60) }}</div>
                                <div class="rec-date">{{ \Carbon\Carbon::parse($rec->date_reclamation)->format('d/m/Y') }}</div>
                            </div>
                            <span class="badge badge-pending">
                                <span class="badge-dot"></span>
                                En attente
                            </span>
                        </div>
                    @empty
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            Aucune réclamation soumise.
                        </div>
                    @endforelse
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
                <div class="table-scroll">
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
                            @forelse($notes as $row)
                                <tr>
                                    <td class="module-name">{{ $row->nom_module }}</td>
                                    <td><span class="code-badge">{{ $row->code_module }}</span></td>
                                    <td class="center">
                                        @if($row->note !== null)
                                            <span class="grade-value {{ $row->note >= 12 ? 'grade-pass' : ($row->note >= 10 ? 'grade-warn' : 'grade-fail') }}">
                                                {{ number_format($row->note, 2) }}
                                            </span>
                                        @else
                                            <span class="grade-empty">—</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        @if($row->rattrapage !== null)
                                            <span class="grade-value {{ $row->rattrapage >= 12 ? 'grade-pass' : ($row->rattrapage >= 10 ? 'grade-warn' : 'grade-fail') }}">
                                                {{ number_format($row->rattrapage, 2) }}
                                            </span>
                                        @else
                                            <span class="grade-empty">—</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        @if($row->note !== null)
                                            <div class="prog-wrap">
                                                <div class="prog-bar">
                                                    <div class="prog-fill {{ $row->note >= 12 ? 'success' : ($row->note >= 10 ? 'warning' : 'danger') }}"
                                                        style="width:{{ min(($row->note / 20) * 100, 100) }}%"></div>
                                                </div>
                                                <span class="prog-pct">{{ round(($row->note / 20) * 100) }}%</span>
                                            </div>
                                        @else
                                            <span class="grade-empty">—</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        @if($row->note === null)
                                            <span class="cell-secondary">En attente</span>
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
                                                <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
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