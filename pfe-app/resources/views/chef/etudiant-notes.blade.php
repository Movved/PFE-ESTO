<!DOCTYPE html>
<html lang="fr">

<head>
    <script>if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes de l'étudiant</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
        }

        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .card-sub {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .student-banner {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .student-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .student-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 3px;
        }

        .student-meta {
            font-size: 13px;
            color: var(--text-secondary);
            display: flex;
            gap: 16px;
        }

        .student-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .student-meta svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            stroke-width: 1.5;
            fill: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: var(--background);
        }

        th {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            padding: 9px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 0 16px;
            height: 48px;
            font-size: 13px;
            color: var(--text-primary);
            border-top: 1px solid var(--border);
            vertical-align: middle;
        }

        td.center,
        th.center {
            text-align: center;
        }

        tbody tr:hover {
            background: var(--background);
        }

        .code-badge {
            font-size: 11px;
            font-weight: 600;
            font-family: "SF Mono", "Fira Code", monospace;
            color: var(--primary);
            background: #EBF3FD;
            padding: 2px 7px;
            border-radius: 4px;
        }

        html.dark .code-badge {
            background: #0a2e54;
        }

        .note-value {
            font-size: 15px;
            font-weight: 600;
        }

        .note-good {
            color: var(--success);
        }

        .note-mid {
            color: #F59E0B;
        }

        .note-bad {
            color: var(--danger);
        }

        .rattrapage-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 500;
            background: #FFF7ED;
            color: #C2410C;
            border: 1px solid #FED7AA;
            padding: 2px 8px;
            border-radius: 20px;
        }

        html.dark .rattrapage-badge {
            background: #2D1A0A;
            border-color: #7C3815;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat-mini {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 14px 16px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .stat-mini-label {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .stat-mini-value {
            font-size: 22px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            font-family: inherit;
            text-decoration: none;
            transition: background 0.15s;
        }

        .btn-secondary {
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-primary);
        }

        .btn-secondary:hover {
            background: var(--background);
        }

        .empty-state {
            padding: 40px;
            text-align: center;
            color: var(--text-secondary);
            font-size: 13px;
        }

        .empty-state svg {
            width: 28px;
            height: 28px;
            stroke: var(--border);
            stroke-width: 1.5;
            fill: none;
            margin: 0 auto 8px;
            display: block;
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    @include('layouts.sidebar-chef')
    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Notes de l'étudiant</span>
            <div style="display:flex;flex-direction:column;align-items:center;gap:2px;">
                <span id="topbar-time"
                    style="font-size:14px;font-weight:600;color:var(--text-primary);font-family:'SF Mono','Fira Code',monospace;"></span>
                <span id="topbar-date" style="font-size:11px;color:var(--text-secondary);"></span>
            </div>
        </header>

        <main class="content">

            {{-- BACK BUTTON --}}
            <div style="margin-bottom:16px;">
                <a href="{{ route('chef.etudiants') }}" class="btn btn-secondary">
                    <svg viewBox="0 0 24 24"
                        style="width:14px;height:14px;stroke:currentColor;stroke-width:2;fill:none;stroke-linecap:round;stroke-linejoin:round;">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                    Retour aux étudiants
                </a>
            </div>

            {{-- STUDENT BANNER --}}
            <div class="student-banner">
                <div class="student-avatar">
                    {{ strtoupper(substr($etudiant->prenom, 0, 1)) }}{{ strtoupper(substr($etudiant->nom, 0, 1)) }}
                </div>
                <div>
                    <div class="student-name">{{ $etudiant->prenom }} {{ $etudiant->nom }}</div>
                    <div class="student-meta">
                        <span>
                            <svg viewBox="0 0 24 24">
                                <rect x="2" y="5" width="20" height="14" rx="2" />
                                <path d="M16 10h.01M12 10h.01M8 10h.01" />
                            </svg>
                            CNE : {{ $etudiant->cne }}
                        </span>
                        <span>
                            <svg viewBox="0 0 24 24">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                            {{ $etudiant->email }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- MINI STATS --}}
            @php
                $noteFinales = $notes->map(fn($n) => $n->rattrapage ?? $n->note);
                $moyenne = $noteFinales->count() ? round($noteFinales->avg(), 2) : null;
                $rattrapages = $notes->filter(fn($n) => $n->rattrapage !== null)->count();
            @endphp
            <div class="stats-row">
                <div class="stat-mini">
                    <div class="stat-mini-label">Modules évalués</div>
                    <div class="stat-mini-value">{{ $notes->count() }}</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-label">Moyenne générale</div>
                    <div class="stat-mini-value {{ $moyenne >= 10 ? 'note-good' : 'note-bad' }}">
                        {{ $moyenne ?? '—' }}
                    </div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-label">Rattrapages passés</div>
                    <div class="stat-mini-value {{ $rattrapages > 0 ? 'note-mid' : '' }}">{{ $rattrapages }}</div>
                </div>
            </div>

            {{-- NOTES TABLE --}}
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Relevé de notes</div>
                        <div class="card-sub">Tous les modules du département</div>
                    </div>
                </div>
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th>Filière</th>
                                <th>Semestre</th>
                                <th class="center">Note</th>
                                <th class="center">Rattrapage</th>
                                <th class="center">Note finale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notes as $n)
                                @php
                                    $finale = $n->rattrapage ?? $n->note;
                                    $class = $finale >= 14 ? 'note-good' : ($finale >= 10 ? '' : 'note-bad');
                                @endphp
                                <tr>
                                    <td>
                                        <div style="font-weight:500;">{{ $n->nom_module }}</div>
                                        <div><span class="code-badge">{{ $n->code_module }}</span></div>
                                    </td>
                                    <td style="font-size:12px;color:var(--text-secondary);">{{ $n->nom_filiere }}</td>
                                    <td style="font-size:12px;color:var(--text-secondary);">S{{ $n->semestre_numero }}</td>
                                    <td class="center">
                                        <span class="note-value {{ $n->note >= 10 ? 'note-good' : 'note-bad' }}">
                                            {{ number_format($n->note, 2) }}
                                        </span>
                                    </td>
                                    <td class="center">
                                        @if($n->rattrapage !== null)
                                            <span class="rattrapage-badge">{{ number_format($n->rattrapage, 2) }}</span>
                                        @else
                                            <span style="color:var(--text-secondary);font-size:12px;">—</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        <span class="note-value {{ $class }}">{{ number_format($finale, 2) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                                            </svg>
                                            Aucune note enregistrée pour cet étudiant.
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