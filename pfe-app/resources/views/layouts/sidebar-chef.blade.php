{{-- CHEF SIDEBAR --}}
<aside class="sb" id="sidebar">

    <div class="sb-header">
        <div class="sb-logo-icon">
            <i class="fi fi-sr-graduation-cap"></i>
        </div>
        <span class="sb-logo-text">Gestionnaire</span>

        {{-- Shown when expanded --}}
        <button class="sb-collapse-btn" onclick="collapseSidebar()" title="Réduire">
            <i class="fi fi-rr-arrow-small-left"></i>
        </button>

        {{-- Shown when collapsed, perfectly centred --}}
        <button class="sb-expand-btn" onclick="expandSidebar()" title="Développer">
            <i class="fi fi-rr-arrow-small-right"></i>
        </button>
    </div>

    <nav class="sb-nav">

        <div class="sb-label">Chef de département</div>

        <a href="{{ route('chef.dashboard') }}" class="sb-item {{ request()->routeIs('chef.dashboard') ? 'active' : '' }}">
            <i class="fi fi-rr-apps icon"></i>
            <span class="sb-item-label">Dashboard</span>
        </a>
        <a href="{{ route('chef.modules') }}" class="sb-item {{ request()->routeIs('chef.modules') ? 'active' : '' }}">
            <i class="fi fi-rr-book-open-cover icon"></i>
            <span class="sb-item-label">Modules</span>
        </a>
        <a href="{{ route('chef.filieres') }}" class="sb-item {{ request()->routeIs('chef.filieres') ? 'active' : '' }}">
            <i class="fi fi-rr-folder icon"></i>
            <span class="sb-item-label">Filières</span>
        </a>
        <a href="{{ route('chef.etudiants') }}" class="sb-item {{ request()->routeIs('chef.etudiants*') ? 'active' : '' }}">
            <i class="fi fi-rr-users icon"></i>
            <span class="sb-item-label">Étudiants</span>
        </a>

        <div class="sb-divider"></div>
        <div class="sb-label">Enseignant</div>

        <a href="{{ route('enseignant.dashboard') }}" class="sb-item {{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}">
            <i class="fi fi-rr-apps icon"></i>
            <span class="sb-item-label">Dashboard</span>
        </a>
        <a href="{{ route('enseignant.modules') }}" class="sb-item {{ request()->routeIs('enseignant.modules*') ? 'active' : '' }}">
            <i class="fi fi-rr-chalkboard-user icon"></i>
            <span class="sb-item-label">Mes Modules</span>
        </a>
        <a href="{{ route('enseignant.notes') }}" class="sb-item {{ request()->routeIs('enseignant.notes*') ? 'active' : '' }}">
            <i class="fi fi-rr-clipboard-list-check icon"></i>
            <span class="sb-item-label">Saisie des Notes</span>
        </a>
        <a href="{{ route('enseignant.reclamations') }}" class="sb-item {{ request()->routeIs('enseignant.reclamations*') ? 'active' : '' }}">
            <i class="fi fi-rr-bell icon"></i>
            <span class="sb-item-label">Réclamations</span>
            @if(isset($pendingCount) && $pendingCount > 0)
                <span class="sb-badge">{{ $pendingCount }}</span>
            @endif
        </a>

    </nav>

    <div class="sb-footer">
        <div class="sb-user">

            <div class="sb-user-menu" id="sb-user-menu" onclick="event.stopPropagation()">
                <a href="{{ route('profile.edit') }}" onclick="closeSbMenu()">
                    <i class="fi fi-rr-user"></i> Profil
                </a>
                <button onclick="toggleTheme()">
                    <i class="fi fi-rr-moon" id="theme-icon-menu"></i>
                    <span id="theme-label">Mode sombre</span>
                </button>
                <hr>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
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
                <div class="sb-user-role">Chef de département</div>
            </div>
            <button class="sb-user-more" onclick="toggleUserMenu(event)">
                <i class="fi fi-rr-menu-dots-vertical"></i>
            </button>

        </div>
    </div>

</aside>

<div class="sb-tooltip" id="sb-tooltip"></div>