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

    {{-- SIDEBAR --}}
    @include('layouts.sidebar-etudiant')

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