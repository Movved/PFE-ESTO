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
    <title>Réclamations</title>
    @vite(['resources/css/app.css', 'resources/css/enseignant/dashboard.css', 'resources/js/app.js'])
    <style>
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

        /* Note row */
        .modal-note-row {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 16px; padding: 12px;
            background-color: #f9fafb; border-radius: 6px;
        }
        .dark .modal-note-row { background-color: #111827; }

        /* Message étudiant */
        .modal-msg-box {
            background-color: #f9fafb;
            padding: 12px; border-radius: 6px;
            margin-bottom: 16px; font-size: 14px;
            border-left: 3px solid #3b82f6;
        }
        .dark .modal-msg-box { background-color: #111827; border-left-color: #60a5fa; }

        /* Réponse existante (traitée) */
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

        /* Textarea */
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
        .modal-textarea.error { border-color: #ef4444; }
        .dark .modal-textarea {
            background-color: #374151; border-color: #4b5563; color: #f3f4f6;
        }
        .dark .modal-textarea:focus { border-color: #60a5fa; }

        /* Compteur de caractères */
        .char-counter {
            font-size: 12px; color: #9ca3af;
            text-align: right; margin-top: 4px;
        }
        .char-counter.warn { color: #f59e0b; }
        .char-counter.limit { color: #ef4444; }

        /* Message d'erreur validation */
        .field-error {
            font-size: 12px; color: #ef4444;
            margin-top: 4px; display: none;
        }
        .field-error.show { display: block; }

        /* Séparateur section */
        .section-label {
            font-size: 13px; font-weight: 500;
            color: var(--text-secondary, #6b7280);
            margin-bottom: 6px;
        }

        /* Boutons */
        .btn {
            padding: 8px 16px; border-radius: 6px;
            font-size: 14px; font-weight: 500;
            cursor: pointer; border: none;
        }
        .btn-primary { background-color: #3b82f6; color: white; }
        .btn-primary:hover { background-color: #2563eb; }
        .btn-primary:disabled { background-color: #93c5fd; cursor: not-allowed; }
        .btn-secondary { background-color: #e5e7eb; color: #374151; }
        .btn-secondary:hover { background-color: #d1d5db; }
        .dark .btn-secondary { background-color: #4b5563; color: #f3f4f6; }

        /* Grades */
        .grade-pass { color: #10b981; }
        .grade-warn { color: #f59e0b; }
        .grade-fail { color: #ef4444; }

        /* Badge statut */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 999px;
            font-size: 12px; font-weight: 500;
        }
        .badge-dot { width: 6px; height: 6px; border-radius: 50%; }
        .badge-resolved { background-color: #d1fae5; color: #065f46; }
        .badge-resolved .badge-dot { background-color: #10b981; }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .badge-pending .badge-dot { background-color: #f59e0b; }
        .dark .badge-resolved { background-color: #064e3b; color: #6ee7b7; }
        .dark .badge-pending  { background-color: #451a03; color: #fcd34d; }

        /* Info readonly quand déjà traitée */
        .readonly-notice {
            font-size: 12px; color: #9ca3af;
            font-style: italic; margin-top: 6px;
        }
    </style>
</head>
<body>
    @php $user = Auth::user(); @endphp

    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                    <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"></path>
                </svg>
            </div>
            <span class="sidebar-logo-text">Gestionnaire</span>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('enseignant.dashboard') }}" class="nav-item {{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect></svg>
                Dashboard
            </a>
            <a href="{{ route('enseignant.modules') }}" class="nav-item {{ request()->routeIs('enseignant.modules*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"></path></svg>
                Mes Modules
            </a>
            <a href="{{ route('enseignant.notes') }}" class="nav-item {{ request()->routeIs('enseignant.notes*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path></svg>
                Saisie des Notes
            </a>
            <a href="{{ route('enseignant.reclamations') }}" class="nav-item {{ request()->routeIs('enseignant.reclamations*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 01-3.46 0"></path></svg>
                Réclamations
                @if(isset($pendingCount) && $pendingCount > 0)
                    <span class="nav-badge">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('profile.edit') }}" class="nav-item">
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                Profil
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;font-size:14px;font-family:inherit;color:var(--text-secondary);">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    Déconnexion
                </button>
            </form>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar-small">
                    {{ strtoupper(substr($user->prenom, 0, 1)) }}{{ strtoupper(substr($user->nom, 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ $user->prenom }} {{ $user->nom }}</div>
                    <div class="sidebar-user-role">Enseignant</div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Réclamations des étudiants</span>
            <button class="toggle-btn" id="theme-toggle">
                <span class="toggle-knob"></span>
            </button>
        </header>

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Erreurs de validation (reponse obligatoire) --}}
            @if($errors->any())
                <div class="alert alert-error">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-header-title">Toutes les réclamations</div>
                        <div class="card-header-sub">
                            @if(isset($pendingCount) && $pendingCount > 0)
                                <span style="color:var(--warning);font-weight:500;">{{ $pendingCount }} en attente</span>
                            @else
                                Toutes traitées
                            @endif
                        </div>
                    </div>
                </div>

                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Etudiant</th>
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
                                        <div class="user-avatar-small" style="width:28px;height:28px;font-size:11px;">
                                            {{ strtoupper(substr($rec->prenom_etudiant ?? 'E', 0, 1)) }}{{ strtoupper(substr($rec->nom_etudiant ?? 'T', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-size:14px;font-weight:500;">{{ $rec->prenom_etudiant ?? '' }} {{ $rec->nom_etudiant ?? '' }}</div>
                                            <div style="font-size:12px;color:var(--text-secondary);">{{ $rec->cne_etudiant ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="module-name">{{ $rec->nom_module ?? '' }}</span><br>
                                    <span class="code-badge">{{ $rec->code_module ?? '' }}</span>
                                </td>
                                <td class="center">
                                    @if(isset($rec->note) && $rec->note !== null)
                                        <span class="grade-value {{ $rec->note >= 12 ? 'grade-pass' : ($rec->note >= 10 ? 'grade-warn' : 'grade-fail') }}">
                                            {{ number_format($rec->note, 2) }}
                                        </span>
                                    @else
                                        <span class="grade-empty">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="rec-msg" title="{{ $rec->message ?? '' }}">{{ $rec->message ?? '' }}</div>
                                </td>
                                <td class="center">
                                    <span style="font-size:13px;color:var(--text-secondary);">
                                        {{ isset($rec->date_reclamation) ? \Carbon\Carbon::parse($rec->date_reclamation)->format('d/m/Y') : '' }}
                                    </span>
                                </td>
                                <td class="center">
                                    @if(isset($rec->traite) && $rec->traite)
                                        <span class="badge badge-resolved"><span class="badge-dot"></span>Traitée</span>
                                    @else
                                        <span class="badge badge-pending"><span class="badge-dot"></span>En attente</span>
                                    @endif
                                </td>
                                <td class="center">
                                    <button type="button" class="btn-voir"
                                        data-id="{{ $rec->id_reclamation }}"
                                        data-etudiant="{{ ($rec->prenom_etudiant ?? '').' '.($rec->nom_etudiant ?? '') }}"
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
                                        <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 01-3.46 0"></path></svg>
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

    <!-- ===== MODAL ===== -->
    <div class="modal-overlay" id="rec-modal">
        <div class="modal">
            <!-- En-tête -->
            <div class="modal-header">
                <div>
                    <div class="modal-title">Détail de la réclamation</div>
                    <div class="modal-sub" id="modal-sub"></div>
                </div>
                <button type="button" class="modal-close" id="modal-close-btn">&times;</button>
            </div>

            <!-- Corps -->
            <div class="modal-body">

                {{-- Note actuelle --}}
                <div class="modal-note-row">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg>
                    <span style="font-size:13px;color:var(--text-secondary);">Note actuelle :&nbsp;</span>
                    <span id="modal-note" style="font-size:14px;font-weight:600;"></span>
                </div>

                {{-- Message de l'étudiant --}}
                <div class="section-label">Message de l'étudiant</div>
                <div id="modal-msg" class="modal-msg-box"></div>

                {{-- Réponse existante (visible uniquement si déjà traitée) --}}
                <div id="modal-reponse-existante" style="display:none;">
                    <div class="modal-reponse-label">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        Réponse envoyée
                    </div>
                    <div id="modal-reponse-text" class="modal-reponse-box"></div>
                </div>

                {{-- Formulaire de réponse (visible uniquement si PAS encore traitée) --}}
                <div id="modal-form-section">
                    <form method="POST" action="" id="rec-form">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="id_reclamation" id="modal-rec-id">

                        <div style="display:flex;flex-direction:column;gap:4px;">
                            <label class="section-label" for="modal-reponse-input">
                                Motif / Réponse au reclamation
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
                                <span class="field-error" id="reponse-error">Veuillez saisir un motif (au moins 5 caractères).</span>
                                <span class="char-counter" id="char-counter">0 / 1000</span>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <!-- Pied -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modal-fermer-btn">Fermer</button>
                <button type="button" class="btn btn-primary" id="modal-submit-btn">
                    ✓ Marquer comme traitée
                </button>
            </div>
        </div>
    </div>

    <script>
    var reclamationsBaseUrl = '{{ url("enseignant/reclamations") }}';

    // ── Thème ──────────────────────────────────────────────────────────
    function toggleTheme() {
        document.documentElement.classList.toggle('dark');
        document.getElementById('theme-toggle')?.classList.toggle('on');
        localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
    }
    if (localStorage.getItem('theme') === 'dark') {
        document.getElementById('theme-toggle')?.classList.add('on');
    }
    document.getElementById('theme-toggle')?.addEventListener('click', toggleTheme);

    // ── Éléments du modal ──────────────────────────────────────────────
    var modal          = document.getElementById('rec-modal');
    var textarea       = document.getElementById('modal-reponse-input');
    var charCounter    = document.getElementById('char-counter');
    var reponseError   = document.getElementById('reponse-error');
    var submitBtn      = document.getElementById('modal-submit-btn');
    var formSection    = document.getElementById('modal-form-section');
    var reponseExist   = document.getElementById('modal-reponse-existante');

    // ── Compteur de caractères ─────────────────────────────────────────
    textarea.addEventListener('input', function() {
        var len = this.value.length;
        charCounter.textContent = len + ' / 1000';
        charCounter.classList.toggle('warn',  len >= 800 && len < 1000);
        charCounter.classList.toggle('limit', len >= 1000);

        // Masquer l'erreur dès que l'utilisateur saisit assez
        if (len >= 5) {
            textarea.classList.remove('error');
            reponseError.classList.remove('show');
        }
    });

    // ── Ouverture du modal ─────────────────────────────────────────────
    document.querySelectorAll('.btn-voir').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id       = this.dataset.id;
            var etudiant = this.dataset.etudiant;
            var module   = this.dataset.module;
            var note     = this.dataset.note;
            var message  = this.dataset.message;
            var traite   = this.dataset.traite === '1';
            var reponse  = this.dataset.reponse;

            // En-tête
            document.getElementById('modal-sub').textContent = etudiant + ' — ' + module;

            // Note
            var elNote = document.getElementById('modal-note');
            elNote.classList.remove('grade-pass', 'grade-warn', 'grade-fail');
            if (note !== '' && !isNaN(parseFloat(note))) {
                var v = parseFloat(note);
                elNote.textContent = v.toFixed(2) + ' / 20';
                elNote.classList.add(v >= 12 ? 'grade-pass' : (v >= 10 ? 'grade-warn' : 'grade-fail'));
            } else {
                elNote.textContent = 'Non noté';
            }

            // Message étudiant
            document.getElementById('modal-msg').textContent = message || 'Aucun message';

            // Action du formulaire
            document.getElementById('rec-form').action = reclamationsBaseUrl + '/' + id + '/traiter';
            document.getElementById('modal-rec-id').value = id;

            // Reset textarea & erreurs
            textarea.value = '';
            textarea.classList.remove('error');
            reponseError.classList.remove('show');
            charCounter.textContent = '0 / 1000';
            charCounter.classList.remove('warn', 'limit');

            if (traite) {
                // Réclamation déjà traitée : afficher la réponse, masquer le formulaire
                document.getElementById('modal-reponse-text').textContent = reponse || '(aucune réponse enregistrée)';
                reponseExist.style.display = 'block';
                formSection.style.display  = 'none';
                submitBtn.style.display    = 'none';
            } else {
                // En attente : montrer le formulaire
                reponseExist.style.display = 'none';
                formSection.style.display  = 'block';
                submitBtn.style.display    = 'inline-flex';
            }

            modal.classList.add('open');
            if (!traite) {
                setTimeout(function() { textarea.focus(); }, 100);
            }
        });
    });

    // ── Soumission avec validation côté client ─────────────────────────
    submitBtn.addEventListener('click', function() {
        var val = textarea.value.trim();
        if (val.length < 5) {
            textarea.classList.add('error');
            reponseError.classList.add('show');
            textarea.focus();
            return;
        }
        // Tout est bon : soumettre le formulaire
        document.getElementById('rec-form').submit();
    });

    // ── Fermeture du modal ─────────────────────────────────────────────
    function closeModal() {
        modal.classList.remove('open');
    }

    document.getElementById('modal-close-btn').addEventListener('click', closeModal);
    document.getElementById('modal-fermer-btn').addEventListener('click', closeModal);

    modal.addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });
    </script>
</body>
</html>