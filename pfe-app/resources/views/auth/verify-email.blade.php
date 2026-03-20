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
    <title>Réinitialiser le mot de passe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: auto;
        }
    </style>
</head>

<body>
    <div class="auth-card">

        <div class="auth-logo">
            <div class="auth-logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                    <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5" />
                </svg>
            </div>
            <span class="auth-logo-text">Gestionnaire</span>
        </div>

        <div class="auth-title">Nouveau mot de passe</div>
        <div class="auth-sub">Choisissez un nouveau mot de passe pour votre compte.</div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label for="email">Adresse e-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required
                    autofocus autocomplete="username" placeholder="prenom.nom24@ump.ac.ma">
                @error('email')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" id="password" name="password" required autocomplete="new-password"
                    placeholder="••••••••">
                @error('password')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    autocomplete="new-password" placeholder="••••••••">
                @error('password_confirmation')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="auth-footer">
                <a href="{{ route('login') }}" class="auth-link">Retour à la connexion</a>
                <button type="submit" class="btn btn-primary">Réinitialiser</button>
            </div>
        </form>

    </div>
</body>

</html>