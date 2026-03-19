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
    <title>Confirmer le mot de passe</title>
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

        <div class="auth-title">Zone sécurisée</div>
        <div class="auth-sub">Veuillez confirmer votre mot de passe avant de continuer.</div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required autocomplete="current-password"
                    placeholder="••••••••">
                @error('password')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="auth-footer">
                <span></span>
                <button type="submit" class="btn btn-primary">Confirmer</button>
            </div>
        </form>

    </div>
</body>

</html>