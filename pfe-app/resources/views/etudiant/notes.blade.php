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
    {{-- SIDEBAR --}}
    @include('layouts.sidebar-etudiant')

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