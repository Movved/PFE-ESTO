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
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7" />
                <rect x="14" y="3" width="7" height="7" />
                <rect x="3" y="14" width="7" height="7" />
                <rect x="14" y="14" width="7" height="7" />
            </svg>
            Dashboard
        </a>

        <div class="nav-divider"></div>
        <div class="nav-section-label">Utilisateurs</div>

        <a href="{{ route('admin.etudiants') }}"
            class="nav-item {{ request()->routeIs('admin.etudiants*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M23 21v-2a4 4 0 00-3-3.87" />
                <path d="M16 3.13a4 4 0 010 7.75" />
            </svg>
            Étudiants
        </a>
        <a href="{{ route('admin.enseignants') }}"
            class="nav-item {{ request()->routeIs('admin.enseignants*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                <circle cx="12" cy="7" r="4" />
            </svg>
            Enseignants
        </a>

        <div class="nav-divider"></div>
        <div class="nav-section-label">Structure</div>

        <a href="{{ route('admin.filieres') }}"
            class="nav-item {{ request()->routeIs('admin.filieres*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            Filières
        </a>
        <a href="{{ route('admin.modules') }}"
            class="nav-item {{ request()->routeIs('admin.modules*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
            </svg>
            Modules
        </a>
        <a href="{{ route('admin.semestres') }}"
            class="nav-item {{ request()->routeIs('admin.semestres*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                <line x1="16" y1="2" x2="16" y2="6" />
                <line x1="8" y1="2" x2="8" y2="6" />
                <line x1="3" y1="10" x2="21" y2="10" />
            </svg>
            Semestres
        </a>

        <div class="nav-divider"></div>
        <div class="nav-section-label">Académique</div>

        <a href="{{ route('admin.notes') }}" class="nav-item {{ request()->routeIs('admin.notes*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M9 11l3 3L22 4" />
                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
            </svg>
            Notes
        </a>
        <a href="{{ route('admin.reclamations') }}"
            class="nav-item {{ request()->routeIs('admin.reclamations*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
            Réclamations
            @if(isset($pendingReclamations) && $pendingReclamations > 0)
                <span class="nav-badge">{{ $pendingReclamations }}</span>
            @endif
        </a>
        <a href="{{ route('admin.logs') }}" class="nav-item {{ request()->routeIs('admin.logs') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                <polyline points="14 2 14 8 20 8" />
                <line x1="16" y1="13" x2="8" y2="13" />
                <line x1="16" y1="17" x2="8" y2="17" />
                <polyline points="10 9 9 9 8 9" />
            </svg>
            Logs
        </a>

    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="user-avatar-small">
                {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}{{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                <div class="sidebar-user-role">Administrateur</div>
            </div>
            <div style="position:relative;">
                <button onclick="toggleUserMenu()" class="sidebar-user-more">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="5" r="1" />
                        <circle cx="12" cy="12" r="1" />
                        <circle cx="12" cy="19" r="1" />
                    </svg>
                </button>
                <div id="user-menu"
                    style="display:none; position:fixed; bottom:16px; left:248px; background:var(--surface); border:1px solid var(--border); border-radius:10px; padding:6px; min-width:180px; box-shadow:0 8px 24px rgba(0,0,0,0.12); z-index:1000;">
                    <a href="{{ route('profile.edit') }}"
                        style="display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:6px;font-size:13px;color:var(--text-primary);text-decoration:none;">
                        <svg viewBox="0 0 24 24"
                            style="width:15px;height:15px;stroke:currentColor;stroke-width:1.5;fill:none;stroke-linecap:round;stroke-linejoin:round;">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        Profil
                    </a>
                    <button onclick="toggleThemeFromMenu()"
                        style="display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:6px;font-size:13px;color:var(--text-primary);background:none;border:none;cursor:pointer;width:100%;text-align:left;">
                        <svg viewBox="0 0 24 24"
                            style="width:15px;height:15px;stroke:currentColor;stroke-width:1.5;fill:none;stroke-linecap:round;stroke-linejoin:round;">
                            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                        </svg>
                        <span id="theme-label">Mode sombre</span>
                    </button>
                    <div style="height:1px;background:var(--border);margin:4px 0;"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            style="display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:6px;font-size:13px;color:var(--danger);background:none;border:none;cursor:pointer;width:100%;text-align:left;">
                            <svg viewBox="0 0 24 24"
                                style="width:15px;height:15px;stroke:currentColor;stroke-width:1.5;fill:none;stroke-linecap:round;stroke-linejoin:round;">
                                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</aside>