<!DOCTYPE html>
<html lang="fr">
<head>
    <script>
        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Filières</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css', 'resources/js/admin/admin.js'])
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="main" id="main-content">
        @include('layouts.topbar', [
            'title'             => 'Filières',
            'search'            => true,
            'searchPlaceholder' => 'Rechercher une filière...',
        ])

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Filières</div>
                        <div class="card-sub">{{ $filieres->count() }} filière(s) — {{ $departements->count() }} départements</div>
                    </div>
                    <button onclick="openAddModal()" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Ajouter une filière
                    </button>
                </div>
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Filière</th>
                                <th>Département</th>
                                <th>Description</th>
                                <th class="center">Étudiants</th>
                                <th class="center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($filieres as $f)
                            <tr>
                                <td><div class="etu-name">{{ $f->nom_filiere }}</div></td>
                                <td><span class="badge badge-pending"><span class="badge-dot"></span>{{ $f->nom_departement }}</span></td>
                                <td class="cell-secondary" style="max-width:240px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $f->description ?? '—' }}</td>
                                <td class="center"><span class="etu-name">{{ $f->nb_etudiants }}</span></td>
                                <td class="center">
                                    <div class="action-group action-group--center">
                                        <button onclick="openEditModal({{ $f->id_filiere }}, '{{ addslashes($f->nom_filiere) }}', '{{ addslashes($f->description ?? '') }}', {{ $f->id_departement }})"
                                            class="btn btn-secondary btn-sm">Modifier</button>
                                        <form method="POST" action="{{ route('admin.filieres.destroy', $f->id_filiere) }}" onsubmit="return confirm('Supprimer cette filière ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5"><div class="empty-state">Aucune filière trouvée.</div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    {{-- ADD MODAL --}}
    <div class="modal-overlay" id="add-modal" onclick="if(event.target===this)closeAddModal()">
        <div class="modal">
            <div class="modal-header">
                <div><div class="modal-title">Ajouter une filière</div><div class="modal-sub">Nouvelle filière pédagogique</div></div>
                <button class="modal-close" onclick="closeAddModal()">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.filieres.store') }}">
                @csrf
                <div class="form-group">
                    <label>Nom de la filière</label>
                    <input type="text" name="nom_filiere" placeholder="ex: Conception et Développement des Logiciels" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3" placeholder="Description de la filière..."></textarea>
                </div>
                <div class="form-group">
                    <label>Département</label>
                    <select name="id_departement" required>
                        <option value="">— Choisir un département —</option>
                        @foreach($departements as $d)
                            <option value="{{ $d->id_departement }}">{{ $d->nom_departement }}</option>
                        @endforeach
                    </select>
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
                <div><div class="modal-title">Modifier la filière</div><div class="modal-sub" id="edit-modal-sub"></div></div>
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
                    <textarea name="description" id="edit-description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Département</label>
                    <select name="id_departement" id="edit-departement" required>
                        @foreach($departements as $d)
                            <option value="{{ $d->id_departement }}">{{ $d->nom_departement }}</option>
                        @endforeach
                    </select>
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
        function openEditModal(id, nom, description, departementId) {
            document.getElementById('edit-form').action = `/admin/filieres/${id}`;
            document.getElementById('edit-modal-sub').textContent = nom;
            document.getElementById('edit-nom').value = nom;
            document.getElementById('edit-description').value = description;
            document.getElementById('edit-departement').value = departementId;
            document.getElementById('edit-modal').classList.add('open');
        }
        function closeEditModal() { document.getElementById('edit-modal').classList.remove('open'); }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeAddModal(); closeEditModal(); } });
    </script>
</body>
</html>