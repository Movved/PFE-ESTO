<!DOCTYPE html>
<html lang="fr">

<head>
    <script>if (localStorage.getItem('theme') === 'dark') { document.documentElement.classList.add('dark'); }</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Logs</title>
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

        .user-avatar-sm {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            font-size: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0
        }

        .empty-state {
            padding: 36px 20px;
            text-align: center;
            color: var(--text-secondary);
            font-size: 13px
        }

        .pagination-wrap {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
        }
    </style>
</head>

<body>
    {{-- SIDEBAR --}}
    @include('layouts.sidebar-admin')
    <div class="main">
        <header class="topbar"><span class="topbar-title">Journal d'activité</span></header>
        <main class="content">
            <div class="page-header">
                <div>
                    <div class="page-title">Logs système</div>
                    <div class="page-sub">Toutes les actions effectuées sur la plateforme</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Journal d'activité</div>
                        <div class="card-sub">25 entrées par page</div>
                    </div>
                </div>
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Table</th>
                                <th>Enregistrement</th>
                                <th>Effectuée par</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td>
                                        @php $color = match (strtoupper($log->action)) { 'CREATE' => 'var(--success)', 'UPDATE' => 'var(--warning)', 'DELETE' => 'var(--danger)', default => 'var(--text-secondary)'}; @endphp
                                        <span
                                            style="font-size:11px;font-weight:700;color:{{ $color }};font-family:'SF Mono','Fira Code',monospace;text-transform:uppercase;letter-spacing:0.05em;">{{ $log->action }}</span>
                                    </td>
                                    <td
                                        style="font-family:'SF Mono','Fira Code',monospace;font-size:12px;color:var(--text-secondary);">
                                        {{ $log->table_concernee }}</td>
                                    <td style="font-size:12px;color:var(--text-secondary);">#{{ $log->id_enregistrement }}
                                    </td>
                                    <td>
                                        @if($log->nom)
                                            <div style="display:flex;align-items:center;gap:8px;">
                                                <div class="user-avatar-sm">
                                                    {{ strtoupper(substr($log->prenom, 0, 1)) }}{{ strtoupper(substr($log->nom, 0, 1)) }}
                                                </div>
                                                <span>{{ $log->prenom }} {{ $log->nom }}</span>
                                            </div>
                                        @else<span style="color:var(--text-secondary);font-size:12px;">Système</span>@endif
                                    </td>
                                    <td style="font-size:12px;color:var(--text-secondary);white-space:nowrap;">
                                        {{ \Carbon\Carbon::parse($log->date_action)->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty<tr>
                                    <td colspan="5">
                                        <div class="empty-state">Aucun log disponible.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pagination-wrap">{{ $logs->links() }}</div>
            </div>
        </main>
    </div>
</body>

</html>