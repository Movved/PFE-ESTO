<!DOCTYPE html>
<html lang="fr">

<head>
    <script>if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie — {{ $module->nom_module }}</title>
    @vite(['resources/css/app.css', 'resources/css/enseignant/dashboard.css', 'resources/js/app.js'])
</head>

<body>
    {{-- SIDEBAR --}}
    @include('layouts.sidebar-enseignant')
    <div class="main">
        <header class="topbar">
            <span class="topbar-title">{{ $module->nom_module }} — Saisie</span>
            <button class="toggle-btn" id="theme-toggle" onclick="toggleTheme()"><span
                    class="toggle-knob"></span></button>
        </header>
        <main class="content">
            @if(session('success'))
                <div class="alert alert-success"><svg viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
            </svg>{{ session('success') }}</div>@endif

            <a href="{{ route('enseignant.notes') }}" class="module-detail-back"><svg viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg> Retour à la liste</a>

            <div class="card" style="margin-bottom:16px;">
                <div class="card-header">
                    <div>
                        <div class="card-header-title">{{ $module->nom_module }}</div>
                        <div class="card-header-sub">{{ $module->code_module }} · {{ $module->nom_filiere }} ·
                            {{ $module->annee_libelle }} — Semestre {{ $module->semestre_numero }}</div>
                    </div>
                    <a href="{{ route('enseignant.notes.pv', $module->id_module) }}" target="_blank"
                        class="btn btn-primary">Générer le PV (PDF)</a>
                </div>
            </div>

            <form method="POST" action="{{ route('enseignant.notes.store', $module->id_module) }}" class="card">
                @csrf
                <div class="card-header">
                    <div>
                        <div class="card-header-title">Notes des étudiants</div>
                        <div class="card-header-sub">Saisir note et rattrapage (sur 20), puis enregistrer.</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer les notes</button>
                </div>

                {{-- Student search bar --}}
                <div style="padding:12px 16px 8px;">
                    <div style="position:relative;max-width:360px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            style="position:absolute;left:10px;top:50%;transform:translateY(-50%);width:15px;height:15px;opacity:.5;pointer-events:none;">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        <input type="text" id="student-search" placeholder="Rechercher par nom, prénom ou CNE…"
                            autocomplete="off" oninput="filterStudents(this.value)"
                            style="width:100%;padding:8px 36px 8px 34px;border:1px solid var(--border);border-radius:8px;font-size:13px;background:var(--bg-card,#fff);color:inherit;outline:none;box-sizing:border-box;transition:border-color .15s;"
                            onfocus="this.style.borderColor='var(--primary,#4f6ef7)'"
                            onblur="this.style.borderColor='var(--border)'">
                        {{-- Clear button --}}
                        <button type="button" id="search-clear" onclick="clearSearch()"
                            style="display:none;position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:2px;line-height:0;opacity:.5;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                style="width:14px;height:14px;">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>
                    </div>
                    <div id="search-count"
                        style="font-size:12px;color:var(--text-secondary);margin-top:5px;min-height:16px;"></div>
                </div>

                <div style="overflow-x:auto;">
                    <table id="students-table">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>CNE</th>
                                <th class="center">Note /20</th>
                                <th class="center">Rattrapage /20</th>
                            </tr>
                        </thead>
                        <tbody id="students-tbody">
                            @foreach($etudiants as $i => $etu)
                                <tr data-nom="{{ strtolower($etu->nom) }}" data-prenom="{{ strtolower($etu->prenom) }}"
                                    data-cne="{{ strtolower($etu->cne) }}">
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $etu->nom }}</td>
                                    <td>{{ $etu->prenom }}</td>
                                    <td><span class="code-badge">{{ $etu->cne }}</span></td>
                                    <td class="center">
                                        <input type="number" name="notes[{{ $etu->id_note }}][note]"
                                            value="{{ $etu->note !== null ? number_format($etu->note, 2, '.', '') : '' }}"
                                            min="0" max="20" step="0.01"
                                            style="width:70px;padding:6px 8px;border:1px solid var(--border);border-radius:6px;font-size:14px;text-align:center;"
                                            placeholder="—">
                                    </td>
                                    <td class="center">
                                        <input type="number" name="notes[{{ $etu->id_note }}][rattrapage]"
                                            value="{{ $etu->rattrapage !== null ? number_format($etu->rattrapage, 2, '.', '') : '' }}"
                                            min="0" max="20" step="0.01"
                                            style="width:70px;padding:6px 8px;border:1px solid var(--border);border-radius:6px;font-size:14px;text-align:center;"
                                            placeholder="—">
                                    </td>
                                </tr>
                            @endforeach

                            {{-- Empty-search state row (hidden by default) --}}
                            <tr id="no-results-row" style="display:none;">
                                <td colspan="6"
                                    style="text-align:center;padding:24px;color:var(--text-secondary);font-style:italic;">
                                    Aucun étudiant ne correspond à votre recherche.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>

            @if($etudiants->isEmpty())
                <div class="empty-state">Aucun étudiant inscrit pour ce module.</div>
            @endif
        </main>
    </div>

    <script>
        // Theme toggle
        function toggleTheme() {
            var h = document.documentElement, b = document.getElementById('theme-toggle');
            h.classList.toggle('dark');
            b.classList.toggle('on');
            localStorage.setItem('theme', h.classList.contains('dark') ? 'dark' : 'light');
        }
        if (localStorage.getItem('theme') === 'dark') document.getElementById('theme-toggle').classList.add('on');

        // Student search
        var totalStudents = document.querySelectorAll('#students-tbody tr[data-nom]').length;

        function filterStudents(query) {
            var q = query.trim().toLowerCase();
            var rows = document.querySelectorAll('#students-tbody tr[data-nom]');
            var visible = 0;

            rows.forEach(function (row) {
                var match = !q
                    || row.dataset.nom.includes(q)
                    || row.dataset.prenom.includes(q)
                    || row.dataset.cne.includes(q);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            // No-results row
            document.getElementById('no-results-row').style.display = (q && visible === 0) ? '' : 'none';

            // Count label
            var countEl = document.getElementById('search-count');
            if (q) {
                countEl.textContent = visible + ' étudiant' + (visible !== 1 ? 's' : '') + ' trouvé' + (visible !== 1 ? 's' : '') + ' sur ' + totalStudents;
            } else {
                countEl.textContent = '';
            }

            // Clear button visibility
            document.getElementById('search-clear').style.display = q ? 'block' : 'none';
        }

        function clearSearch() {
            var input = document.getElementById('student-search');
            input.value = '';
            input.focus();
            filterStudents('');
        }
    </script>
</body>

</html>