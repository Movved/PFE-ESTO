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
    <title>Mes Modules</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/enseignant/enseignant.css', 'resources/js/enseignant/enseignant.js'])
</head>

<body>
    @include('layouts.sidebar-enseignant')

    <div class="layout">
        <div class="main" id="main-content">
            @include('layouts.topbar', ['title' => 'Mes Modules'])

            <main class="content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round">
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
                            <div class="card-title">Tous vos modules</div>
                            <div class="card-sub">Cliquez sur un module pour voir les détails</div>
                        </div>
                    </div>
                    <div class="modules-grid">
                        @forelse($modules ?? [] as $module)
                            <a href="{{ route('enseignant.module.show', $module->id_module) }}" class="module-card">
                                <div class="module-card-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                                    </svg>
                                </div>
                                <div class="module-card-body">
                                    <div class="module-card-name">{{ $module->nom_module }}</div>
                                    <span class="code-badge">{{ $module->code_module }}</span>
                                    <div class="module-card-meta">Semestre {{ $module->semestre_numero }} ·
                                        {{ $module->annee_libelle }}</div>
                                    <div class="module-card-meta">{{ $module->nom_filiere }}</div>
                                </div>
                                <div class="module-card-count">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                    </svg>
                                    {{ $module->nb_etudiants ?? 0 }} étudiant(s)
                                </div>
                            </a>
                        @empty
                            <div class="empty-state" style="grid-column:1/-1;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                                </svg>
                                Aucun module assigné pour le moment.
                            </div>
                        @endforelse
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>