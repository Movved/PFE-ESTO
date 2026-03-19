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
    <title>Admin — Ajouter Étudiant</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css'])
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="main" id="main-content">
        @include('layouts.topbar', ['title' => 'Ajouter un étudiant'])

        <main class="content">

            <a href="{{ route('admin.etudiants') }}" class="module-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Retour aux étudiants
            </a>

            <div class="module-header">
                <div>
                    <h1 class="module-title">Nouvel étudiant</h1>
                    <span class="cell-secondary">Créer un nouveau compte étudiant</span>
                </div>
            </div>

            <div class="card" style="max-width:640px;">
                <div class="card-header">
                    <div>
                        <div class="card-title">Informations du compte</div>
                        <div class="card-sub">Renseigner les informations de l'étudiant</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.etudiants.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Prénom</label>
                                <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Mohammed">
                                @error('prenom')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Bellatrach">
                                @error('nom')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="m.bellatrach@ump.ac.ma">
                            @error('email')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">CNE</label>
                            <input type="text" name="cne" value="{{ old('cne') }}" placeholder="G110023001">
                            @error('cne')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="mot_de_passe" placeholder="••••••••">
                            @error('mot_de_passe')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('admin.etudiants') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Créer l'étudiant</button>
                    </div>
                </form>
            </div>

        </main>
    </div>
</body>
</html>