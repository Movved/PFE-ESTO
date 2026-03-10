<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PV — {{ $module->nom_module }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 24px; color: #1a1a1a; }
        h1 { font-size: 16px; margin-bottom: 4px; }
        .meta { color: #555; margin-bottom: 16px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #333; padding: 6px 10px; text-align: left; }
        th { background: #eee; font-weight: 600; }
        .num { width: 40px; text-align: center; }
        .note, .rattrapage { width: 80px; text-align: center; }
        .footer { margin-top: 24px; font-size: 11px; color: #666; }
        @media print { body { margin: 16px; } }
    </style>
</head>
<body>
    <h1>Procès-Verbal des notes</h1>
    <div class="meta">
        <strong>Filière:</strong> {{ $module->nom_filiere }} &nbsp;|&nbsp;
        <strong>Année:</strong> {{ $module->annee_libelle }} &nbsp;|&nbsp;
        <strong>Semestre:</strong> {{ $module->semestre_numero }} &nbsp;|&nbsp;
        <strong>Module:</strong> {{ $module->nom_module }} ({{ $module->code_module }}) &nbsp;|&nbsp;
        <strong>Date:</strong> {{ now()->format('d/m/Y') }}
    </div>
    <table>
        <thead>
            <tr>
                <th class="num">N°</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>CNE</th>
                <th class="note">Note /20</th>
                <th class="rattrapage">Rattrapage /20</th>
            </tr>
        </thead>
        <tbody>
            @foreach($etudiants as $i => $etu)
            <tr>
                <td class="num">{{ $i + 1 }}</td>
                <td>{{ $etu->nom }}</td>
                <td>{{ $etu->prenom }}</td>
                <td>{{ $etu->cne }}</td>
                <td class="note">{{ $etu->note !== null ? number_format($etu->note, 2) : '—' }}</td>
                <td class="rattrapage">{{ $etu->rattrapage !== null ? number_format($etu->rattrapage, 2) : '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">Document généré le {{ now()->format('d/m/Y à H:i') }} — Enregistrer en PDF : Ctrl+P (ou Cmd+P) → « Enregistrer en PDF ».</div>
</body>
</html>
