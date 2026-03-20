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
    <title>Admin — Modifier Étudiant</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css', 'resources/js/admin/admin.js'])
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="main" id="main-content">
        @include('layouts.topbar', ['title' => 'Modifier un étudiant'])

        <main class="content">

            <a href="{{ route('admin.etudiants') }}" class="module-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Retour aux étudiants
            </a>

            <div class="module-header">
                <div>
                    <h1 class="module-title">{{ $etudiant->prenom }} {{ $etudiant->nom }}</h1>
                    <span class="cell-secondary">CNE : {{ $etudiant->cne }}</span>
                </div>
            </div>

            <div class="card" style="max-width:640px;">
                <div class="card-header">
                    <div>
                        <div class="card-title">Modifier les informations</div>
                        <div class="card-sub">Mettre à jour le compte étudiant</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.etudiants.update', $etudiant->id_etudiant) }}">
                    @csrf @method('PUT')
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Prénom</label>
                                <input type="text" name="prenom" value="{{ old('prenom', $etudiant->prenom) }}">
                                @error('prenom')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" value="{{ old('nom', $etudiant->nom) }}">
                                @error('nom')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email', $etudiant->email) }}">
                            @error('email')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">CNE</label>
                            <input type="text" name="cne" value="{{ old('cne', $etudiant->cne) }}">
                            @error('cne')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                        <label class="checkbox-row">
                            <input type="checkbox" name="actif" {{ $etudiant->actif ? 'checked' : '' }}>
                            Compte actif
                        </label>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('admin.etudiants') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>

        </main>
    </div>
</body>
</html>