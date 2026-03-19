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
    <title>ESTO Oujda — Gestionnaire académique</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="lp-body">

    {{-- NAV --}}
    <nav class="lp-nav">
        <a href="/" class="lp-logo">
            <div class="lp-logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
                </svg>
            </div>
            <span class="lp-logo-text">Gestionnaire</span>
        </a>
        <div class="lp-nav-right">
            <span class="lp-nav-label">EST Oujda</span>
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
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-primary">S'inscrire</a>
                @endif
            @endauth
        </div>
    </nav>

    {{-- HERO --}}
    <div class="lp-hero">
        <div class="lp-grid-bg" aria-hidden="true"></div>

        {{-- LEFT --}}
        <div class="lp-left">
            <div class="lp-stripe" aria-hidden="true"></div>

            <div class="lp-eyebrow">
                <span class="lp-eyebrow-dot"></span>
                Université Mohammed Premier · EST Oujda
            </div>

            <h1 class="lp-title">
                La plateforme<br>académique <em>unifiée</em>
            </h1>

            <p class="lp-subtitle">
                Notes, réclamations, modules et filières —
                tout ce dont les étudiants, enseignants et chefs
                de département ont besoin, en un seul endroit.
            </p>

            <div class="lp-cta">
                @auth
                    @if(Auth::user()->role === 'ETUDIANT')
                        <a href="{{ route('etudiant.dashboard') }}" class="btn btn-primary lp-btn">Accéder à mon espace</a>
                    @elseif(Auth::user()->role === 'ENSEIGNANT')
                        <a href="{{ route('enseignant.dashboard') }}" class="btn btn-primary lp-btn">Accéder à mon espace</a>
                    @elseif(Auth::user()->role === 'ADMIN')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary lp-btn">Accéder à mon espace</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary lp-btn">Se connecter</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-secondary lp-btn">Créer un compte</a>
                    @endif
                @endauth
            </div>

            <div class="lp-stats">
                <div class="lp-stat">
                    <span class="lp-stat-value">3</span>
                    <span class="lp-stat-label">Rôles</span>
                </div>
                <div class="lp-stat">
                    <span class="lp-stat-value">100%</span>
                    <span class="lp-stat-label">Numérique</span>
                </div>
                <div class="lp-stat">
                    <span class="lp-stat-value">EST</span>
                    <span class="lp-stat-label">Oujda</span>
                </div>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="lp-right">
            <div class="lp-card">
                <div class="lp-card-header">
                    <div class="lp-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>
                        </svg>
                    </div>
                    <span class="lp-card-tag">Chef de département</span>
                </div>
                <div class="lp-card-title">Pilotez votre département</div>
                <div class="lp-card-desc">Gérez filières, modules et enseignants. Consultez les statistiques et suivez les réclamations.</div>
            </div>

            <div class="lp-card lp-card--accent">
                <div class="lp-card-header">
                    <div class="lp-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                        </svg>
                    </div>
                    <span class="lp-card-tag">Enseignant</span>
                </div>
                <div class="lp-card-title">Gérez vos modules</div>
                <div class="lp-card-desc">Saisissez les notes, générez les PV officiels en PDF et traitez les réclamations.</div>
            </div>

            <div class="lp-card">
                <div class="lp-card-header">
                    <div class="lp-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                            <path d="M16 3.13a4 4 0 010 7.75"/>
                        </svg>
                    </div>
                    <span class="lp-card-tag">Étudiant</span>
                </div>
                <div class="lp-card-title">Suivez vos résultats</div>
                <div class="lp-card-desc">Consultez vos notes par module et signalez une erreur de notation facilement.</div>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="lp-footer">
        <span>&copy; {{ date('Y') }} École Supérieure de Technologie — Oujda</span>
        <span class="lp-footer-dot"></span>
        <span>Université Mohammed Premier</span>
    </footer>

</body>
</html>