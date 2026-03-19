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
    <title>Profil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    @if(Auth::user()->role === 'ETUDIANT')
        @include('layouts.sidebar-etudiant')
    @elseif(Auth::user()->role === 'ENSEIGNANT')
        @php $enseignant = \DB::table('ENSEIGNANT')->where('id_user', Auth::user()->id_user)->first(); @endphp
        @if($enseignant && $enseignant->is_chef)
            @include('layouts.sidebar-chef')
        @else
            @include('layouts.sidebar-prof')
        @endif
    @elseif(Auth::user()->role === 'ADMIN')
        @include('layouts.sidebar-admin')
    @endif

    <div class="main" id="main-content">
        @include('layouts.topbar', ['title' => 'Profil'])

        <main class="content">

            {{-- Profile info --}}
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Informations du profil</div>
                        <div class="card-sub">Mettez à jour votre nom et votre adresse e-mail.</div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('status') === 'profile-updated')
                        <div class="alert alert-success">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                            Profil mis à jour avec succès.
                        </div>
                    @endif

                    <form method="post" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('patch')
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="prenom">Prénom</label>
                                <input type="text" id="prenom" name="prenom" value="{{ old('prenom', Auth::user()->prenom) }}" required>
                                @error('prenom')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="nom">Nom</label>
                                <input type="text" id="nom" name="nom" value="{{ old('nom', Auth::user()->nom) }}" required>
                                @error('nom')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="form-row single">
                            <div class="form-group">
                                <label class="form-label" for="email">Adresse e-mail</label>
                                <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Password --}}
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Mot de passe</div>
                        <div class="card-sub">Utilisez un mot de passe long et aléatoire pour rester en sécurité.</div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('status') === 'password-updated')
                        <div class="alert alert-success">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                            Mot de passe mis à jour.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')
                        <div class="form-row single">
                            <div class="form-group">
                                <label class="form-label" for="current_password">Mot de passe actuel</label>
                                <input type="password" id="current_password" name="current_password" autocomplete="current-password" placeholder="••••••••">
                                @error('current_password')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="password">Nouveau mot de passe</label>
                                <input type="password" id="password" name="password" autocomplete="new-password" placeholder="••••••••">
                                @error('password')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">Confirmer le mot de passe</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="••••••••">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Appearance --}}
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Apparence</div>
                        <div class="card-sub">Choisissez le thème de l'interface.</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="profile-theme-row">
                        <div>
                            <div class="profile-theme-label">Mode sombre</div>
                            <div class="profile-theme-sub">Basculer entre le mode clair et sombre</div>
                        </div>
                        <button class="toggle-btn" id="theme-toggle" onclick="toggleTheme()">
                            <span class="toggle-knob"></span>
                        </button>
                    </div>
                </div>
            </div>
</body>
</html>