<!DOCTYPE html>
<html lang="fr">

<head>
    <script>if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modules</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    {{-- SIDEBAR --}}
    @include('layouts.sidebar-chef')

    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Modules</span>
            <div class="topbar-search">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" placeholder="Rechercher un module..." id="search-input" oninput="filterTable()"
                    style="border:none;background:transparent;font-size:13px;font-family:inherit;color:var(--text-primary);outline:none;width:100%;padding:0;" />
            </div>
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
                        <div class="card-title">Tous les modules</div>
                        <div class="card-sub">{{ $modules->count() }} module(s) dans votre département</div>
                    </div>
                    <button onclick="openAddModal()" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:white;stroke-width:2;fill:none;">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Ajouter un module
                    </button>
                </div>
                <div style="overflow-x:auto;">
                    <table id="notes-table">
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
                                    <td style="font-weight:500;">{{ $m->nom_module }}</td>
                                    <td><span class="code-badge">{{ $m->code_module }}</span></td>
                                    <td style="font-size:12px;color:var(--text-secondary);">{{ $m->nom_filiere }}</td>
                                    <td style="font-size:12px;color:var(--text-secondary);">S{{ $m->semestre_numero }} —
                                        {{ $m->annee }}</td>
                                    <td style="font-size:13px;">{{ $m->prof_prenom }} {{ $m->prof_nom }}</td>
                                    <td>
                                        <span class="badge {{ $m->cloture ? 'badge-closed' : 'badge-open' }}">
                                            <span class="badge-dot"></span>
                                            {{ $m->cloture ? 'Clôturé' : 'En cours' }}
                                        </span>
                                    </td>
                                    <td class="center">
                                        <div style="display:flex;gap:6px;justify-content:center;">
                                            <button
                                                onclick="openEditModal({{ $m->id_module }}, '{{ addslashes($m->code_module) }}', '{{ addslashes($m->nom_module) }}', {{ $m->id_semestre }}, {{ $m->id_enseignant }})"
                                                class="btn btn-secondary btn-sm">Modifier</button>
                                            <form method="POST" action="{{ route('chef.modules.delete', $m->id_module) }}"
                                                onsubmit="return confirm('Supprimer ce module ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                                            </svg>
                                            Aucun module trouvé.
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

    {{-- ADD MODAL --}}
    <div class="modal-overlay" id="add-modal" onclick="if(event.target===this)closeAddModal()">
        <div class="modal">
            <div class="modal-header">
                <div>
                    <div class="modal-title">Ajouter un module</div>
                    <div class="modal-sub">Nouveau module dans votre département</div>
                </div>
                <button class="modal-close" onclick="closeAddModal()">&times;</button>
            </div>
            <form method="POST" action="{{ route('chef.modules.store') }}">
                @csrf
                <div class="form-group">
                    <label>Code module</label>
                    <input type="text" name="code_module" placeholder="ex: INF101" required>
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
                            <option value="{{ $s->id_semestre }}">S{{ $s->semestre_numero }} — {{ $s->libelle }}
                                ({{ $s->nom_filiere }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Enseignant</label>
                    <select name="id_enseignant" required>
                        <option value="">— Choisir un enseignant —</option>
                        @foreach($enseignants as $e)
                            <option value="{{ $e->id_enseignant }}">{{ $e->prenom }} {{ $e->nom }}</option>
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
                <div>
                    <div class="modal-title">Modifier le module</div>
                    <div class="modal-sub" id="edit-modal-sub"></div>
                </div>
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
                            <option value="{{ $s->id_semestre }}">S{{ $s->semestre_numero }} — {{ $s->libelle }}
                                ({{ $s->nom_filiere }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Enseignant</label>
                    <select name="id_enseignant" id="edit-enseignant" required>
                        @foreach($enseignants as $e)
                            <option value="{{ $e->id_enseignant }}">{{ $e->prenom }} {{ $e->nom }}</option>
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
            document.getElementById('edit-form').action = `/chef/modules/${id}`;
            document.getElementById('edit-modal-sub').textContent = nom;
            document.getElementById('edit-code').value = code;
            document.getElementById('edit-nom').value = nom;
            document.getElementById('edit-semestre').value = semestreId;
            document.getElementById('edit-enseignant').value = enseignantId;
            document.getElementById('edit-modal').classList.add('open');
        }
        function closeEditModal() { document.getElementById('edit-modal').classList.remove('open'); }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') { closeAddModal(); closeEditModal(); }
        });
    </script>

</body>

</html>