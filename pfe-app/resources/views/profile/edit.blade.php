<!DOCTYPE html>
<html lang="fr">

<head>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
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
        @php
            $enseignant = \DB::table('ENSEIGNANT')->where('id_user', Auth::user()->id_user)->first();
        @endphp

        @if($enseignant && $enseignant->is_chef)
            @include('layouts.sidebar-chef')
        @else
            @include('layouts.sidebar-prof')
        @endif

    @elseif(Auth::user()->role === 'ADMIN')
        @include('layouts.sidebar-admin')
    @endif

    {{-- MAIN --}}
    <div class="main">

        {{-- TOPBAR --}}
        <header class="topbar">
            <span class="topbar-title">Profil</span>

            <div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
                <span id="topbar-time"
                    style="font-size:14px; font-weight:600; color:var(--text-primary); font-family:'SF Mono','Fira Code',monospace;"></span>
                <span id="topbar-date" style="font-size:11px; color:var(--text-secondary);"></span>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="content">

            {{-- Update Profile Information --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Informations du profil</div>
                    <div class="card-desc">Mettez à jour votre nom et votre adresse e-mail.</div>
                </div>
                <div class="card-body">
                    @if(session('status') === 'profile-updated')
                        <div class="alert alert-success">
                            <svg viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                            Profil mis à jour avec succès.
                        </div>
                    @endif

                    <form method="post" action="{{ route('profile.password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div class="form-row">
                            <div class="form-group">
                                <label for="prenom">Prénom</label>
                                <input type="text" id="prenom" name="prenom"
                                    value="{{ old('prenom', Auth::user()->prenom) }}" required>
                                @error('prenom')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" id="nom" name="nom" value="{{ old('nom', Auth::user()->nom) }}"
                                    required>
                                @error('nom')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-row single">
                            <div class="form-group">
                                <label for="email">Adresse e-mail</label>
                                <input type="email" id="email" name="email"
                                    value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Update Password --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Mot de passe</div>
                    <div class="card-desc">Utilisez un mot de passe long et aléatoire pour rester en sécurité.</div>
                </div>
                <div class="card-body">
                    @if(session('status') === 'password-updated')
                        <div class="alert alert-success">
                            <svg viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                            Mot de passe mis à jour.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="form-row single">
                            <div class="form-group">
                                <label for="current_password">Mot de passe actuel</label>
                                <input type="password" id="current_password" name="current_password"
                                    autocomplete="current-password" placeholder="••••••••">
                                @error('current_password')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="password">Nouveau mot de passe</label>
                                <input type="password" id="password" name="password" autocomplete="new-password"
                                    placeholder="••••••••">
                                @error('password')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirmer le mot de passe</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    autocomplete="new-password" placeholder="••••••••">
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
                    <div class="card-title">Apparence</div>
                    <div class="card-desc">Choisissez le thème de l'interface.</div>
                </div>
                <div class="card-body">
                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <div>
                            <div style="font-size:14px; font-weight:500; color:var(--text-primary);">Mode sombre</div>
                            <div style="font-size:13px; color:var(--text-secondary); margin-top:2px;">Basculer entre le
                                mode clair et sombre</div>
                        </div>
                        <button class="toggle-btn" id="theme-toggle" onclick="toggleTheme()">
                            <span class="toggle-knob" id="toggle-knob"></span>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal-overlay" id="delete-modal" onclick="closeDeleteIfOverlay(event)">
        <div class="modal">
            <div class="modal-header">
                <div>
                    <div class="modal-title">Confirmer la suppression</div>
                    <div class="modal-sub">Entrez votre mot de passe pour confirmer la suppression définitive de votre
                        compte.</div>
                </div>
                <button class="modal-close"
                    onclick="document.getElementById('delete-modal').classList.remove('open')">&times;</button>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-body">
                    @if($errors->userDeletion->isNotEmpty())
                        <div class="alert alert-error" style="margin-bottom:12px;">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="15" y1="9" x2="9" y2="15" />
                                <line x1="9" y1="9" x2="15" y2="15" />
                            </svg>
                            {{ $errors->userDeletion->first('password') }}
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="delete_password">Mot de passe</label>
                        <input type="password" id="delete_password" name="password" placeholder="••••••••"
                            autocomplete="current-password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        onclick="document.getElementById('delete-modal').classList.remove('open')">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            document.getElementById('theme-toggle').classList.toggle('on', isDark);
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }


        if (localStorage.getItem('theme') === 'dark') {
            document.getElementById('theme-toggle').classList.add('on');
        }

        function closeDeleteIfOverlay(e) {
            if (e.target === document.getElementById('delete-modal'))
                document.getElementById('delete-modal').classList.remove('open');
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') document.getElementById('delete-modal').classList.remove('open');
        });
    </script>

</body>

</html>