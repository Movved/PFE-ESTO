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
    <title>PV — {{ $module->nom_module }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body class="pv-body">

    <div class="pv-actions no-print">
        <button class="btn btn-secondary" onclick="window.print()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 6 2 18 2 18 9"/>
                <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>
            Imprimer
        </button>
        <button class="btn btn-primary" id="pdf-btn" onclick="downloadPDF()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Télécharger PDF
        </button>
    </div>

    <div class="pv-shell">
        <div id="pv-document">

            <div class="pv-inst-header">
                <div class="pv-inst-left">
                    Université Mohammed Premier<br>
                    École Supérieure de Technologie — Oujda
                </div>
                <div class="pv-inst-right">
                    Année universitaire : {{ $module->annee_libelle }}<br>
                    Filière : {{ $module->nom_filiere }}<br>
                    Semestre : S{{ $module->semestre_numero }}
                </div>
            </div>

            <div class="pv-center-title">
                <h1>Procès-Verbal des Examens</h1>
                <hr class="pv-rule">
            </div>

            <div class="pv-info-block">
                <div class="pv-info-row">
                    <div class="pv-info-col"><span class="pv-info-label">Module :</span> {{ $module->nom_module }}</div>
                    <div class="pv-info-col"><span class="pv-info-label">Code :</span> {{ $module->code_module }}</div>
                </div>
                <div class="pv-info-row">
                    <div class="pv-info-col"><span class="pv-info-label">Filière :</span> {{ $module->nom_filiere }}</div>
                    <div class="pv-info-col"><span class="pv-info-label">Date d'édition :</span> {{ now()->format('d/m/Y') }}</div>
                </div>
            </div>

            @php
                $notes      = collect($etudiants)->pluck('note')->filter(fn($n) => $n !== null);
                $countTotal = $notes->count();
                $countPass  = $notes->filter(fn($n) => $n >= 10)->count();
                $countFail  = $notes->filter(fn($n) => $n < 10)->count();
                $moyenne    = $countTotal ? round($notes->avg(), 2) : '—';
            @endphp

            <table class="pv-table">
                <thead>
                    <tr>
                        <th style="width:36px">N°</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>CNE / Apogée</th>
                        <th style="width:80px">Note /20</th>
                        <th style="width:100px">Rattrapage /20</th>
                        <th style="width:80px">Résultat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($etudiants as $i => $etu)
                        @php
                            $n    = $etu->note;
                            $r    = $etu->rattrapage;
                            $best = ($n !== null && $r !== null) ? max($n, $r) : ($n ?? $r);
                            if ($best === null)       { $res = '—'; }
                            elseif ($best >= 10)      { $res = 'Admis'; }
                            else                      { $res = 'Ajourné'; }
                        @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="pv-left">{{ strtoupper($etu->nom) }}</td>
                            <td class="pv-left">{{ $etu->prenom }}</td>
                            <td>{{ $etu->cne }}</td>
                            <td>{{ $n !== null ? number_format($n, 2) : '—' }}</td>
                            <td>{{ $r !== null ? number_format($r, 2) : '—' }}</td>
                            <td>{{ $res }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:20px;font-style:italic;">
                                Aucun étudiant inscrit.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pv-summary">
                <span>Total inscrits : <strong>{{ count($etudiants) }}</strong></span>
                <span>Notes saisies : <strong>{{ $countTotal }}</strong></span>
                <span>Admis : <strong>{{ $countPass }}</strong></span>
                <span>Ajournés : <strong>{{ $countFail }}</strong></span>
                <span>Moyenne : <strong>{{ $moyenne }}/20</strong></span>
            </div>

            <div class="pv-sig-block">
                <div class="pv-sig-box">
                    <div class="pv-sig-title">L'enseignant responsable</div>
                    <div class="pv-sig-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                    <div class="pv-sig-line"></div>
                    <div class="pv-sig-hint">Signature &amp; cachet</div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>