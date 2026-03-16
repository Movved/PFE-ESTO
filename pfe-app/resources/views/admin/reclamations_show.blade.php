<!DOCTYPE html>
<html lang="fr">

<head>
    <script>if (localStorage.getItem('theme') === 'dark') { document.documentElement.classList.add('dark'); }</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Détail Réclamation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px
        }

        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-primary)
        }

        .page-sub {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            max-width: 640px;
            margin-bottom: 16px
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border)
        }

        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary)
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 20px;
            border-bottom: 1px solid var(--border);
            font-size: 13px
        }

        .info-row:last-child {
            border-bottom: none
        }

        .info-label {
            color: var(--text-secondary);
            font-size: 12px
        }

        .info-value {
            font-weight: 500;
            color: var(--text-primary)
        }

        .message-box {
            padding: 16px 20px;
            font-size: 13px;
            color: var(--text-primary);
            line-height: 1.7;
            background: var(--background);
            border-top: 1px solid var(--border)
        }

        .grade-value {
            font-family: 'SF Mono', 'Fira Code', monospace;
            font-weight: 600;
            font-size: 16px
        }

        .grade-pass {
            color: var(--success)
        }

        .grade-fail {
            color: var(--danger)
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: opacity 0.15s
        }

        .btn:hover {
            opacity: 0.85
        }

        .btn-ghost {
            background: var(--background);
            color: var(--text-primary);
            border: 1px solid var(--border)
        }

        .btn-danger {
            background: #FFF2F1;
            color: #C0392B;
            border: 1px solid #FECACA
        }

        .actions-row {
            display: flex;
            gap: 10px;
            margin-top: 8px
        }
    </style>
</head>

<body>
    {{-- SIDEBAR --}}
    @include('layouts.sidebar-admin')
    <div class="main">
        <header class="topbar"><span class="topbar-title">Détail réclamation</span></header>
        <main class="content">
            <div class="page-header">
                <div>
                    <div class="page-title">Réclamation #{{ $reclamation->id_reclamation }}</div>
                    <div class="page-sub">{{ $reclamation->prenom }} {{ $reclamation->nom }} —
                        {{ $reclamation->nom_module }}</div>
                </div>
                <a href="{{ route('admin.reclamations') }}" class="btn btn-ghost">← Retour</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Étudiant</div>
                </div>
                <div class="info-row"><span class="info-label">Nom complet</span><span
                        class="info-value">{{ $reclamation->prenom }} {{ $reclamation->nom }}</span></div>
                <div class="info-row"><span class="info-label">CNE</span><span class="info-value"
                        style="font-family:'SF Mono','Fira Code',monospace;">{{ $reclamation->cne }}</span></div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Note concernée</div>
                </div>
                <div class="info-row"><span class="info-label">Module</span><span
                        class="info-value">{{ $reclamation->nom_module }} ({{ $reclamation->code_module }})</span></div>
                <div class="info-row">
                    <span class="info-label">Note</span>
                    <span
                        class="grade-value {{ $reclamation->note >= 10 ? 'grade-pass' : 'grade-fail' }}">{{ $reclamation->note !== null ? number_format($reclamation->note, 2) . '/20' : '—' }}</span>
                </div>
                @if($reclamation->rattrapage !== null)
                    <div class="info-row">
                        <span class="info-label">Rattrapage</span>
                        <span
                            class="grade-value {{ $reclamation->rattrapage >= 10 ? 'grade-pass' : 'grade-fail' }}">{{ number_format($reclamation->rattrapage, 2) }}/20</span>
                    </div>
                @endif
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Message de la réclamation</div>
                </div>
                @if($reclamation->date_reclamation)
                    <div class="info-row"><span class="info-label">Soumise le</span><span
                            class="info-value">{{ \Carbon\Carbon::parse($reclamation->date_reclamation)->format('d/m/Y à H:i') }}</span>
                    </div>
                @endif
                <div class="message-box">{{ $reclamation->message }}</div>
            </div>

            <div class="actions-row">
                <a href="{{ route('admin.notes.edit', $reclamation->id_note) }}" class="btn btn-ghost">
                    <svg viewBox="0 0 24 24"
                        style="width:14px;height:14px;stroke:currentColor;stroke-width:2;fill:none">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Modifier la note
                </a>
                <form method="POST" action="{{ route('admin.reclamations.destroy', $reclamation->id_reclamation) }}"
                    onsubmit="return confirm('Supprimer cette réclamation ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <svg viewBox="0 0 24 24"
                            style="width:14px;height:14px;stroke:currentColor;stroke-width:2;fill:none">
                            <polyline points="3 6 5 6 21 6" />
                            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                        </svg>
                        Supprimer la réclamation
                    </button>
                </form>
            </div>
        </main>
    </div>
</body>

</html>