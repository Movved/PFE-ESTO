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
    <title>Inscription</title>
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
            max-width: 420px;
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

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 16px;
        }

        .form-row .form-group { margin-bottom: 0; }

        label {
            font-size: 13px; font-weight: 500;
            color: var(--text-primary);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
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
            appearance: none;
        }

        input:focus, select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0,113,227,0.08);
        }

        input::placeholder { color: var(--text-secondary); }

        select option { background: var(--surface); color: var(--text-primary); }

        .form-error {
            font-size: 12px; color: var(--danger); margin-top: 2px;
        }

        .auth-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 24px;
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

    <div class="auth-title">Créer un compte</div>
    <div class="auth-sub">Remplissez les informations ci-dessous pour vous inscrire.</div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom"
                    value="{{ old('prenom') }}" required autocomplete="prenom" placeholder="Prenom">
                @error('prenom')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom"
                    value="{{ old('nom') }}" required autocomplete="nom" placeholder="Nom">
                @error('nom')<span class="form-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-group">
            <label for="email">Adresse e-mail</label>
            <input type="email" id="email" name="email"
                value="{{ old('email') }}" required autocomplete="username" placeholder="prenom.nom24@ump.ac.ma">
            @error('email')<span class="form-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="role">Rôle</label>
            <select id="role" name="role" required>
                <option value="" disabled selected>Vous êtes :</option>
                <option value="ETUDIANT"   {{ old('role') == 'ETUDIANT'   ? 'selected' : '' }}>Étudiant</option>
                <option value="ENSEIGNANT" {{ old('role') == 'ENSEIGNANT' ? 'selected' : '' }}>Enseignant</option>
            </select>
            @error('role')<span class="form-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password"
                required autocomplete="new-password" placeholder="••••••••">
            @error('password')<span class="form-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                required autocomplete="new-password" placeholder="••••••••">
        </div>

        <div class="auth-footer">
            <a href="{{ route('login') }}" class="auth-link">Déjà inscrit ?</a>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </div>
    </form>
</div>

</body>
</html>