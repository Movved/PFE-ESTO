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
    <title>{{ $module->nom_module }} — Enseignant</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/enseignant/enseignant.css', 'resources/js/enseignant/enseignant.js'])
</head>
<body>
    @include('layouts.sidebar-enseignant')

    <div class="layout">
        <div class="main" id="main-content">
            @include('layouts.topbar', [
                'title'             => $module->nom_module,
                'search'            => true,
                'searchPlaceholder' => 'Rechercher un étudiant...',
            ])

            <main class="content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('enseignant.modules') }}" class="module-back">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Retour aux modules
                </a>

                <div class="module-header">
                    <div>
                        <h1 class="module-title">{{ $module->nom_module }}</h1>
                        <span class="code-badge">{{ $module->code_module }}</span>
                    </div>
                </div>

                <div class="module-info-grid">
                    <div class="module-info-item">
                        <div class="module-info-label">Semestre</div>
                        <div class="module-info-value">Semestre {{ $module->semestre_numero }}</div>
                    </div>
                    <div class="module-info-item">
                        <div class="module-info-label">Année académique</div>
                        <div class="module-info-value">{{ $module->annee_libelle }}</div>
                    </div>
                    <div class="module-info-item">
                        <div class="module-info-label">Filière</div>
                        <div class="module-info-value">{{ $module->nom_filiere }}</div>
                    </div>
                    <div class="module-info-item">
                        <div class="module-info-label">Statut semestre</div>
                        <div class="module-info-value">
                            <span class="badge {{ $module->semestre_cloture ? 'badge-closed' : 'badge-open' }}">
                                <span class="badge-dot"></span>
                                {{ $module->semestre_cloture ? 'Clôturé' : 'En cours' }}
                            </span>
                        </div>
                    </div>
                    <div class="module-info-item">
                        <div class="module-info-label">Nombre d'étudiants</div>
                        <div class="module-info-value">{{ $etudiants->count() }}</div>
                    </div>
                    <div class="module-info-item">
                        <div class="module-info-label">Moyenne du module</div>
                        <div class="module-info-value">{{ $moyenne !== null ? number_format($moyenne, 2) . ' / 20' : '—' }}</div>
                    </div>
                    <div class="module-info-item">
                        <div class="module-info-label">Réclamations</div>
                        <div class="module-info-value">{{ $reclamationsCount }}</div>
                    </div>
                </div>

                <div class="two-col">

                    {{-- Grade distribution --}}
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <div class="card-title">Répartition des notes</div>
                                <div class="card-sub">Ce module</div>
                            </div>
                        </div>
                        <div class="card-body">
                            @php
                                $rep = $repartition ?? ['pass' => 0, 'warn' => 0, 'fail' => 0, 'total' => 0];
                                $tot = max($rep['total'], 1);
                                $pW  = round(($rep['pass'] / $tot) * 100);
                                $wW  = round(($rep['warn'] / $tot) * 100);
                                $fW  = max(0, 100 - $pW - $wW);
                            @endphp

                            {{-- Summary pills --}}
                            <div class="rep-pills">
                                <div class="rep-pill">
                                    <span class="rep-pill-value grade-pass">{{ $rep['pass'] }}</span>
                                    <span class="rep-pill-label">Admis</span>
                                </div>
                                <div class="rep-pill-divider"></div>
                                <div class="rep-pill">
                                    <span class="rep-pill-value grade-warn">{{ $rep['warn'] }}</span>
                                    <span class="rep-pill-label">Limite</span>
                                </div>
                                <div class="rep-pill-divider"></div>
                                <div class="rep-pill">
                                    <span class="rep-pill-value grade-fail">{{ $rep['fail'] }}</span>
                                    <span class="rep-pill-label">Échec</span>
                                </div>
                                <div class="rep-pill-divider"></div>
                                <div class="rep-pill">
                                    <span class="rep-pill-value" style="color:var(--text-1)">{{ $rep['total'] }}</span>
                                    <span class="rep-pill-label">Total</span>
                                </div>
                            </div>

                            {{-- Stacked progress bar --}}
                            <div class="rep-stack-wrap">
                                <div class="rep-stack">
                                    @if($pW > 0)<div class="rep-stack-seg rep-bar-pass" style="width:{{ $pW }}%"></div>@endif
                                    @if($wW > 0)<div class="rep-stack-seg rep-bar-warn" style="width:{{ $wW }}%"></div>@endif
                                    @if($fW > 0)<div class="rep-stack-seg rep-bar-fail"  style="width:{{ $fW }}%"></div>@endif
                                </div>
                                <div class="rep-stack-legend">
                                    <span class="rep-legend-dot rep-bar-pass"></span><span>Admis {{ $pW }}%</span>
                                    <span class="rep-legend-dot rep-bar-warn"></span><span>Limite {{ $wW }}%</span>
                                    <span class="rep-legend-dot rep-bar-fail"></span><span>Échec {{ $fW }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($module->filiere_description ?? null)
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <div class="card-title">Filière</div>
                                    <div class="card-sub">{{ $module->nom_filiere }}</div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="module-filiere-desc">{{ $module->filiere_description }}</p>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- Students table --}}
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Étudiants inscrits</div>
                            <div class="card-sub">Notes pour ce module</div>
                        </div>
                    </div>
                    <div class="table-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Étudiant</th>
                                    <th class="center">CNE</th>
                                    <th class="center">Note</th>
                                    <th class="center">Rattrapage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($etudiants as $etu)
                                    <tr>
                                        <td>
                                            <div class="etu-cell">
                                                <div class="user-avatar-small">
                                                    {{ strtoupper(substr($etu->prenom ?? 'E', 0, 1)) }}{{ strtoupper(substr($etu->nom ?? 'T', 0, 1)) }}
                                                </div>
                                                <div class="etu-name">{{ $etu->prenom ?? '—' }} {{ $etu->nom ?? '' }}</div>
                                            </div>
                                        </td>
                                        <td class="center"><span class="code-badge">{{ $etu->cne ?? '—' }}</span></td>
                                        <td class="center">
                                            @if(isset($etu->note))
                                                <span class="grade-value {{ $etu->note >= 12 ? 'grade-pass' : ($etu->note >= 10 ? 'grade-warn' : 'grade-fail') }}">
                                                    {{ number_format($etu->note, 2) }}
                                                </span>
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
                                    <tr>
                                        <td colspan="4">
                                            <div class="empty-state">Aucun étudiant inscrit pour ce module.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>
</html>