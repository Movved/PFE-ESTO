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
    <title>Admin — Modifier Enseignant</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css'])
</head>

<body>
    @include('layouts.sidebar-admin')

    <div class="main" id="main-content">
        @include('layouts.topbar', ['title' => 'Modifier un enseignant'])

        <main class="content">

            <a href="{{ route('admin.enseignants') }}" class="module-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
                Retour aux enseignants
            </a>

            <div class="module-header">
                <div>
                    <h1 class="module-title">{{ $enseignant->prenom }} {{ $enseignant->nom }}</h1>
                    <span class="cell-secondary">{{ $enseignant->nom_departement }}</span>
                </div>
            </div>

            <div class="card" style="max-width:640px;">
                <div class="card-header">
                    <div>
                        <div class="card-title">Modifier les informations</div>
                        <div class="card-sub">Mettre à jour le compte enseignant</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.enseignants.update', $enseignant->id_enseignant) }}">
                    @csrf @method('PUT')
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Prénom</label>
                                <input type="text" name="prenom" value="{{ old('prenom', $enseignant->prenom) }}">
                                @error('prenom')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" value="{{ old('nom', $enseignant->nom) }}">
                                @error('nom')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email', $enseignant->email) }}">
                            @error('email')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Spécialité</label>
                            <input type="text" name="specialite"
                                value="{{ old('specialite', $enseignant->specialite) }}">
                            @error('specialite')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Département</label>
                            <select name="id_departement">
                                @foreach($departements as $d)
                                    <option value="{{ $d->id_departement }}" {{ (old('id_departement', $enseignant->id_departement) == $d->id_departement) ? 'selected' : '' }}>
                                        {{ $d->nom_departement }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_departement')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                        <label class="checkbox-row">
                            <input type="checkbox" name="is_chef" {{ $enseignant->is_chef ? 'checked' : '' }}>
                            Chef de département
                        </label>
                        <label class="checkbox-row">
                            <input type="checkbox" name="actif" {{ $enseignant->actif ? 'checked' : '' }}>
                            Compte actif
                        </label>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('admin.enseignants') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>

        </main>
    </div>
</body>

</html>