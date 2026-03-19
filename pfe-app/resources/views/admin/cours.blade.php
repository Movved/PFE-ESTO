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
    <title>Modules</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css'])
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="main" id="main-content">
        @include('layouts.topbar', [
            'title'             => 'Modules',
            'search'            => true,
            'searchPlaceholder' => 'Rechercher un module...',
        ])

        <main class="content">
            @if($cours->isEmpty())
                <div class="empty-state">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                    </svg>
                    Aucun cours disponible pour le moment.
                </div>
            @else
                @foreach($cours as $semestre => $modules)
                    <div class="semester-label">Semestre {{ $semestre }}</div>
                    <div class="courses-grid">
                        @foreach($modules as $module)
                            <div class="course-card" data-name="{{ strtolower($module->nom_module) }} {{ strtolower($module->code_module) }} {{ strtolower($module->prof_nom) }} {{ strtolower($module->prof_prenom) }}">
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
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                        <span>{{ $module->prof_prenom }} {{ $module->prof_nom }}</span>
                                    </div>
                                    <div class="course-meta-row">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                                        </svg>
                                        <span>{{ $module->nom_filiere }}</span>
                                    </div>
                                    <div class="course-meta-row">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                            <line x1="16" y1="2" x2="16" y2="6"/>
                                            <line x1="8" y1="2" x2="8" y2="6"/>
                                            <line x1="3" y1="10" x2="21" y2="10"/>
                                        </svg>
                                        <span>{{ $module->annee }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </main>
    </div>
</body>
</html>