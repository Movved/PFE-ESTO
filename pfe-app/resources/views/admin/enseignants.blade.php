<!DOCTYPE html>
<html lang="fr">

<head>
    <script>if (localStorage.getItem('theme') === 'dark') { document.documentElement.classList.add('dark'); }</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Enseignants</title>
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

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500
        }

        .badge-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%
        }

        .badge-chef {
            background: #EEF2FF;
            color: #3730A3
        }

        .badge-chef .badge-dot {
            background: #6366F1
        }

        .badge-active {
            background: #F0FBF4;
            color: #1A7A34
        }

        .badge-active .badge-dot {
            background: var(--success)
        }

        .badge-inactive {
            background: var(--background);
            color: var(--text-secondary)
        }

        .badge-inactive .badge-dot {
            background: var(--border)
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

        .btn-primary {
            background: var(--primary);
            color: white
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

        .btn svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none
        }

        .user-avatar-sm {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #6366F1;
            color: white;
            font-size: 11px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0
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
        <header class="topbar"><span class="topbar-title">Enseignants</span></header>
        <main class="content">
            @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>@endif
            <div class="page-header">
                <div>
                    <div class="page-title">Enseignants</div>
                    <div class="page-sub">{{ $enseignants->count() }} enseignant(s) enregistré(s)</div>
                </div>
                <a href="{{ route('admin.enseignants.create') }}" class="btn btn-primary"><svg viewBox="0 0 24 24">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>Ajouter un enseignant</a>
            </div>
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Liste des enseignants</div>
                        <div class="card-sub">Tous les comptes enseignants</div>
                    </div>
                </div>
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Enseignant</th>
                                <th>Spécialité</th>
                                <th>Département</th>
                                <th>Rôle</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enseignants as $e)
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:10px;">
                                            <div class="user-avatar-sm">
                                                {{ strtoupper(substr($e->prenom, 0, 1)) }}{{ strtoupper(substr($e->nom, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight:500;">{{ $e->prenom }} {{ $e->nom }}</div>
                                                <div style="font-size:11px;color:var(--text-secondary);">{{ $e->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="font-size:12px;">{{ $e->specialite }}</td>
                                    <td style="font-size:12px;color:var(--text-secondary);">{{ $e->nom_departement }}</td>
                                    <td>@if($e->is_chef)<span class="badge badge-chef"><span
                                    class="badge-dot"></span>Chef</span>@else<span
                                                style="font-size:12px;color:var(--text-secondary);">Enseignant</span>@endif</td>
                                    <td>@if($e->actif)<span class="badge badge-active"><span
                                    class="badge-dot"></span>Actif</span>@else<span
                                                class="badge badge-inactive"><span class="badge-dot"></span>Inactif</span>@endif
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:6px;">
                                            <a href="{{ route('admin.enseignants.edit', $e->id_enseignant) }}"
                                                class="btn btn-ghost"><svg viewBox="0 0 24 24">
                                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>Modifier</a>
                                            <form method="POST"
                                                action="{{ route('admin.enseignants.destroy', $e->id_enseignant) }}"
                                                onsubmit="return confirm('Supprimer cet enseignant ?')">@csrf
                                                @method('DELETE')<button type="submit" class="btn btn-danger"><svg
                                                        viewBox="0 0 24 24">
                                                        <polyline points="3 6 5 6 21 6" />
                                                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                                                    </svg>Supprimer</button></form>
                                        </div>
                                    </td>
                                </tr>
                            @empty<tr>
                                    <td colspan="6">
                                        <div class="empty-state">Aucun enseignant trouvé.</div>
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