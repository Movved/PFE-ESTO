<!DOCTYPE html>
<html lang="fr">

<head>
    <script>if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filières</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    {{-- SIDEBAR --}}
    @include('layouts.sidebar-chef')

    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Filières — {{ $departement->nom_departement }}</span>
            <div style="display:flex;flex-direction:column;align-items:center;gap:2px;">
                <span id="topbar-time"
                    style="font-size:14px;font-weight:600;color:var(--text-primary);font-family:'SF Mono','Fira Code',monospace;"></span>
                <span id="topbar-date" style="font-size:11px;color:var(--text-secondary);"></span>
            </div>
        </header>

        <main class="content">

            @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="15" y1="9" x2="9" y2="15" />
                        <line x1="9" y1="9" x2="15" y2="15" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Filières du département</div>
                        <div class="card-sub">{{ $filieres->count() }} filière(s)</div>
                    </div>
                    <button onclick="openAddModal()" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:white;stroke-width:2;fill:none;">
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
                        <div style="display:flex;gap:8px;flex-shrink:0;margin-left:16px;">
                            <button
                                onclick="openEditModal({{ $f->id_filiere }}, '{{ addslashes($f->nom_filiere) }}', '{{ addslashes($f->description) }}')"
                                class="btn btn-secondary btn-sm">Modifier</button>
                            <form method="POST" action="{{ route('chef.filieres.delete', $f->id_filiere) }}"
                                onsubmit="return confirm('Supprimer cette filière ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
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
    <div class="modal-overlay" id="add-modal" onclick="if(event.target===this)closeAddModal()">
        <div class="modal">
            <div class="modal-header">
                <div>
                    <div class="modal-title">Ajouter une filière</div>
                    <div class="modal-sub">Nouvelle filière dans votre département</div>
                </div>
                <button class="modal-close" onclick="closeAddModal()">&times;</button>
            </div>
            <form method="POST" action="{{ route('chef.filieres.store') }}">
                @csrf
                <div class="form-group">
                    <label>Nom de la filière</label>
                    <input type="text" name="nom_filiere" placeholder="ex: Génie Informatique" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3" placeholder="Description de la filière..."
                        required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div class="modal-overlay" id="edit-modal" onclick="if(event.target===this)closeEditModal()">
        <div class="modal">
            <div class="modal-header">
                <div>
                    <div class="modal-title">Modifier la filière</div>
                    <div class="modal-sub" id="edit-sub"></div>
                </div>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <form method="POST" id="edit-form">
                @csrf @method('PUT')
                <div class="form-group">
                    <label>Nom de la filière</label>
                    <input type="text" name="nom_filiere" id="edit-nom" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="edit-desc" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() { document.getElementById('add-modal').classList.add('open'); }
        function closeAddModal() { document.getElementById('add-modal').classList.remove('open'); }
        function openEditModal(id, nom, desc) {
            document.getElementById('edit-form').action = `/chef/filieres/${id}`;
            document.getElementById('edit-sub').textContent = nom;
            document.getElementById('edit-nom').value = nom;
            document.getElementById('edit-desc').value = desc;
            document.getElementById('edit-modal').classList.add('open');
        }
        function closeEditModal() { document.getElementById('edit-modal').classList.remove('open'); }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeAddModal(); closeEditModal(); } });
    </script>

</body>

</html>