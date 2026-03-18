<!DOCTYPE html>
<html lang="fr">

<head>
    @include('partials.theme-init')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Étudiants</title>
    @vite(['resources/css/app.css', 'resources/js/app.js','resources/css/sidebar.css', 'resources/js/sidebar.js'])
</head>

<body>

    {{-- SIDEBAR --}}
    @include('layouts.sidebar-chef')

    <div class="main">
        @include('layouts.topbar', [
            'title' => 'Étudiants',
            'search' => true,
            'searchPlaceholder' => 'Rechercher un étudiant...'
        ])

        <main class="content">
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Étudiants du département</div>
                        <div class="card-sub">{{ $etudiants->count() }} étudiant(s) inscrits</div>
                    </div>
                </div>
                <div style="overflow-x:auto;">
                    <table id="notes-table">
                        <thead>
                            <tr>
                                <th>Étudiant</th>
                                <th>CNE</th>
                                <th>Email</th>
                                <th>Filière</th>
                                <th>Année</th>
                                <th class="center">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($etudiants as $e)
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:10px;">
                                            <div class="avatar">
                                                {{ strtoupper(substr($e->prenom, 0, 1)) }}{{ strtoupper(substr($e->nom, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight:500;">{{ $e->prenom }} {{ $e->nom }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="cne-badge">{{ $e->cne }}</span></td>
                                    <td style="font-size:12px;color:var(--text-secondary);">{{ $e->email }}</td>
                                    <td style="font-size:12px;color:var(--text-secondary);">{{ $e->nom_filiere }}</td>
                                    <td style="font-size:12px;color:var(--text-secondary);">{{ $e->annee }}</td>
                                    <td class="center">
                                        <a href="{{ route('chef.etudiant.notes', $e->id_etudiant) }}"
                                            class="btn btn-primary btn-sm">
                                            Voir notes
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                                <circle cx="9" cy="7" r="4" />
                                            </svg>
                                            Aucun étudiant trouvé.
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