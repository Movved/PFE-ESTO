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
    <title>Mot de passe oublié</title>
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
            line-height: 1.6;
        }

        .form-group {
            display: flex; flex-direction: column; gap: 6px;
            margin-bottom: 20px;
        }

        label {
            font-size: 13px; font-weight: 500;
            color: var(--text-primary);
        }

        input[type="email"] {
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

        .status-msg {
            font-size: 13px; color: #1A7A34;
            background: #F0FBF4;
            border: 1px solid #A8E6BA;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 20px;
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

    <div class="auth-title">Mot de passe oublié ?</div>
    <div class="auth-sub">
        Indiquez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.
    </div>

    @if (session('status'))
        <div class="status-msg">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label for="email">Adresse e-mail</label>
            <input type="email" id="email" name="email"
                value="{{ old('email') }}" required autofocus
                placeholder="prenom.nom24@ump.ac.ma">
            @error('email')<span class="form-error">{{ $message }}</span>@enderror
        </div>

        <div class="auth-footer">
            <a href="{{ route('login') }}" class="auth-link">Retour à la connexion</a>
            <button type="submit" class="btn btn-primary">Envoyer le lien</button>
        </div>
    </form>
</div>

</body>
</html>