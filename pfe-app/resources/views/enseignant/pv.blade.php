<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PV — {{ $module->nom_module }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            color: #000;
            background: #fff;
            padding: 0;
        }

        .page-shell {
            max-width: 210mm;
            margin: 20px auto;
            padding: 20mm 18mm;
            background: #fff;
            box-shadow: 0 0 12px rgba(0,0,0,.12);
        }

        .no-print {
            max-width: 210mm;
            margin: 0 auto 24px;
            text-align: center;
        }
        .no-print button {
            padding: 8px 22px;
            font-size: 11pt;
            font-family: Arial, sans-serif;
            background: #1a3a6e;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 6px;
        }
        .no-print button:hover { background: #122d57; }
        .no-print button.outline {
            background: #fff;
            color: #1a3a6e;
            border: 1px solid #1a3a6e;
        }
        .no-print button.outline:hover { background: #f0f4fb; }

        .inst-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 6px;
        }
        .inst-left, .inst-right {
            font-size: 10pt;
            line-height: 1.6;
        }
        .inst-right { text-align: right; }

        .center-title {
            text-align: center;
            margin: 14px 0 4px;
        }
        .center-title h1 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .center-title .underline-rule {
            width: 60%;
            margin: 6px auto 0;
            border: none;
            border-top: 2px solid #000;
        }

        .info-block {
            margin: 16px 0 12px;
            font-size: 11pt;
            line-height: 2;
            border: 1px solid #000;
            padding: 8px 14px;
        }
        .info-block .row { display: flex; }
        .info-block .col { flex: 1; }
        .info-label { font-weight: bold; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            font-size: 11pt;
        }
        thead tr { background: #e8e8e8; }
        th {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: center;
            font-weight: bold;
            font-size: 10.5pt;
        }
        td {
            border: 1px solid #000;
            padding: 5px 8px;
            text-align: center;
        }
        td.left { text-align: left; }
        tbody tr:nth-child(even) { background: #f5f5f5; }

        .table-summary {
            margin-top: 8px;
            font-size: 10pt;
            display: flex;
            gap: 24px;
        }
        .table-summary span { border-left: 3px solid #000; padding-left: 6px; }

        .sig-block {
            margin-top: 32px;
            display: flex;
            justify-content: flex-end;
        }
        .sig-box { width: 200px; text-align: center; font-size: 10.5pt; }
        .sig-box .sig-title { font-weight: bold; margin-bottom: 4px; }
        .sig-box .sig-name  { margin-bottom: 40px; }
        .sig-box .sig-line  { border-top: 1px solid #000; }
        .sig-box .sig-hint  { font-size: 9pt; color: #555; margin-top: 3px; }

        @media print {
            body { background: #fff; }
            .no-print { display: none !important; }
            .page-shell { box-shadow: none; margin: 0; padding: 15mm 15mm; }
        }
    </style>
</head>
<body>

<div class="page-shell">
<div id="pv-document">

    <div class="inst-header">
        <div class="inst-left">
            Université Mohammed Premier<br>
            École Supérieure de Technologie — Oujda
        </div>
        <div class="inst-right">
            Année universitaire : {{ $module->annee_libelle }}<br>
            Filière : {{ $module->nom_filiere }}<br>
            Semestre : S{{ $module->semestre_numero }}
        </div>
    </div>

    <div class="center-title">
        <h1>Procès-Verbal des Examens</h1>
        <hr class="underline-rule">
    </div>

    <div class="info-block">
        <div class="row">
            <div class="col"><span class="info-label">Module :</span> {{ $module->nom_module }}</div>
            <div class="col"><span class="info-label">Code :</span> {{ $module->code_module }}</div>
        </div>
        <div class="row">
            <div class="col"><span class="info-label">Filière :</span> {{ $module->nom_filiere }}</div>
            <div class="col"><span class="info-label">Date d'édition :</span> {{ now()->format('d/m/Y') }}</div>
        </div>
    </div>

    @php
        $notes      = collect($etudiants)->pluck('note')->filter(fn($n) => $n !== null);
        $countTotal = $notes->count();
        $countPass  = $notes->filter(fn($n) => $n >= 10)->count();
        $countFail  = $notes->filter(fn($n) => $n < 10)->count();
        $moyenne    = $countTotal ? round($notes->avg(), 2) : '—';
    @endphp

    <table>
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
                if ($best === null)  { $res = '—'; }
                elseif ($best >= 10) { $res = 'Admis'; }
                else                 { $res = 'Ajourné'; }
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td class="left">{{ strtoupper($etu->nom) }}</td>
                <td class="left">{{ $etu->prenom }}</td>
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

    <div class="table-summary">
        <span>Total inscrits : <strong>{{ count($etudiants) }}</strong></span>
        <span>Notes saisies : <strong>{{ $countTotal }}</strong></span>
        <span>Admis : <strong>{{ $countPass }}</strong></span>
        <span>Ajournés : <strong>{{ $countFail }}</strong></span>
        <span>Moyenne : <strong>{{ $moyenne }}/20</strong></span>
    </div>

    <div class="sig-block">
        <div class="sig-box">
            <div class="sig-title">L'enseignant responsable</div>
            <div class="sig-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
            <div class="sig-line"></div>
            <div class="sig-hint">Signature &amp; cachet</div>
        </div>
    </div>

</div>
</div>

<div class="no-print">
    <button class="outline" onclick="window.print()">Imprimer</button>
    <button onclick="downloadPDF()">Télécharger PDF</button>
</div>

<script>
function downloadPDF() {
    const btns = document.querySelectorAll('.no-print button');
    btns.forEach(b => b.disabled = true);
    btns[1].textContent = 'Génération…';

    html2pdf()
        .set({
            margin:      [12, 12, 12, 12],
            filename:    'PV_{{ Str::slug($module->nom_module) }}_{{ now()->format("Y-m-d") }}.pdf',
            image:       { type: 'jpeg', quality: 0.97 },
            html2canvas: { scale: 2, useCORS: true },
            jsPDF:       { unit: 'mm', format: 'a4', orientation: 'portrait' }
        })
        .from(document.getElementById('pv-document'))
        .save()
        .finally(() => {
            btns.forEach(b => b.disabled = false);
            btns[1].textContent = 'Télécharger PDF';
        });
}
</script>
</body>
</html>