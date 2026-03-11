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
    <title>Mes Cours</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                    <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5" />
                </svg>
            </div>
            <span class="sidebar-logo-text">Gestionnaire</span>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" />
                    <rect x="14" y="3" width="7" height="7" />
                    <rect x="3" y="14" width="7" height="7" />
                    <rect x="14" y="14" width="7" height="7" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.notes') }}"
                class="nav-item {{ request()->routeIs('admin.notes') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24">
                    <path d="M9 11l3 3L22 4" />
                    <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
                </svg>
                Mes Notes
            </a>
            <a href="{{ route('admin.cours') }}"
                class="nav-item {{ request()->routeIs('admin.cours') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24">
                    <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                </svg>
                Mes Cours
            </a>
            <a href="{{ route('profile.edit') }}"
                class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                Profil
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    Déconnexion
                </button>
            </form>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar-small">
                    {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}{{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                    <div class="sidebar-user-role">Étudiant</div>
                </div>


                <div style="position:relative;">
                    <button onclick="toggleUserMenu()" class="sidebar-user-more">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="5" r="1" />
                            <circle cx="12" cy="12" r="1" />
                            <circle cx="12" cy="19" r="1" />
                        </svg>
                    </button>

                    <div id="user-menu">
                        <a href="{{ route('profile.edit') }}">
                            <svg viewBox="0 0 24 24">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Profil
                        </a>

                        <button onclick="toggleThemeFromMenu()">
                            <svg viewBox="0 0 24 24" id="theme-icon">
                                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                            </svg>
                            <span id="theme-label">Mode sombre</span>
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Mes Cours</span>

            <div class="topbar-search">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" placeholder="Rechercher un cours..." id="search-input" oninput="filterCourses()"
                    style="border:none; background:transparent; font-size:13px; font-family:inherit; color:var(--text-primary); outline:none; width:100%; padding:0;" />
            </div>

            <div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
                <span id="topbar-time"
                    style="font-size:14px; font-weight:600; color:var(--text-primary); font-family:'SF Mono','Fira Code',monospace;"></span>
                <span id="topbar-date" style="font-size:11px; color:var(--text-secondary);"></span>
            </div>
        </header>

        <main class="content">

            @if($cours->isEmpty())
                <div class="empty-state">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                    </svg>
                    Aucun cours disponible pour le moment.
                </div>
            @else
                <div id="courses-container">
                    @foreach($cours as $semestre => $modules)
                        <div class="semester-label" data-semester>Semestre {{ $semestre }}</div>
                        <div class="courses-grid">
                            @foreach($modules as $module)
                                <div class="course-card"
                                    data-name="{{ strtolower($module->nom_module) }} {{ strtolower($module->code_module) }} {{ strtolower($module->prof_nom) }} {{ strtolower($module->prof_prenom) }}">
                                    <div class="course-card-top">
                                        <span class="course-code">{{ $module->code_module }}</span>
                                        <span class="course-status {{ $module->cloture ? 'closed' : 'open' }}">
                                            {{ $module->cloture ? 'Clôturé' : 'En cours' }}
                                        </span>
                                    </div>

                                    <div class="course-name">{{ $module->nom_module }}</div>

                                    <div class="course-divider"></div>

                                    <div class="course-meta">
                                        <div class="course-meta-row">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                                <circle cx="12" cy="7" r="4" />
                                            </svg>
                                            <span>{{ $module->prof_prenom }} {{ $module->prof_nom }}</span>
                                        </div>
                                        <div class="course-meta-row">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                                            </svg>
                                            <span>{{ $module->nom_filiere }}</span>
                                        </div>
                                        <div class="course-meta-row">
                                            <svg viewBox="0 0 24 24">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                                <line x1="16" y1="2" x2="16" y2="6" />
                                                <line x1="8" y1="2" x2="8" y2="6" />
                                                <line x1="3" y1="10" x2="21" y2="10" />
                                            </svg>
                                            <span>{{ $module->annee }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
</body>

</html>