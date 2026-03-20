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
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/enseignant/enseignant.css', 'resources/js/enseignant/enseignant.js'])
    <style>
        /* ── Modal overlay ─────────────────────────────────────── */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        .modal-overlay.open { display: flex !important; }

        .modal {
            background-color: white;
            border-radius: 8px;
            max-width: 520px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        .dark .modal { background-color: #1f2937; color: #f3f4f6; }

        .modal-header {
            padding: 16px 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .dark .modal-header { border-bottom-color: #374151; }

        .modal-title { font-size: 18px; font-weight: 600; }
        .modal-sub { font-size: 14px; color: #6b7280; margin-top: 4px; }
        .dark .modal-sub { color: #9ca3af; }

        .modal-close {
            background: none; border: none;
            font-size: 24px; cursor: pointer; color: #6b7280;
            flex-shrink: 0; margin-left: 12px;
        }
        .dark .modal-close { color: #9ca3af; }

        .modal-body { padding: 20px; }

        .modal-footer {
            padding: 16px 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        .dark .modal-footer { border-top-color: #374151; }

        /* ── Note row ──────────────────────────────────────────── */
        .modal-note-row {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 16px; padding: 12px;
            background-color: #f9fafb; border-radius: 6px;
        }
        .dark .modal-note-row { background-color: #111827; }

        /* ── Message étudiant ──────────────────────────────────── */
        .modal-msg-box {
            background-color: #f9fafb;
            padding: 12px; border-radius: 6px;
            margin-bottom: 16px; font-size: 14px;
            border-left: 3px solid #3b82f6;
        }
        .dark .modal-msg-box { background-color: #111827; border-left-color: #60a5fa; }

        /* ── Réponse existante (déjà traitée) ──────────────────── */
        .modal-reponse-box {
            background-color: #f0fdf4;
            padding: 12px; border-radius: 6px;
            margin-bottom: 16px; font-size: 14px;
            border-left: 3px solid #10b981;
        }
        .dark .modal-reponse-box { background-color: #052e16; border-left-color: #10b981; }

        .modal-reponse-label {
            font-size: 13px; font-weight: 500;
            color: #10b981; margin-bottom: 6px;
            display: flex; align-items: center; gap: 6px;
        }

        /* ── Textarea ──────────────────────────────────────────── */
        .modal-textarea {
            width: 100%; padding: 10px;
            border: 1px solid #e5e7eb; border-radius: 6px;
            background-color: white; color: #111827;
            font-size: 14px; resize: vertical;
            font-family: inherit;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }
        .modal-textarea:focus { outline: none; border-color: #3b82f6; }
        .modal-textarea.input-error { border-color: #ef4444; }
        .dark .modal-textarea { background-color: #374151; border-color: #4b5563; color: #f3f4f6; }
        .dark .modal-textarea:focus { border-color: #60a5fa; }

        /* ── Compteur de caractères ────────────────────────────── */
        .char-counter { font-size: 12px; color: #9ca3af; text-align: right; margin-top: 4px; }
        .char-counter.warn  { color: #f59e0b; }
        .char-counter.limit { color: #ef4444; }

        /* ── Erreur de validation ──────────────────────────────── */
        .field-error { font-size: 12px; color: #ef4444; margin-top: 4px; display: none; }
        .field-error.show { display: block; }

        /* ── Section label ─────────────────────────────────────── */
        .section-label {
            font-size: 13px; font-weight: 500;
            color: var(--text-secondary, #6b7280);
            margin-bottom: 6px;
        }
    </style>
</head>

<body>
    @php $user = Auth::user(); @endphp

    @include('layouts.sidebar-enseignant')

    <div class="layout">
        <div class="main" id="main-content">
            @include('layouts.topbar', ['title' => 'Réclamations'])

            <main class="content">

                @if(session('success'))
                    <div class="alert alert-success">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="15" y1="9" x2="9" y2="15" />
                            <line x1="9" y1="9" x2="15" y2="15" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Erreurs de validation Laravel (motif obligatoire) --}}
                @if($errors->any())
                    <div class="alert alert-error">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        {{ $errors->first() }}
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
                                                    <div class="etu-name">{{ $rec->prenom_etudiant ?? '' }} {{ $rec->nom_etudiant ?? '' }}</div>
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
                                                <span class="grade-value {{ $rec->note >= 12 ? 'grade-pass' : ($rec->note >= 10 ? 'grade-warn' : 'grade-fail') }}">
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
                                            @if(isset($rec->traite) && $rec->traite)
                                                <span class="badge badge-resolved"><span class="badge-dot"></span>Traitée</span>
                                            @else
                                                <span class="badge badge-pending"><span class="badge-dot"></span>En attente</span>
                                            @endif
                                        </td>
                                        <td class="center">
                                            <button type="button" class="btn btn-secondary btn-sm btn-voir"
                                                data-id="{{ $rec->id_reclamation }}"
                                                data-etudiant="{{ ($rec->prenom_etudiant ?? '') . ' ' . ($rec->nom_etudiant ?? '') }}"
                                                data-module="{{ $rec->nom_module ?? '' }}"
                                                data-note="{{ $rec->note ?? '' }}"
                                                data-message="{{ $rec->message ?? '' }}"
                                                data-traite="{{ isset($rec->traite) && $rec->traite ? '1' : '0' }}"
                                                data-reponse="{{ $rec->reponse ?? '' }}"
                                            >Voir</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty-state">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
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

    {{-- ===== MODAL ===== --}}
    <div class="modal-overlay" id="rec-modal"
         data-base-url="{{ url('enseignant/reclamations') }}">
        <div class="modal">

            {{-- En-tête --}}
            <div class="modal-header">
                <div>
                    <div class="modal-title">Détail de la réclamation</div>
                    <div class="modal-sub" id="modal-sub"></div>
                </div>
                <button type="button" class="modal-close" onclick="closeRecModal()">&times;</button>
            </div>

            {{-- Corps --}}
            <div class="modal-body">

                {{-- Note actuelle --}}
                <div class="modal-note-row">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                    <span class="cell-secondary">Note actuelle :&nbsp;</span>
                    <span id="modal-note" style="font-size:14px;font-weight:600;"></span>
                </div>

                {{-- Message de l'étudiant --}}
                <div class="section-label">Message de l'étudiant</div>
                <div id="modal-msg" class="modal-msg-box"></div>

                {{-- Réponse existante — visible uniquement si déjà traitée --}}
                <div id="modal-reponse-existante" style="display:none;">
                    <div class="modal-reponse-label">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        Réponse envoyée
                    </div>
                    <div id="modal-reponse-text" class="modal-reponse-box"></div>
                </div>

                {{-- Formulaire — visible uniquement si PAS encore traitée --}}
                <div id="modal-form-section">
                    <form method="POST" action="" id="rec-form">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="id_reclamation" id="modal-rec-id">

                        <div style="display:flex;flex-direction:column;gap:4px;">
                            <label class="section-label" for="modal-reponse-input">
                                Motif / Réponse à la réclamation
                                <span style="color:#ef4444;">*</span>
                            </label>
                            <textarea
                                id="modal-reponse-input"
                                name="reponse"
                                rows="4"
                                maxlength="1000"
                                placeholder="Expliquez votre décision à l'étudiant… (min. 5 caractères)"
                                class="modal-textarea"
                            ></textarea>
                            <div style="display:flex;justify-content:space-between;align-items:center;">
                                <span class="field-error" id="reponse-error">
                                    Veuillez saisir un motif (au moins 5 caractères).
                                </span>
                                <span class="char-counter" id="char-counter">0 / 1000</span>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            {{-- Pied --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeRecModal()">Fermer</button>
                <button type="button" class="btn btn-primary" id="modal-submit-btn">
                    ✓ Marquer comme traitée
                </button>
            </div>

        </div>
    </div>

    <script>
    // ── Fermeture (accessible depuis onclick HTML aussi) ───────────────
    function closeRecModal() {
        document.getElementById('rec-modal').classList.remove('open');
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeRecModal();
    });

    // Clic en dehors du modal
    document.getElementById('rec-modal').addEventListener('click', function (e) {
        if (e.target === this) closeRecModal();
    });

    // ── Références ─────────────────────────────────────────────────────
    var modal        = document.getElementById('rec-modal');
    var textarea     = document.getElementById('modal-reponse-input');
    var charCounter  = document.getElementById('char-counter');
    var reponseError = document.getElementById('reponse-error');
    var submitBtn    = document.getElementById('modal-submit-btn');
    var formSection  = document.getElementById('modal-form-section');
    var reponseExist = document.getElementById('modal-reponse-existante');
    var baseUrl      = modal.dataset.baseUrl;

    // ── Compteur de caractères ─────────────────────────────────────────
    textarea.addEventListener('input', function () {
        var len = this.value.length;
        charCounter.textContent = len + ' / 1000';
        charCounter.classList.toggle('warn',  len >= 800 && len < 1000);
        charCounter.classList.toggle('limit', len >= 1000);
        if (len >= 5) {
            textarea.classList.remove('input-error');
            reponseError.classList.remove('show');
        }
    });

    // ── Ouverture du modal ─────────────────────────────────────────────
    document.querySelectorAll('.btn-voir').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id      = this.dataset.id;
            var traite  = this.dataset.traite === '1';
            var reponse = this.dataset.reponse;
            var note    = this.dataset.note;

            // En-tête
            document.getElementById('modal-sub').textContent =
                this.dataset.etudiant + ' — ' + this.dataset.module;

            // Note colorée
            var elNote = document.getElementById('modal-note');
            elNote.className = '';
            if (note !== '' && !isNaN(parseFloat(note))) {
                var v = parseFloat(note);
                elNote.textContent = v.toFixed(2) + ' / 20';
                elNote.classList.add(v >= 12 ? 'grade-pass' : (v >= 10 ? 'grade-warn' : 'grade-fail'));
            } else {
                elNote.textContent = 'Non noté';
            }

            // Message étudiant
            document.getElementById('modal-msg').textContent =
                this.dataset.message || 'Aucun message';

            // Action du formulaire
            document.getElementById('rec-form').action = baseUrl + '/' + id + '/traiter';
            document.getElementById('modal-rec-id').value = id;

            // Reset textarea & erreurs
            textarea.value = '';
            textarea.classList.remove('input-error');
            reponseError.classList.remove('show');
            charCounter.textContent = '0 / 1000';
            charCounter.classList.remove('warn', 'limit');

            if (traite) {
                // Déjà traitée → lecture seule
                document.getElementById('modal-reponse-text').textContent =
                    reponse || '(aucune réponse enregistrée)';
                reponseExist.style.display = 'block';
                formSection.style.display  = 'none';
                submitBtn.style.display    = 'none';
            } else {
                // En attente → formulaire
                reponseExist.style.display = 'none';
                formSection.style.display  = 'block';
                submitBtn.style.display    = 'inline-flex';
                setTimeout(function () { textarea.focus(); }, 100);
            }

            modal.classList.add('open');
        });
    });

    // ── Soumission avec validation côté client ─────────────────────────
    submitBtn.addEventListener('click', function () {
        var val = textarea.value.trim();
        if (val.length < 5) {
            textarea.classList.add('input-error');
            reponseError.classList.add('show');
            textarea.focus();
            return;
        }
        document.getElementById('rec-form').submit();
    });
    </script>

</body>
</html>