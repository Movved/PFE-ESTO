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
    <title>Admin — Enseignants</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css', 'resources/js/admin/admin.js'])
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="main" id="main-content">
        @include('layouts.topbar', [
            'title'             => 'Enseignants',
            'search'            => true,
            'searchPlaceholder' => 'Rechercher un enseignant...',
        ])

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Enseignants</div>
                        <div class="card-sub">{{ $enseignants->count() }} enseignant(s) enregistré(s)</div>
                    </div>
                    <a href="{{ route('admin.enseignants.create') }}" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Ajouter un enseignant
                    </a>
                </div>
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Enseignant</th>
                                <th>Spécialité</th>
                                <th>Département</th>
                                <th>Rôle</th>
                                <th>Statut</th>
                                <th class="center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enseignants as $e)
                                <tr>
                                    <td>
                                        <div class="etu-cell">
                                            <div class="user-avatar-small">
                                                {{ strtoupper(substr($e->prenom, 0, 1)) }}{{ strtoupper(substr($e->nom, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="etu-name">{{ $e->prenom }} {{ $e->nom }}</div>
                                                <div class="cell-secondary">{{ $e->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cell-secondary">{{ $e->specialite }}</td>
                                    <td class="cell-secondary">{{ $e->nom_departement }}</td>
                                    <td>
                                        @if($e->is_chef)
                                            <span class="badge badge-pending"><span class="badge-dot"></span>Chef</span>
                                        @else
                                            <span class="cell-secondary">Enseignant</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($e->actif)
                                            <span class="badge badge-open"><span class="badge-dot"></span>Actif</span>
                                        @else
                                            <span class="badge badge-closed"><span class="badge-dot"></span>Inactif</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        <div class="action-group action-group--center">
                                            <a href="{{ route('admin.enseignants.edit', $e->id_enseignant) }}" class="btn btn-secondary btn-sm">Modifier</a>
                                            <form method="POST" action="{{ route('admin.enseignants.destroy', $e->id_enseignant) }}" onsubmit="return confirm('Supprimer cet enseignant ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
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