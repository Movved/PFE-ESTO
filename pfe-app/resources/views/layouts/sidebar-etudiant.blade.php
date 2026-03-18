{{-- ETUDIANT SIDEBAR --}}
<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-rounded/css/uicons-solid-rounded.css">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">


<aside class="sb" id="sidebar">

    <div class="sb-header">
        <div class="sb-logo-icon">
            <i class="fi fi-sr-graduation-cap"></i>
        </div>
        <span class="sb-logo-text">Gestionnaire</span>
        <button class="sb-toggle" onclick="toggleSidebar()">
            <i class="fi fi-rr-menu-burger"></i>
        </button>
    </div>

    <nav class="sb-nav">
        <a href="{{ route('etudiant.dashboard') }}" class="sb-item {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}">
            <i class="fi fi-rr-apps icon"></i>
            <span class="sb-item-label">Dashboard</span>
        </a>
        <a href="{{ route('etudiant.notes') }}" class="sb-item {{ request()->routeIs('etudiant.notes') ? 'active' : '' }}">
            <i class="fi fi-rr-clipboard-list-check icon"></i>
            <span class="sb-item-label">Mes Notes</span>
        </a>
        <a href="{{ route('etudiant.cours') }}" class="sb-item {{ request()->routeIs('etudiant.cours') ? 'active' : '' }}">
            <i class="fi fi-rr-chalkboard-user icon"></i>
            <span class="sb-item-label">Mes Cours</span>
        </a>
    </nav>

    <div class="sb-footer">
        <div class="sb-user">
            <div class="sb-user-menu" id="sb-user-menu" onclick="event.stopPropagation()">
                <a href="{{ route('profile.edit') }}">
                    <i class="fi fi-rr-user"></i> Profil
                </a>
                <button onclick="window.toggleThemeFromMenu && window.toggleThemeFromMenu()">
                    <i class="fi fi-rr-moon" id="theme-icon-menu"></i>
                    <span id="theme-label">Mode sombre</span>
                </button>
                <hr>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="danger">
                        <i class="fi fi-rr-sign-out-alt"></i> Déconnexion
                    </button>
                </form>
            </div>

            <div class="sb-avatar">
                {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}{{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
            </div>
            <div class="sb-user-info">
                <div class="sb-user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                <div class="sb-user-role">Étudiant</div>
            </div>
            <button class="sb-user-more" id="sb-user-btn" onclick="toggleUserMenu(event)">
                <i class="fi fi-rr-menu-dots-vertical"></i>
            </button>
        </div>
    </div>

</aside>

<div class="sb-tooltip" id="sb-tooltip"></div>
