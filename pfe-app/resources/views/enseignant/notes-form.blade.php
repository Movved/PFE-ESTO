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
    <title>Saisie — {{ $module->nom_module }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/enseignant/enseignant.css', 'resources/js/enseignant/enseignant.js'])
</head>

<body>
    @include('layouts.sidebar-enseignant')

    <div class="layout">
        <div class="main" id="main-content">
            @include('layouts.topbar', ['title' => $module->nom_module])

            <main class="content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('enseignant.notes') }}" class="module-back">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                    Retour à la liste
                </a>

                <div class="card" style="margin-bottom:16px;">
                    <div class="card-header">
                        <div>
                            <div class="card-title">{{ $module->nom_module }}</div>
                            <div class="card-sub">{{ $module->code_module }} · {{ $module->nom_filiere }} ·
                                {{ $module->annee_libelle }} — Semestre {{ $module->semestre_numero }}</div>
                        </div>
                        <a href="{{ route('enseignant.notes.pv', $module->id_module) }}" target="_blank"
                            class="btn btn-primary">
                            Générer le PV (PDF)
                        </a>
                    </div>
                </div>

                <form method="POST" action="{{ route('enseignant.notes.store', $module->id_module) }}" class="card">
                    @csrf
                    <div class="card-header">
                        <div>
                            <div class="card-title">Notes des étudiants</div>
                            <div class="card-sub">Saisir note et rattrapage (sur 20), puis enregistrer.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Enregistrer les notes</button>
                    </div>

                    <div class="notes-search-wrap">
                        <div class="notes-search-inner">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                            <input type="text" id="student-search" placeholder="Rechercher par nom, prénom ou CNE…"
                                autocomplete="off" oninput="filterStudents(this.value)">
                            <button type="button" id="search-clear" class="notes-search-clear" onclick="clearSearch()">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </button>
                        </div>
                        <div id="search-count" class="notes-search-count"></div>
                    </div>

                    <div class="table-scroll">
                        <table id="students-table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>CNE</th>
                                    <th class="center">Note /20</th>
                                    <th class="center">Rattrapage /20</th>
                                </tr>
                            </thead>
                            <tbody id="students-tbody">
                                @foreach($etudiants as $i => $etu)
                                    <tr data-nom="{{ strtolower($etu->nom) }}" data-prenom="{{ strtolower($etu->prenom) }}"
                                        data-cne="{{ strtolower($etu->cne) }}">
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $etu->nom }}</td>
                                        <td>{{ $etu->prenom }}</td>
                                        <td><span class="code-badge">{{ $etu->cne }}</span></td>
                                        <td class="center">
                                            <input type="number" name="notes[{{ $etu->id_note }}][note]"
                                                value="{{ $etu->note !== null ? number_format($etu->note, 2, '.', '') : '' }}"
                                                min="0" max="20" step="0.01" class="note-input" placeholder="—">
                                        </td>
                                        <td class="center">
                                            <input type="number" name="notes[{{ $etu->id_note }}][rattrapage]"
                                                value="{{ $etu->rattrapage !== null ? number_format($etu->rattrapage, 2, '.', '') : '' }}"
                                                min="0" max="20" step="0.01" class="note-input" placeholder="—">
                                        </td>
                                    </tr>
                                @endforeach
                                <tr id="no-results-row" style="display:none;">
                                    <td colspan="6">
                                        <div class="empty-state">Aucun étudiant ne correspond à votre recherche.</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>

                @if($etudiants->isEmpty())
                    <div class="empty-state">Aucun étudiant inscrit pour ce module.</div>
                @endif
            </main>
        </div>
    </div>
</body>

</html>