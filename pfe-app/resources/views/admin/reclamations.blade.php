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
    <title>Réclamations</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css', 'resources/js/admin/admin.js'])
</head>

<body>
    @php $user = Auth::user(); @endphp

    @include('layouts.sidebar-admin')

    <div class="layout">
        <div class="main" id="main-content">
            @include('layouts.topbar', ['title' => 'Réclamations'])

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
                            <div class="card-title">Toutes les réclamations</div>
                            <div class="card-sub">
                                @if(isset($pendingCount) && $pendingCount > 0)
                                    <span style="color:var(--gold);font-weight:500;">{{ $pendingCount }} en attente</span>
                                @else
                                    Toutes traitées
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="table-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Étudiant</th>
                                    <th>Module</th>
                                    <th class="center">Note</th>
                                    <th>Message</th>
                                    <th class="center">Date</th>
                                    <th class="center">Statut</th>
                                    <th class="center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reclamations ?? [] as $rec)
                                    <tr>
                                        <td>
                                            <div class="etu-cell">
                                                <div class="user-avatar-small">
                                                    {{ strtoupper(substr($rec->prenom_etudiant ?? 'E', 0, 1)) }}{{ strtoupper(substr($rec->nom_etudiant ?? 'T', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="etu-name">{{ $rec->prenom_etudiant ?? '' }}
                                                        {{ $rec->nom_etudiant ?? '' }}
                                                    </div>
                                                    <div class="cell-secondary">{{ $rec->cne_etudiant ?? '' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="module-name">{{ $rec->nom_module ?? '' }}</span>
                                            <span class="code-badge">{{ $rec->code_module ?? '' }}</span>
                                        </td>
                                        <td class="center">
                                            @if(isset($rec->note) && $rec->note !== null)
                                                <span
                                                    class="grade-value {{ $rec->note >= 12 ? 'grade-pass' : ($rec->note >= 10 ? 'grade-warn' : 'grade-fail') }}">
                                                    {{ number_format($rec->note, 2) }}
                                                </span>
                                            @else
                                                <span class="grade-empty">—</span>
                                            @endif
                                        </td>
                                        <td class="rec-msg">{{ $rec->message ?? '' }}</td>
                                        <td class="center cell-secondary">
                                            {{ isset($rec->date_reclamation) ? \Carbon\Carbon::parse($rec->date_reclamation)->format('d/m/Y') : '' }}
                                        </td>
                                        <td class="center">
                                            @if(isset($rec->statut) && $rec->statut === 'traitee')
                                                <span class="badge badge-resolved"><span class="badge-dot"></span>Traitée</span>
                                            @else
                                                <span class="badge badge-pending"><span class="badge-dot"></span>En
                                                    attente</span>
                                            @endif
                                        </td>
                                        <td class="center">
                                            <button type="button" class="btn btn-secondary btn-sm btn-voir"
                                                data-id="{{ $rec->id_reclamation }}"
                                                data-etudiant="{{ ($rec->prenom_etudiant ?? '') . ' ' . ($rec->nom_etudiant ?? '') }}"
                                                data-module="{{ $rec->nom_module ?? '' }}"
                                                data-note="{{ $rec->note ?? '' }}" data-message="{{ $rec->message ?? '' }}">
                                                Voir
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty-state">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5">
                                                    <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9" />
                                                    <path d="M13.73 21a2 2 0 01-3.46 0" />
                                                </svg>
                                                Aucune réclamation.
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
    </div>

    {{-- MODAL --}}
    <div class="modal-overlay" id="rec-modal" data-base-url="{{ url('admin/reclamations') }}"
        onclick=" if(event.target===this)closeRecModal()">
        <div class="rec-modal">

            {{-- Header --}}
            <div class="rec-modal-header">
                <div class="rec-modal-header-left">
                    <div class="rec-modal-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                        </svg>
                    </div>
                    <div>
                        <div class="rec-modal-title">Réclamation</div>
                        <div class="rec-modal-sub" id="modal-sub"></div>
                    </div>
                </div>
                <button type="button" class="rec-modal-close" onclick="closeRecModal()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            {{-- Note pill --}}
            <div class="rec-modal-note-row">
                <span class="rec-modal-note-label">Note actuelle</span>
                <span class="rec-modal-note-value" id="modal-note">—</span>
            </div>

            {{-- Message --}}
            <div class="rec-modal-body">
                <div class="rec-modal-section-label">Message de l'étudiant</div>
                <div class="rec-modal-msg" id="modal-msg"></div>

                <form method="POST" action="" id="rec-form">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id_reclamation" id="modal-rec-id">
                    <div class="rec-modal-section-label" style="margin-top:20px;">Votre réponse</div>
                    <textarea name="reponse" rows="3" class="rec-modal-textarea"
                        placeholder="Expliquez votre décision..."></textarea>
                </form>
            </div>

            {{-- Footer --}}
            <div class="rec-modal-footer">
                <button type="button" class="rec-modal-btn-cancel" onclick="closeRecModal()">Fermer</button>
                <button type="submit" form="rec-form" class="rec-modal-btn-submit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Marquer comme traitée
                </button>
            </div>

        </div>
    </div>
</body>

</html>