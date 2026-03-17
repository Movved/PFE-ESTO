<!DOCTYPE html>
<html lang="fr">

<head>
    <script>if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie des notes</title>
    @vite(['resources/css/app.css', 'resources/css/enseignant/dashboard.css', 'resources/js/app.js'])
</head>

<body>
    {{-- SIDEBAR --}}
    @include('layouts.sidebar-enseignant')
    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Saisie des notes</span>
            <button class="toggle-btn" id="theme-toggle" onclick="toggleTheme()"><span
                    class="toggle-knob"></span></button>
        </header>
        <main class="content">
            @if(session('success'))
                <div class="alert alert-success"><svg viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
            </svg>{{ session('success') }}</div>@endif
            @if(session('error'))
                <div class="alert alert-error"><svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="15" y1="9" x2="9" y2="15" />
                        <line x1="9" y1="9" x2="15" y2="15" />
            </svg>{{ session('error') }}</div>@endif
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-header-title">Choisir un module</div>
                        <div class="card-header-sub">Saisir les notes puis générer le PV (procès-verbal)</div>
                    </div>
                </div>
                <div class="modules-grid">
                    @forelse($modules ?? [] as $m)
                        <a href="{{ route('enseignant.notes.form', $m->id_module) }}" class="module-card">
                            <div class="module-card-icon"><svg viewBox="0 0 24 24">
                                    <path d="M9 11l3 3L22 4" />
                                    <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
                                </svg></div>
                            <div class="module-card-body">
                                <div class="module-card-name">{{ $m->nom_module }}</div>
                                <div class="module-card-code">{{ $m->code_module }}</div>
                                <div class="module-card-meta">Sem. {{ $m->semestre_numero }} · {{ $m->annee_libelle }} ·
                                    {{ $m->nom_filiere }}</div>
                            </div>
                            <div class="module-card-count"><svg viewBox="0 0 24 24">
                                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                </svg>{{ $m->nb_etudiants ?? 0 }} étudiant(s)</div>
                        </a>
                    @empty
                        <div class="empty-state" style="grid-column:1/-1;">Aucun module assigné.</div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
    <script>function toggleTheme() { var h = document.documentElement, b = document.getElementById('theme-toggle'); h.classList.toggle('dark'); b.classList.toggle('on'); localStorage.setItem('theme', h.classList.contains('dark') ? 'dark' : 'light'); } if (localStorage.getItem('theme') === 'dark') document.getElementById('theme-toggle').classList.add('on');</script>
</body>

</html>