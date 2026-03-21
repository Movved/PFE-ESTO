/* ============================================================
   ENSEIGNANT — role-specific JavaScript
   Shared logic (theme, sidebar, topbar search) is in app.js
   ============================================================ */

/* ─── RÉCLAMATIONS MODAL ─────────────────────────── */
(function () {
    const modal = document.getElementById('rec-modal');
    if (!modal) return;

    const reclamationsBaseUrl = modal.dataset.baseUrl || (window.location.origin + '/enseignant/reclamations');

    document.querySelectorAll('.btn-voir').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id       = this.dataset.id;
            const etudiant = this.dataset.etudiant;
            const module   = this.dataset.module;
            const note     = this.dataset.note;
            const message  = this.dataset.message;

            document.getElementById('modal-sub').textContent = etudiant + ' — ' + module;
            document.getElementById('modal-msg').textContent = message || 'Aucun message';
            document.getElementById('modal-rec-id').value    = id;
            document.getElementById('rec-form').action = modal.dataset.baseUrl + '/' + id + '/traiter';

            const el = document.getElementById('modal-note');
            el.classList.remove('grade-pass', 'grade-warn', 'grade-fail');
            if (note !== '' && !isNaN(parseFloat(note))) {
                const v = parseFloat(note);
                el.textContent = v.toFixed(2) + ' / 20';
                el.classList.add(v >= 12 ? 'grade-pass' : (v >= 10 ? 'grade-warn' : 'grade-fail'));
            } else {
                el.textContent = 'Non noté';
            }

            modal.classList.add('open');
        });
    });

    window.closeRecModal = function () {
        modal.classList.remove('open');
    };

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeRecModal();
    });
})();

/* ─── PV — PDF DOWNLOAD ──────────────────────────── */
window.downloadPDF = function () {
    const btn = document.getElementById('pdf-btn');
    if (!btn) return;

    btn.disabled = true;
    btn.textContent = 'Génération…';

    const moduleName = document.querySelector('.pv-center-title') ? 'module' : 'pv';
    const date = new Date().toISOString().slice(0, 10);

    html2pdf()
        .set({
            margin:      [12, 12, 12, 12],
            filename:    'PV_' + moduleName + '_' + date + '.pdf',
            image:       { type: 'jpeg', quality: 0.97 },
            html2canvas: { scale: 2, useCORS: true },
            jsPDF:       { unit: 'mm', format: 'a4', orientation: 'portrait' }
        })
        .from(document.getElementById('pv-document'))
        .save()
        .finally(function () {
            btn.disabled = false;
            btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Télécharger PDF';
        });
};

// Search bar
// Student search (notes-form.blade.php)
window.filterStudents = function (val) {
    const q = val.toLowerCase();
    const rows = document.querySelectorAll('#students-tbody tr[data-nom]');
    let visible = 0;

    rows.forEach(row => {
        const match = row.dataset.nom.includes(q) ||
                      row.dataset.prenom.includes(q) ||
                      row.dataset.cne.includes(q);
        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });

    const noResults = document.getElementById('no-results-row');
    if (noResults) noResults.style.display = visible === 0 ? '' : 'none';

    const count = document.getElementById('search-count');
    if (count) count.textContent = q ? `${visible} résultat(s)` : '';

    const clear = document.getElementById('search-clear');
    if (clear) clear.style.display = val ? '' : 'none';
};

window.clearSearch = function () {
    const input = document.getElementById('student-search');
    if (input) {
        input.value = '';
        window.filterStudents('');
        input.focus();
    }
};
