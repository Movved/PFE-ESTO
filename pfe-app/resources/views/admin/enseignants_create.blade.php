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
    <title>Admin — Ajouter Enseignant</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css', 'resources/js/admin/admin.js'])
</head>

<body>
    @include('layouts.sidebar-admin')

    <div class="main" id="main-content">
        @include('layouts.topbar', ['title' => 'Ajouter un enseignant'])

        <main class="content">

<a href="{{ route('admin.enseignants') }}" class="module-back" style="color:inherit; justify-content:center;">                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" width="16" height="16">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
                Retour aux enseignants
            </a>

            <div class="module-header">
                <div>
                    <h1 class="module-title">Nouvel enseignant</h1>
                    <span class="cell-secondary">Créer un nouveau compte enseignant</span>
                </div>
            </div>

            <div class="card" style="max-width:640px;">
                <div class="card-header">
                    <div>
                        <div class="card-title">Informations du compte</div>
                        <div class="card-sub">Renseigner les informations de l'enseignant</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.enseignants.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Prénom</label>
                                <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Youssef">
                                @error('prenom')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Benali">
                                @error('nom')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="y.benali@ump.ac.ma">
                            @error('email')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Spécialité</label>
                            <input type="text" name="specialite" value="{{ old('specialite') }}"
                                placeholder="Informatique">
                            @error('specialite')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Département</label>
                            <select name="id_departement">
                                <option value="">-- Choisir un département --</option>
                                @foreach($departements as $d)
                                    <option value="{{ $d->id_departement }}" {{ old('id_departement') == $d->id_departement ? 'selected' : '' }}>
                                        {{ $d->nom_departement }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_departement')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input type="checkbox" name="is_chef" value="1" {{ old('is_chef') ? 'checked' : '' }}>
                                Chef de département
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="mot_de_passe" placeholder="••••••••">
                            @error('mot_de_passe')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('admin.enseignants') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Créer l'enseignant</button>
                    </div>
                </form>
            </div>

        </main>
    </div>
</body>

</html>