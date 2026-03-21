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
    <title>Mes Cours</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/etudiant/etudiant.css', 'resources/js/etudiant/etudiant.js'])
</head>

<body>
    @include('layouts.sidebar-etudiant')
    <div class="sb-tooltip" id="sb-tooltip"></div>

    <div class="main" id="main-content">
        @include('layouts.topbar', ['title' => 'Modules'])

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
                <div class="timeline" id="courses-container">
                    @foreach($cours as $semestre => $modules)
                        <div class="timeline-semester" data-semester>
                            {{-- Semester node --}}
                            <div class="timeline-node">
                                <div class="timeline-node-dot">
                                    <span>S{{ $semestre }}</span>
                                </div>
                                <div class="timeline-line"></div>
                            </div>

                            {{-- Modules --}}
                            <div class="timeline-modules">
                                @foreach($modules as $module)
                                    <div class="timeline-card course-card"
                                        data-name="{{ strtolower($module->nom_module) }} {{ strtolower($module->code_module) }} {{ strtolower($module->prof_nom) }} {{ strtolower($module->prof_prenom) }}">

                                        <div class="timeline-card-left">
                                            <div
                                                class="timeline-card-accent {{ $module->cloture ? 'accent-closed' : 'accent-open' }}">
                                            </div>
                                        </div>

                                        <div class="timeline-card-body">
                                            <div class="timeline-card-top">
                                                <div>
                                                    <div class="timeline-card-name">{{ $module->nom_module }}</div>
                                                    <div class="timeline-card-filiere">
                                                        {{ $module->nom_filiere }} · {{ $module->annee }}
                                                    </div>
                                                </div>
                                                <div class="timeline-card-right">
                                                    <span class="code-badge">{{ $module->code_module }}</span>
                                                    <span class="badge {{ $module->cloture ? 'badge-closed' : 'badge-open' }}">
                                                        <span class="badge-dot"></span>
                                                        {{ $module->cloture ? 'Clôturé' : 'En cours' }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="timeline-card-footer">
                                                <div class="timeline-card-prof">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                                        <circle cx="12" cy="7" r="4" />
                                                    </svg>
                                                    {{ $module->prof_prenom }} {{ $module->prof_nom }}
                                                </div>
                                                <div class="timeline-card-spec cell-secondary">
                                                    {{ $module->specialite }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
</body>

</html>