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
    <title>Admin — Logs</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css', 'resources/js/admin/admin.js'])
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="main" id="main-content">
        @include('layouts.topbar', ['title' => 'Journal d\'activité'])

        <main class="content">

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Logs système</div>
                        <div class="card-sub">Toutes les actions effectuées sur la plateforme</div>
                    </div>
                </div>
                <div class="table-scroll">
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
                                        @php
                                            $cls = match(strtoupper($log->action)) {
                                                'CREATE' => 'grade-pass',
                                                'UPDATE' => 'grade-warn',
                                                'DELETE' => 'grade-fail',
                                                default  => 'grade-empty',
                                            };
                                        @endphp
                                        <span class="code-badge {{ $cls }}" style="border:none;background:transparent;font-weight:700;letter-spacing:0.05em;">
                                            {{ strtoupper($log->action) }}
                                        </span>
                                    </td>
                                    <td><span class="code-badge">{{ $log->table_concernee }}</span></td>
                                    <td class="cell-secondary">#{{ $log->id_enregistrement }}</td>
                                    <td>
                                        @if($log->nom)
                                            <div class="etu-cell">
                                                <div class="user-avatar-small" style="width:26px;height:26px;font-size:10px;">
                                                    {{ strtoupper(substr($log->prenom, 0, 1)) }}{{ strtoupper(substr($log->nom, 0, 1)) }}
                                                </div>
                                                <span class="etu-name">{{ $log->prenom }} {{ $log->nom }}</span>
                                            </div>
                                        @else
                                            <span class="cell-secondary">Système</span>
                                        @endif
                                    </td>
                                    <td class="cell-secondary" style="white-space:nowrap;">
                                        {{ \Carbon\Carbon::parse($log->date_action)->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">Aucun log disponible.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div style="padding:14px 20px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;">
                    {{ $logs->links() }}
                </div>
            </div>

        </main>
    </div>
</body>
</html>