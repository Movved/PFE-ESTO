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
        <title>Admin — Étudiants</title>
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css', 'resources/js/admin/admin.js'])
    </head>
    <body>
        @include('layouts.sidebar-admin')

        <div class="main" id="main-content">
            @include('layouts.topbar', [
                'title'             => 'Étudiants',
                'search'            => true,
                'searchPlaceholder' => 'Rechercher par nom, prénom ou CNE...',
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
                            <div class="card-title">Étudiants</div>
                            <div class="card-sub">{{ $etudiants->count() }} étudiant(s) enregistré(s)</div>
                        </div>
                        <a href="{{ route('admin.etudiants.create') }}" class="btn btn-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            Ajouter un étudiant
                        </a>
                    </div>

                    <div class="table-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Étudiant</th>
                                    <th>CNE</th>
                                    <th>Email</th>
                                    <th>Statut</th>
                                    <th>Créé le</th>
                                    <th class="center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($etudiants as $e)
                                    <tr>
                                        <td>
                                            <div class="etu-cell">
                                                <div class="user-avatar-small">
                                                    {{ strtoupper(substr($e->prenom, 0, 1)) }}{{ strtoupper(substr($e->nom, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="etu-name">{{ $e->prenom }} {{ $e->nom }}</div>
                                                    <div class="cell-secondary">#{{ $e->id_etudiant }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="code-badge">{{ $e->cne }}</span></td>
                                        <td class="cell-secondary">{{ $e->email }}</td>
                                        <td>
                                            @if($e->actif)
                                                <span class="badge badge-open"><span class="badge-dot"></span>Actif</span>
                                            @else
                                                <span class="badge badge-closed"><span class="badge-dot"></span>Inactif</span>
                                            @endif
                                        </td>
                                        <td class="cell-secondary">
                                            {{ \Carbon\Carbon::parse($e->date_creation)->format('d/m/Y') }}
                                        </td>
                                        <td class="center">
                                            <div class="filiere-actions">
                                            <a href="{{ route('admin.etudiants.edit', $e->id_etudiant) }}" class="filiere-btn filiere-btn-edit">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                </svg>
                                                Modifier
                                            </a>
                                            <form method="POST" action="{{ route('admin.etudiants.destroy', $e->id_etudiant) }}" onsubmit="return confirm('Supprimer cet étudiant ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="filiere-btn filiere-btn-delete">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="3 6 5 6 21 6"/>
                                                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                                        <path d="M10 11v6M14 11v6"/>
                                                        <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                                                    </svg>
                                                    Supprimer
                                                </button>
                                            </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">Aucun étudiant trouvé.</div>
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