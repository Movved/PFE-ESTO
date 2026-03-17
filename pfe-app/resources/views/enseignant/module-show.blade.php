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

    {{-- SIDEBAR --}}
    @include('layouts.sidebar-enseignant')

    <div class="main">
        <header class="topbar">
            <span class="topbar-title">{{ $module->nom_module }}</span>

            <button class="toggle-btn" id="theme-toggle" onclick="toggleTheme()" title="Thème sombre"><span
                    class="toggle-knob"></span></button>

        </header>

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('enseignant.modules') }}" class="module-detail-back">
                <svg viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
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
                    <div class="module-detail-info-value">
                        {{ $moyenne !== null ? number_format($moyenne, 2) . ' / 20' : '—' }}</div>
                </div>
                <div class="module-detail-info-item">
                    <div class="module-detail-info-label">Réclamations</div>
                    <div class="module-detail-info-value">{{ $reclamationsCount }}</div>
                </div>
            </div>

            <div class="section-grid">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-header-title">Répartition des notes</div>
                            <div class="card-header-sub">Ce module</div>
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $rep = $repartition ?? ['pass' => 0, 'warn' => 0, 'fail' => 0, 'total' => 0];
                            $tot = max($rep['total'], 1);
                            $pW = round(($rep['pass'] / $tot) * 100);
                            $wW = round(($rep['warn'] / $tot) * 100);
                            $fW = max(0, 100 - $pW - $wW);
                        @endphp
                        <div class="rep-list">
                            <div class="rep-row">
                                <div class="rep-label"><span>Admis</span><small>≥ 12</small></div>
                                <div class="rep-bar-wrap">
                                    <div class="rep-bar rep-bar-pass" style="width:{{ $pW }}%"></div>
                                </div>
                                <span class="grade-pass rep-count">{{ $rep['pass'] }}</span>
                            </div>
                            <div class="rep-row">
                                <div class="rep-label"><span>Limite</span><small>10 – 12</small></div>
                                <div class="rep-bar-wrap">
                                    <div class="rep-bar rep-bar-warn" style="width:{{ $wW }}%"></div>
                                </div>
                                <span class="grade-warn rep-count">{{ $rep['warn'] }}</span>
                            </div>
                            <div class="rep-row">
                                <div class="rep-label"><span>Échec</span><small>&lt; 10</small></div>
                                <div class="rep-bar-wrap">
                                    <div class="rep-bar rep-bar-fail" style="width:{{ $fW }}%"></div>
                                </div>
                                <span class="grade-fail rep-count">{{ $rep['fail'] }}</span>
                            </div>
                            <div class="rep-total"><span>Total notes</span><strong>{{ $rep['total'] }}</strong></div>
                        </div>
                    </div>
                </div>
                @if($module->filiere_description ?? null)
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-title">Filière</div>
                        </div>
                        <div class="card-body">
                            <p style="font-size:14px;color:var(--text-secondary);line-height:1.6;">
                                {{ $module->filiere_description }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-header-title">Étudiants inscrits</div>
                        <div class="card-header-sub">Notes pour ce module</div>
                    </div>
                </div>
                <div style="overflow-x:auto;">
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
                                            <div class="user-avatar-small" style="width:28px;height:28px;font-size:11px;">
                                                {{ strtoupper(substr($etu->prenom ?? 'E', 0, 1)) }}{{ strtoupper(substr($etu->nom ?? 'T', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-size:14px;font-weight:500;">{{ $etu->prenom ?? '—' }}
                                                    {{ $etu->nom ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="center"><span class="code-badge">{{ $etu->cne ?? '—' }}</span></td>
                                    <td class="center">
                                        @if(isset($etu->note))
                                            <span
                                                class="grade-value {{ $etu->note >= 12 ? 'grade-pass' : ($etu->note >= 10 ? 'grade-warn' : 'grade-fail') }}">{{ number_format($etu->note, 2) }}</span>
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

    <script>
        (function () { if (localStorage.getItem('theme') === 'dark') document.getElementById('theme-toggle').classList.add('on'); })();
        function toggleTheme() {
            var html = document.documentElement, btn = document.getElementById('theme-toggle');
            html.classList.toggle('dark'); btn.classList.toggle('on');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        }
    </script>
</body>

</html>