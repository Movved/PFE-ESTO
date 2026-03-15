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
    <title>ESTO Oujda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: var(--background);
            overflow: auto;
        }

        /* NAV */
        .nav {
            height: 72px;
            min-height: 60px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .nav-logo-icon {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-logo-icon svg {
            width: 20px;
            height: 20px;
            stroke: white;
            stroke-width: 1.5;
            fill: none;
        }

        .nav-logo-text {
            font-size: 17px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: background 0.15s ease;
            font-family: inherit;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .btn-secondary {
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-primary);
        }

        .btn-secondary:hover {
            background: var(--background);
        }

        /* HERO */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 80px 24px 48px;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 24px;
        }

        .hero-tag span {
            width: 6px;
            height: 6px;
            background: var(--success);
            border-radius: 50%;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1.15;
            max-width: 680px;
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        .hero-title em {
            font-style: normal;
            color: var(--primary);
        }

        .hero-sub {
            font-size: 16px;
            color: var(--text-secondary);
            max-width: 480px;
            line-height: 1.7;
            margin-bottom: 36px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .hero-actions .btn {
            padding: 10px 22px;
            font-size: 14px;
        }

        /* CARDS */
        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            max-width: 860px;
            width: 100%;
            margin: 64px auto 0;
            padding: 0 24px;
            text-align: left;
        }

        .feature-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
        }

        .feature-icon {
            width: 36px;
            height: 36px;
            margin-bottom: 16px;
            color: var(--text-secondary);
        }

        .feature-icon svg {
            width: 36px;
            height: 36px;
            stroke: currentColor;
            stroke-width: 1.5;
            fill: none;
        }

        .feature-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .feature-desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* FOOTER */
        footer {
            text-align: center;
            padding: 32px;
            font-size: 13px;
            color: var(--text-secondary);
            border-top: 1px solid var(--border);
            margin-top: 64px;
        }

        @media (max-width: 680px) {
            .hero-title {
                font-size: 32px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .nav {
                padding: 0 20px;
            }
        }
    </style>
</head>

<body>

    <nav class="nav">
        <a href="/" class="nav-logo">
            <div class="nav-logo-icon">
                #<!--icon de l'app-->
            </div>
            <!--nom de l'app-->
            <span class="nav-logo-text">#</span>
        </a>

        <div class="nav-actions">
            @auth
                @if(Auth::user()->role === 'ETUDIANT')
                    <a href="{{ route('etudiant.dashboard') }}" class="btn btn-primary">Mon espace</a>
                @elseif(Auth::user()->role === 'ENSEIGNANT')
                    <a href="{{ route('enseignant.dashboard') }}" class="btn btn-primary">Mon espace</a>
                @elseif(Auth::user()->role === 'ADMIN')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Mon espace</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-secondary">Connexion</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-primary">S'inscrire</a>
                @endif
            @endauth
        </div>
    </nav>

    <section class="hero">
        <div class="hero-tag">
            <span></span>
            ESTO Oujda — Plateforme académique
        </div>

        <h1 class="hero-title">
            Gérez vos <em>évaluations</em><br>en toute simplicité
        </h1>

        <p class="hero-sub">
            Un espace numérique unifié pour les étudiants, enseignants et l'administration de l'École Supérieure de
            Technologie d'Oujda.
        </p>

        <div class="hero-actions">
            @auth
                @if(Auth::user()->role === 'ETUDIANT')
                    <a href="{{ route('etudiant.dashboard') }}" class="btn btn-primary">Accéder à mon espace</a>
                @elseif(Auth::user()->role === 'ENSEIGNANT')
                    <a href="{{ route('enseignant.dashboard') }}" class="btn btn-primary">Accéder à mon espace</a>
                @elseif(Auth::user()->role === 'ADMIN')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Accéder à mon espace</a>
                @endif
            @else
                <a href="{{ route('register') }}" class="btn btn-primary">Commencer</a>
                <a href="{{ route('login') }}" class="btn btn-secondary">Se connecter</a>
            @endauth
        </div>

        <div class="cards">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
                <div class="feature-title">Administration</div>
                <div class="feature-desc">Gérez les comptes, les filières et les configurations globales du système.
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                    </svg>
                </div>
                <div class="feature-title">Enseignants</div>
                <div class="feature-desc">Saisissez les notes, gérez vos modules et suivez les performances de vos
                    classes.</div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 11l3 3L22 4" />
                        <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
                    </svg>
                </div>
                <div class="feature-title">Étudiants</div>
                <div class="feature-desc">Consultez vos résultats, signalez des erreurs et suivez votre parcours
                    académique.</div>
            </div>
        </div>
    </section>

    <footer>
        &copy; {{ date('Y') }} ESTO Oujda — Tous droits réservés.
    </footer>

</body>

</html>