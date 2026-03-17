<!DOCTYPE html>
<html lang="fr">

<head>
    <script>if (localStorage.getItem('theme') === 'dark') { document.documentElement.classList.add('dark'); }</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Notes</title>
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
            overflow: hidden
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border)
        }

        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary)
        }

        .card-sub {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 2px
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        thead tr {
            background: var(--background)
        }

        th {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            padding: 9px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            white-space: nowrap
        }

        th.center,
        td.center {
            text-align: center
        }

        td {
            padding: 0 16px;
            height: 44px;
            font-size: 13px;
            color: var(--text-primary);
            border-top: 1px solid var(--border);
            vertical-align: middle
        }

        tbody tr:hover {
            background: var(--background)
        }

        .grade-value {
            font-family: 'SF Mono', 'Fira Code', monospace;
            font-weight: 600
        }

        .grade-pass {
            color: var(--success)
        }

        .grade-warn {
            color: var(--warning)
        }

        .grade-fail {
            color: var(--danger)
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
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

        .btn svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none
        }

        .search-bar {
            display: flex;
            gap: 10px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            flex-wrap: wrap
        }

        .search-input {
            flex: 1;
            min-width: 200px;
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            background: var(--background);
            color: var(--text-primary);
            outline: none
        }

        .search-input:focus {
            border-color: var(--primary)
        }

        select.search-input {
            min-width: 160px;
            flex: 0
        }

        .alert-success {
            background: #F0FBF4;
            border: 1px solid #BBF7D0;
            color: #1A7A34;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px
        }

        .empty-state {
            padding: 36px 20px;
            text-align: center;
            color: var(--text-secondary);
            font-size: 13px
        }
    </style>
</head>

<body>
    {{-- SIDEBAR --}}
    @include('layouts.sidebar-admin')
    <div class="main">
        <header class="topbar"><span class="topbar-title">Notes</span></header>
        <main class="content">
            @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>@endif
            <div class="page-header">
                <div>
                    <div class="page-title">Gestion des notes</div>
                    <div class="page-sub">{{ $notes->count() }} note(s) enregistrée(s)</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Toutes les notes</div>
                        <div class="card-sub">Filtrer par module ou étudiant</div>
                    </div>
                </div>
                <form method="GET" class="search-bar">
                    <input type="text" name="search" class="search-input" placeholder="Rechercher étudiant ou CNE..."
                        value="{{ request('search') }}">
                    <select name="module" class="search-input">
                        <option value="">Tous les modules</option>
                        @foreach($modules as $m)
                            <option value="{{ $m->id_module }}" {{ request('module') == $m->id_module ? 'selected' : '' }}>
                                {{ $m->nom_module }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-ghost">Filtrer</button>
                    @if(request('search') || request('module'))<a href="{{ route('admin.notes') }}"
                    class="btn btn-ghost">Réinitialiser</a>@endif
                </form>
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Étudiant</th>
                                <th>CNE</th>
                                <th>Module</th>
                                <th>Code</th>
                                <th class="center">Note</th>
                                <th class="center">Rattrapage</th>
                                <th class="center">Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notes as $n)
                                <tr>
                                    <td style="font-weight:500;">{{ $n->prenom }} {{ $n->nom }}</td>
                                    <td
                                        style="font-family:'SF Mono','Fira Code',monospace;font-size:12px;color:var(--text-secondary);">
                                        {{ $n->cne }}</td>
                                    <td style="font-size:13px;">{{ $n->nom_module }}</td>
                                    <td
                                        style="font-family:'SF Mono','Fira Code',monospace;font-size:12px;color:var(--text-secondary);">
                                        {{ $n->code_module }}</td>
                                    <td class="center">
                                        @if($n->note !== null)
                                            <span
                                                class="grade-value {{ $n->note >= 12 ? 'grade-pass' : ($n->note >= 10 ? 'grade-warn' : 'grade-fail') }}">{{ number_format($n->note, 2) }}</span>
                                        @else<span style="color:var(--text-secondary);">—</span>@endif
                                    </td>
                                    <td class="center">
                                        @if($n->rattrapage !== null)
                                            <span
                                                class="grade-value {{ $n->rattrapage >= 10 ? 'grade-pass' : 'grade-fail' }}">{{ number_format($n->rattrapage, 2) }}</span>
                                        @else<span style="color:var(--text-secondary);">—</span>@endif
                                    </td>
                                    <td class="center">
                                        @if($n->note === null)<span style="font-size:12px;color:var(--text-secondary);">En
                                            attente</span>
                                        @elseif($n->note >= 10 || ($n->rattrapage !== null && $n->rattrapage >= 10))<span
                                            style="font-size:12px;color:var(--success);font-weight:500;">✓ Validé</span>
                                        @else<span style="font-size:12px;color:var(--danger);font-weight:500;">✗
                                        Échoué</span>@endif
                                    </td>
                                    <td><a href="{{ route('admin.notes.edit', $n->id_note) }}" class="btn btn-ghost"><svg
                                                viewBox="0 0 24 24">
                                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>Modifier</a></td>
                                </tr>
                            @empty<tr>
                                    <td colspan="8">
                                        <div class="empty-state">Aucune note trouvée.</div>
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