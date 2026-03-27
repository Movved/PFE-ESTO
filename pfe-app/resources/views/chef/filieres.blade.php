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
    <title>Filières</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/chef/chef.css', 'resources/js/chef/chef.js'])
</head>

<body>
    @include('layouts.sidebar-chef')

    <div class="main" id="main-content">
        @include('layouts.topbar', ['title' => 'Filières : ' . $departement->nom_departement])

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

            @if(session('error'))
                <div class="alert alert-error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="15" y1="9" x2="9" y2="15" />
                        <line x1="9" y1="9" x2="15" y2="15" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-title">Filières du département</div>
                        <div class="card-sub">{{ $filieres->count() }} filière(s)</div>
                    </div>
                    <button onclick="openFiliereAddModal()" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Ajouter une filière
                    </button>
                </div>

                @forelse($filieres as $f)
                    <div class="filiere-row">
                        <div>
                            <div class="filiere-name">{{ $f->nom_filiere }}</div>
                            <div class="filiere-desc">{{ $f->description }}</div>
                        </div>
                        <div class="filiere-actions">
                            <button
                                onclick="openFiliereEditModal({{ $f->id_filiere }}, '{{ addslashes($f->nom_filiere) }}', '{{ addslashes($f->description) }}')"
                                class="filiere-btn filiere-btn-edit">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Modifier
                            </button>
                            <form method="POST" action="{{ route('chef.filieres.delete', $f->id_filiere) }}"
                                onsubmit="return confirm('Supprimer cette filière ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="filiere-btn filiere-btn-delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                                        <path d="M10 11v6M14 11v6" />
                                        <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                                    </svg>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">Aucune filière dans ce département.</div>
                @endforelse
            </div>

        </main>
    </div>

    {{-- ADD MODAL --}}
    <div class="modal-overlay" id="add-modal" onclick="if(event.target===this)closeFiliereAddModal()">
        <div class="modal">
            <div class="modal-header">
                <div>
                    <div class="modal-title">Ajouter une filière</div>
                </div>
                <button class="modal-close" onclick="closeFiliereAddModal()">&times;</button>
            </div>
            <div class="modal-sub">Nouvelle filière dans votre département</div>
            <form method="POST" action="{{ route('chef.filieres.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nom de la filière</label>
                        <input type="text" name="nom_filiere" placeholder="ex: Génie Informatique" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" placeholder="Description de la filière..."
                            required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeFiliereAddModal()">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div class="modal-overlay" id="edit-modal" onclick="if(event.target===this)closeFiliereEditModal()">
        <div class="modal">
            <div class="modal-header">
                <div>
                    <div class="modal-title">Modifier la filière</div>
                </div>
                <button class="modal-close" onclick="closeFiliereEditModal()">&times;</button>
            </div>
            <div class="modal-sub" id="edit-sub"></div>
            <form method="POST" id="edit-form">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nom de la filière</label>
                        <input type="text" name="nom_filiere" id="edit-nom" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="edit-desc" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeFiliereEditModal()">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>