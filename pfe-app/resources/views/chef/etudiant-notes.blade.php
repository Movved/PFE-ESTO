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
    <title>Notes de l'étudiant</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/chef/chef.css', 'resources/js/chef/chef.js'])
</head>

<body>
    @include('layouts.sidebar-chef')

    <div class="main" id="main-content">
        @include('layouts.topbar', ['title' => 'Notes de l\'étudiant'])

        <main class="content">

            {{-- Back --}}
            <a href="{{ route('chef.etudiants') }}" class="module-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Retour aux étudiants
            </a>

            {{-- Student banner --}}
            <div class="student-banner">
                <div class="student-avatar">
                    {{ strtoupper(substr($etudiant->prenom, 0, 1)) }}{{ strtoupper(substr($etudiant->nom, 0, 1)) }}
                </div>
                <div>
                    <div class="student-name">{{ $etudiant->prenom }} {{ $etudiant->nom }}</div>
                    <div class="student-meta">
                        <span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="5" width="20" height="14" rx="2" />
                                <path d="M16 10h.01M12 10h.01M8 10h.01" />
                            </svg>
                            CNE : {{ $etudiant->cne }}
                        </span>
                        <span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                            {{ $etudiant->email }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Mini stats --}}
            @php
                $noteFinales = $notes->map(fn($n) => $n->rattrapage ?? $n->note);
                $moyenne = $noteFinales->count() ? round($noteFinales->avg(), 2) : null;
                $rattrapages = $notes->filter(fn($n) => $n->rattrapage !== null)->count();
            @endphp
            <div class="stats-row">
                <div class="stat-mini">
                    <div class="stat-mini-label">Modules évalués</div>
                    <div class="stat-mini-value">{{ $notes->count() }}</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-label">Moyenne générale</div>
                    <div
                        class="stat-mini-value {{ $moyenne !== null && $moyenne >= 10 ? 'grade-pass' : 'grade-fail' }}">
                        {{ $moyenne ?? '—' }}
                    </div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-label">Rattrapages passés</div>
                    <div class="stat-mini-value {{ $rattrapages > 0 ? 'grade-warn' : '' }}">{{ $rattrapages }}</div>
                </div>
            </div>

            {{-- Notes table --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-title">Relevé de notes</div>
                        <div class="card-sub">Tous les modules du département</div>
                    </div>
                </div>
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th>Filière</th>
                                <th>Semestre</th>
                                <th class="center">Note</th>
                                <th class="center">Rattrapage</th>
                                <th class="center">Note finale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notes as $n)
                                @php
                                    $finale = $n->rattrapage ?? $n->note;
                                    $finaleClass = $finale >= 12 ? 'grade-pass' : ($finale >= 10 ? 'grade-warn' : 'grade-fail');
                                @endphp
                                <tr>
                                    <td>
                                        <div class="module-name">{{ $n->nom_module }}</div>
                                        <span class="code-badge">{{ $n->code_module }}</span>
                                    </td>
                                    <td class="cell-secondary">{{ $n->nom_filiere }}</td>
                                    <td class="cell-secondary">S{{ $n->semestre_numero }}</td>
                                    <td class="center">
                                        <span class="grade-value {{ $n->note >= 10 ? 'grade-pass' : 'grade-fail' }}">
                                            {{ number_format($n->note, 2) }}
                                        </span>
                                    </td>
                                    <td class="center">
                                        @if($n->rattrapage !== null)
                                            <span class="rattrapage-badge">{{ number_format($n->rattrapage, 2) }}</span>
                                        @else
                                            <span class="grade-empty">—</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        <span class="grade-value {{ $finaleClass }}">{{ number_format($finale, 2) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                                            </svg>
                                            Aucune note enregistrée pour cet étudiant.
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
</body>

</html>