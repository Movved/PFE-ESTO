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
    <title>Connexion</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: var(--background);
        }

        .auth-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 36px;
            width: 100%;
            max-width: 400px;
        }

        .auth-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .auth-logo-icon {
            width: 32px; height: 32px;
            background: var(--primary);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }

        .auth-logo-icon svg {
            width: 18px; height: 18px;
            stroke: white; stroke-width: 1.5; fill: none;
        }

        .auth-logo-text {
            font-size: 15px; font-weight: 600;
            color: var(--text-primary);
        }

        .auth-title {
            font-size: 22px; font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .auth-sub {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 24px;
        }

        .form-group {
            display: flex; flex-direction: column; gap: 6px;
            margin-bottom: 16px;
        }

        label {
            font-size: 13px; font-weight: 500;
            color: var(--text-primary);
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            transition: border-color 0.15s ease;
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0,113,227,0.08);
        }

        input::placeholder { color: var(--text-secondary); }

        .form-error {
            font-size: 12px; color: var(--danger); margin-top: 2px;
        }

        .remember-row {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 24px;
        }

        .remember-row input[type="checkbox"] {
            width: 15px; height: 15px;
            border: 1px solid var(--border);
            border-radius: 4px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .remember-row label {
            font-size: 13px; font-weight: 400;
            color: var(--text-secondary);
            cursor: pointer;
        }

        .auth-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .auth-link {
            font-size: 13px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.15s;
        }

        .auth-link:hover { color: var(--text-primary); }

        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 13px; font-weight: 500;
            cursor: pointer; border: none;
            transition: background 0.15s ease;
            font-family: inherit;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-hover); }

        .status-msg {
            font-size: 13px; color: #1A7A34;
            background: #F0FBF4;
            border: 1px solid #A8E6BA;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="auth-logo">
        <div class="auth-logo-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
            </svg>
        </div>
        <span class="auth-logo-text">Gestionnaire</span>
    </div>

    <div class="auth-title">Connexion</div>
    <div class="auth-sub">Entrez vos identifiants pour accéder à votre espace.</div>

    @if (session('status'))
        <div class="status-msg">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Adresse e-mail</label>
            <input type="email" id="email" name="email"
                value="{{ old('email') }}" required autofocus autocomplete="username"
                placeholder="prenom.nom24@ump.ac.ma">
            @error('email')<span class="form-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password"
                required autocomplete="current-password" placeholder="••••••••">
            @error('password')<span class="form-error">{{ $message }}</span>@enderror
        </div>

        <div class="remember-row">
            <input type="checkbox" id="remember_me" name="remember">
            <label for="remember_me">Se souvenir de moi</label>
        </div>

        <div class="auth-footer">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">Mot de passe oublié ?</a>
            @else
                <a href="{{ route('register') }}" class="auth-link">Créer un compte</a>
            @endif
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>
    </form>
</div>

</body>
</html>