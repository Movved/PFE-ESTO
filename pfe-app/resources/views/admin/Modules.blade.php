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
    <title>Admin — Modules</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css', 'resources/js/admin/admin.js'])
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="main" id="main-content">
        @include('layouts.topbar', [
            'title'             => 'Modules',
            'search'            => true,
            'searchPlaceholder' => 'Rechercher un module...',
        ])

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- FILTER BAR --}}
            <form method="GET" action="{{ route('admin.modules') }}" style="display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap;">
                <select name="filiere" class="btn btn-secondary" style="font-size:13px;padding:7px 12px;">
                    <option value="">Toutes les filières</option>
                    @foreach($filieres as $f)
                        <option value="{{ $f->id_filiere }}" {{ request('filiere') == $f->id_filiere ? 'selected' : '' }}>{{ $f->nom_filiere }}</option>
                    @endforeach
                </select>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom ou code module..." class="btn btn-secondary" style="font-size:13px;padding:7px 12px;min-width:220px;text-align:left;">
                <button type="submit" class="btn btn-primary">Filtrer</button>
                @if(request('filiere') || request('search'))
                    <a href="{{ route('admin.modules') }}" class="btn btn-secondary">Réinitialiser</a>
                @endif
            </form>

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Modules</div>
                        <div class="card-sub">{{ $modules->count() }} module(s) trouvé(s)</div>
                    </div>
                    <button onclick="openAddModal()" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Ajouter un module
                    </button>
                </div>
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th>Code</th>
                                <th>Filière</th>
                                <th>Semestre</th>
                                <th>Enseignant</th>
                                <th>Statut</th>
                                <th class="center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($modules as $m)
                            <tr>
                                <td><div class="etu-name">{{ $m->nom_module }}</div></td>
                                <td><span class="code-badge">{{ $m->code_module }}</span></td>
                                <td class="cell-secondary" style="max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $m->nom_filiere }}</td>
                                <td class="cell-secondary">S{{ $m->semestre_numero }} — {{ $m->annee_libelle }}</td>
                                <td class="cell-secondary">
                                    @if($m->prof_nom)
                                        {{ $m->prof_prenom }} {{ $m->prof_nom }}
                                    @else —
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $m->cloture ? 'badge-closed' : 'badge-open' }}">
                                        <span class="badge-dot"></span>{{ $m->cloture ? 'Clôturé' : 'En cours' }}
                                    </span>
                                </td>
                                <td class="center">
                                    <div class="action-group action-group--center">
                                        <button onclick="openEditModal({{ $m->id_module }}, '{{ addslashes($m->code_module) }}', '{{ addslashes($m->nom_module) }}', {{ $m->id_semestre }}, {{ $m->id_enseignant ?? 'null' }})"
                                            class="btn btn-secondary btn-sm">Modifier</button>
                                        <form method="POST" action="{{ route('admin.modules.destroy', $m->id_module) }}" onsubmit="return confirm('Supprimer ce module ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7"><div class="empty-state">Aucun module trouvé.</div></td></tr>
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
                <div><div class="modal-title">Ajouter un module</div><div class="modal-sub">Nouveau module académique</div></div>
                <button class="modal-close" onclick="closeAddModal()">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.modules.store') }}">
                @csrf
                <div class="form-group">
                    <label>Code module</label>
                    <input type="text" name="code_module" placeholder="ex: CDL-S1-M1" required>
                </div>
                <div class="form-group">
                    <label>Nom du module</label>
                    <input type="text" name="nom_module" placeholder="ex: Algorithmique" required>
                </div>
                <div class="form-group">
                    <label>Semestre</label>
                    <select name="id_semestre" required>
                        <option value="">— Choisir un semestre —</option>
                        @foreach($semestres as $s)
                            <option value="{{ $s->id_semestre }}">S{{ $s->numero }} — {{ $s->libelle }} ({{ $s->nom_filiere }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Enseignant responsable</label>
                    <select name="id_enseignant">
                        <option value="">— Aucun —</option>
                        @foreach($enseignants as $e)
                            <option value="{{ $e->id_enseignant }}">{{ $e->prenom }} {{ $e->nom }} ({{ $e->specialite }})</option>
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
                <div><div class="modal-title">Modifier le module</div><div class="modal-sub" id="edit-modal-sub"></div></div>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <form method="POST" id="edit-form">
                @csrf @method('PUT')
                <div class="form-group">
                    <label>Code module</label>
                    <input type="text" name="code_module" id="edit-code" required>
                </div>
                <div class="form-group">
                    <label>Nom du module</label>
                    <input type="text" name="nom_module" id="edit-nom" required>
                </div>
                <div class="form-group">
                    <label>Semestre</label>
                    <select name="id_semestre" id="edit-semestre" required>
                        @foreach($semestres as $s)
                            <option value="{{ $s->id_semestre }}">S{{ $s->numero }} — {{ $s->libelle }} ({{ $s->nom_filiere }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Enseignant responsable</label>
                    <select name="id_enseignant" id="edit-enseignant">
                        <option value="">— Aucun —</option>
                        @foreach($enseignants as $e)
                            <option value="{{ $e->id_enseignant }}">{{ $e->prenom }} {{ $e->nom }} ({{ $e->specialite }})</option>
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
        function openEditModal(id, code, nom, semestreId, enseignantId) {
            document.getElementById('edit-form').action = `/admin/modules/${id}`;
            document.getElementById('edit-modal-sub').textContent = nom;
            document.getElementById('edit-code').value = code;
            document.getElementById('edit-nom').value = nom;
            document.getElementById('edit-semestre').value = semestreId;
            document.getElementById('edit-enseignant').value = enseignantId || '';
            document.getElementById('edit-modal').classList.add('open');
        }
        function closeEditModal() { document.getElementById('edit-modal').classList.remove('open'); }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeAddModal(); closeEditModal(); } });
    </script>
</body>
</html>