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
    <title>Admin — Réclamations</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css'])
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="main" id="main-content">
        @include('layouts.topbar', [
            'title'             => 'Réclamations',
            'search'            => true,
            'searchPlaceholder' => 'Rechercher une réclamation...',
        ])

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Toutes les réclamations</div>
                        <div class="card-sub">{{ $reclamations->count() }} réclamation(s) soumises par les étudiants</div>
                    </div>
                </div>

                @forelse($reclamations as $r)
                    <div class="rec-item">
                        <div style="flex:1;min-width:0;">
                            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:4px;">
                                <span class="etu-name">{{ $r->prenom }} {{ $r->nom }}</span>
                                <span class="code-badge">{{ $r->cne }}</span>
                                <span class="cell-secondary">→</span>
                                <span class="module-name" style="font-size:13px;">{{ $r->nom_module }}</span>
                                <span class="code-badge">{{ $r->code_module }}</span>
                            </div>
                            <div class="rec-meta">
                                <span>Note :
                                    <span class="grade-value {{ $r->note >= 10 ? 'grade-pass' : 'grade-fail' }}">
                                        {{ $r->note !== null ? number_format($r->note, 2) : '—' }}
                                    </span>
                                </span>
                                @if($r->rattrapage !== null)
                                    <span>Rattrapage :
                                        <span class="grade-value {{ $r->rattrapage >= 10 ? 'grade-pass' : 'grade-fail' }}">
                                            {{ number_format($r->rattrapage, 2) }}
                                        </span>
                                    </span>
                                @endif
                                @if($r->date_reclamation)
                                    <span>{{ \Carbon\Carbon::parse($r->date_reclamation)->format('d/m/Y à H:i') }}</span>
                                @endif
                            </div>
                            <div class="rec-message">{{ $r->message }}</div>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:6px;flex-shrink:0;">
                            <a href="{{ route('admin.reclamations.show', $r->id_reclamation) }}" class="btn btn-secondary btn-sm">
                                Détail
                            </a>
                            <form method="POST" action="{{ route('admin.reclamations.destroy', $r->id_reclamation) }}" onsubmit="return confirm('Supprimer cette réclamation ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 01-3.46 0"/>
                        </svg>
                        Aucune réclamation.
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</body>
</html>