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
    <title>Admin — Modifier Note</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css'])
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="main" id="main-content">
        @include('layouts.topbar', ['title' => 'Modifier une note'])

        <main class="content">

            <a href="{{ route('admin.notes') }}" class="module-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Retour aux notes
            </a>

            <div class="module-header">
                <div>
                    <h1 class="module-title">Modifier la note</h1>
                    <span class="cell-secondary">{{ $note->nom_module }} — {{ $note->prenom }} {{ $note->nom }}</span>
                </div>
            </div>

            <div class="card" style="max-width:520px;">
                <div class="card-header">
                    <div>
                        <div class="card-title">Informations</div>
                        <div class="card-sub">Détails de la note à modifier</div>
                    </div>
                </div>

                {{-- Info rows --}}
                <div style="padding:0 20px;">
                    <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--border);font-size:13px;">
                        <span class="cell-secondary">Étudiant</span>
                        <span class="etu-name">{{ $note->prenom }} {{ $note->nom }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;font-size:13px;">
                        <span class="cell-secondary">Module</span>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span style="font-weight:500;color:var(--text-1);">{{ $note->nom_module }}</span>
                            <span class="code-badge">{{ $note->code_module }}</span>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.notes.update', $note->id_note) }}">
                    @csrf @method('PUT')
                    <div class="card-body" style="border-top:1px solid var(--border);">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Note (0 — 20)</label>
                                <input type="number" name="note" class="note-input" style="width:100%;"
                                    step="0.01" min="0" max="20"
                                    value="{{ old('note', $note->note) }}"
                                    placeholder="Ex: 14.50">
                                @error('note')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Rattrapage (0 — 20)</label>
                                <input type="number" name="rattrapage" class="note-input" style="width:100%;"
                                    step="0.01" min="0" max="20"
                                    value="{{ old('rattrapage', $note->rattrapage) }}"
                                    placeholder="—">
                                @error('rattrapage')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('admin.notes') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>

        </main>
    </div>
</body>
</html>