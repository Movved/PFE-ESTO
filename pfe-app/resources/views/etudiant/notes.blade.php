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
    <title>Mes Notes</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/etudiant/etudiant.css', 'resources/js/etudiant/etudiant.js'])
</head>

<body>
    @include('layouts.sidebar-etudiant')
    <div class="sb-tooltip" id="sb-tooltip"></div>

    <div class="main" id="main-content">
        @include('layouts.topbar', [
            'title'             => 'Mes Notes',
            'search'            => true,
            'searchPlaceholder' => 'Rechercher une note...',
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

            @if(session('error'))
                <div class="alert alert-error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/>
                        <line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-title">Résultats académiques</div>
                        <div class="card-sub">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                    </div>
                </div>
                <div class="table-scroll">
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
                            @forelse($notes ?? collect() as $row)
                                <tr>
                                    <td class="module-name">{{ $row->nom_module }}</td>
                                    <td><span class="code-badge">{{ $row->code_module }}</span></td>
                                    <td class="center">
                                        @if($row->note !== null)
                                            <span class="grade-value {{ $row->note >= 12 ? 'grade-pass' : ($row->note >= 10 ? 'grade-warn' : 'grade-fail') }}">
                                                {{ number_format($row->note, 2) }}
                                            </span>
                                        @else
                                            <span class="grade-empty">—</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        @if($row->rattrapage !== null)
                                            <span class="grade-value {{ $row->rattrapage >= 12 ? 'grade-pass' : ($row->rattrapage >= 10 ? 'grade-warn' : 'grade-fail') }}">
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
                                        @else
                                            <span class="badge-none">—</span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        @if($row->id_note && !$row->has_reclamation && $row->note !== null)
                                            <button class="btn btn-signal signaler-btn"
                                                data-note-id="{{ $row->id_note }}"
                                                data-note-name="{{ $row->nom_module }}">
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
                                                <path d="M9 11l3 3L22 4"/>
                                                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
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
    <div class="modal-overlay" id="modal">
        <div class="modal">
            <div class="modal-header">
                <div>
                    <div class="modal-title">Signaler une erreur</div>
                </div>
                <button class="modal-close" id="modal-close-btn">&times;</button>
            </div>
            <div class="modal-sub" id="modal-label"></div>
            <form method="POST" action="{{ route('etudiant.reclamation.store') }}">
                @csrf
                <input type="hidden" name="id_note" id="modal-id-note">
                <div class="modal-body">
                    <textarea name="message" rows="4" required placeholder="Décrivez l'erreur constatée..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="modal-cancel-btn">Annuler</button>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            var overlay = document.getElementById('modal');

            function openModal(id, nom) {
                document.getElementById('modal-id-note').value = id;
                document.getElementById('modal-label').textContent = nom;
                overlay.classList.add('open');
            }

            function closeModal() {
                overlay.classList.remove('open');
            }

            // Open — delegated, catches all .signaler-btn clicks
            document.addEventListener('click', function (e) {
                var btn = e.target.closest('.signaler-btn');
                if (btn) {
                    openModal(btn.dataset.noteId, btn.dataset.noteName);
                    return;
                }
                // Close via X or Cancel buttons
                if (e.target.closest('#modal-close-btn') || e.target.closest('#modal-cancel-btn')) {
                    closeModal();
                    return;
                }
                // Close by clicking the overlay backdrop
                if (e.target === overlay) {
                    closeModal();
                }
            });

            // Close on Escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeModal();
            });
        })();
    </script>
</body>
</html>