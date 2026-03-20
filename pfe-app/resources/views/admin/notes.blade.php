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
    <title>Admin — Notes</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css', 'resources/js/admin/admin.js'])
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="main" id="main-content">
        @include('layouts.topbar', [
            'title'             => 'Notes',
            'search'            => true,
            'searchPlaceholder' => 'Rechercher étudiant ou CNE...',
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
                        <div class="card-title">Gestion des notes</div>
                        <div class="card-sub">{{ $notes->count() }} note(s) enregistrée(s)</div>
                    </div>
                </div>

                {{-- Filter bar --}}
                <form method="GET" style="display:flex;gap:10px;padding:16px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;">
                    <div class="notes-search-inner" style="max-width:280px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" name="search" placeholder="Rechercher étudiant ou CNE..." value="{{ request('search') }}">
                    </div>
                    <div class="form-group" style="margin:0;">
                        <select name="module" style="padding:7px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;background:var(--surface-2);color:var(--text-1);outline:none;min-width:200px;">
                            <option value="">Tous les modules</option>
                            @foreach($modules as $m)
                                <option value="{{ $m->id_module }}" {{ request('module') == $m->id_module ? 'selected' : '' }}>
                                    {{ $m->nom_module }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-secondary btn-sm">Filtrer</button>
                    @if(request('search') || request('module'))
                        <a href="{{ route('admin.notes') }}" class="btn btn-secondary btn-sm">Réinitialiser</a>
                    @endif
                </form>

                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Étudiant</th>
                                <th>CNE</th>
                                <th>Module</th>
                                <th>Code</th>
                                <th class="center">Note</th>
                                <th class="center">Rattrapage</th>
                                <th class="center">Statut</th>
                                <th class="center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notes as $n)
                                <tr>
                                    <td class="etu-name">{{ $n->prenom }} {{ $n->nom }}</td>
                                    <td><span class="code-badge">{{ $n->cne }}</span></td>
                                    <td class="module-name">{{ $n->nom_module }}</td>
                                    <td><span class="code-badge">{{ $n->code_module }}</span></td>
                                    <td class="center">
                                        @if($n->note !== null)
                                            <span class="grade-value {{ $n->note >= 12 ? 'grade-pass' : ($n->note >= 10 ? 'grade-warn' : 'grade-fail') }}">
                                                {{ number_format($n->note, 2) }}
                                            </span>
                                        @else
                                            <span class="grade-empty">—</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        @if($n->rattrapage !== null)
                                            <span class="grade-value {{ $n->rattrapage >= 10 ? 'grade-pass' : 'grade-fail' }}">
                                                {{ number_format($n->rattrapage, 2) }}
                                            </span>
                                        @else
                                            <span class="grade-empty">—</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        @if($n->note === null)
                                            <span class="badge badge-pending"><span class="badge-dot"></span>En attente</span>
                                        @elseif($n->note >= 10 || ($n->rattrapage !== null && $n->rattrapage >= 10))
                                            <span class="badge badge-open"><span class="badge-dot"></span>Validé</span>
                                        @else
                                            <span class="badge badge-closed"><span class="badge-dot"></span>Échoué</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        <a href="{{ route('admin.notes.edit', $n->id_note) }}" class="btn btn-secondary btn-sm">Modifier</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">Aucune note trouvée.</div>
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