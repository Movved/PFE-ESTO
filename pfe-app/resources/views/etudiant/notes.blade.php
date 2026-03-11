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
    <title>Mes Notes</title>
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
            <a href="{{ route('etudiant.dashboard') }}"
                class="nav-item {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" />
                    <rect x="14" y="3" width="7" height="7" />
                    <rect x="3" y="14" width="7" height="7" />
                    <rect x="14" y="14" width="7" height="7" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('etudiant.notes') }}"
                class="nav-item {{ request()->routeIs('etudiant.notes') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24">
                    <path d="M9 11l3 3L22 4" />
                    <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
                </svg>
                Mes Notes
            </a>
            <a href="{{ route('etudiant.cours') }}"
                class="nav-item {{ request()->routeIs('etudiant.cours') ? 'active' : '' }}">
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
                                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79" />
                            </svg>
                            <span id="theme-label">Mode sombre</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Mes Notes</span>

            <div class="topbar-search">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" placeholder="Rechercher une note..." id="search-input" oninput="filterTable()"
                    style="border:none; background:transparent; font-size:13px; font-family:inherit; color:var(--text-primary); outline:none; width:100%; padding:0;" />
            </div>

            <div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
                <span id="topbar-time"
                    style="font-size:14px; font-weight:600; color:var(--text-primary); font-family:'SF Mono','Fira Code',monospace;"></span>
                <span id="topbar-date" style="font-size:11px; color:var(--text-secondary);"></span>
            </div>
        </header>

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="15" y1="9" x2="9" y2="15" />
                        <line x1="9" y1="9" x2="15" y2="15" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-header-title">Résultats académiques</div>
                        <div class="card-header-sub">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                    </div>
                </div>
                <div style="overflow-x: auto;">
                    <table id="notes-table">
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th>Code</th>
                                <th class="center">Note</th>
                                <th class="center">Rattrapage</th>
                                <th class="center">Statut</th>
                                <th class="center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notes as $row)
                                <tr>
                                    <td>
                                        <span class="module-name">{{ $row->nom_module }}</span>
                                    </td>
                                    <td>
                                        <span class="code-badge">{{ $row->code_module }}</span>
                                    </td>
                                    <td class="center">
                                        @if($row->note !== null)
                                            <span
                                                class="grade-value {{ $row->note >= 12 ? 'grade-pass' : ($row->note >= 10 ? 'grade-warn' : 'grade-fail') }}">
                                                {{ number_format($row->note, 2) }}
                                            </span>
                                        @else
                                            <span class="grade-empty">—</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        @if($row->rattrapage !== null)
                                            <span
                                                class="grade-value {{ $row->rattrapage >= 12 ? 'grade-pass' : ($row->rattrapage >= 10 ? 'grade-warn' : 'grade-fail') }}">
                                                {{ number_format($row->rattrapage, 2) }}
                                            </span>
                                        @else
                                            <span class="grade-empty">—</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        @if($row->has_reclamation)
                                            <span class="badge badge-pending">
                                                <span class="badge-dot"></span>
                                                En attente
                                            </span>
                                        @elseif($row->note !== null)
                                            <span class="badge-none">—</span>
                                        @else
                                            <span class="badge-none">—</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        @if($row->id_note && !$row->has_reclamation && $row->note !== null)
                                            <button class="btn btn-signal"
                                                onclick="openModal({{ $row->id_note }}, '{{ addslashes($row->nom_module) }}')">
                                                Signaler
                                            </button>
                                        @else
                                            <span class="badge-none">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M9 11l3 3L22 4" />
                                                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
                                            </svg>
                                            Aucune note disponible pour le moment.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    {{-- MODAL --}}
    <div class="modal-overlay" id="modal" onclick="closeModalIfOverlay(event)">
        <div class="modal">
            <div class="modal-header">
                <div>
                    <div class="modal-title">Signaler une erreur</div>
                    <div class="modal-sub" id="modal-label"></div>
                </div>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form method="POST" action="{{ route('etudiant.reclamation.store') }}">
                @csrf
                <input type="hidden" name="id_note" id="modal-id-note">
                <div class="modal-body">
                    <textarea name="message" rows="4" required placeholder="Décrivez l'erreur constatée..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Annuler</button>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>