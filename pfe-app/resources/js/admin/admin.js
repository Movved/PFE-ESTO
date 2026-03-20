/* ============================================================
   ADMIN style
   ============================================================ */

/* Course/module search filter (cours.blade.php) */
window.filterCourses = function () {
    const q = document.getElementById('search-input')?.value.toLowerCase() || '';
    let anyVisible = false;

    document.querySelectorAll('.course-card').forEach(card => {
        const match = !q || (card.dataset.name || '').includes(q);
        card.style.display = match ? '' : 'none';
        if (match) anyVisible = true;
    });

    document.querySelectorAll('[data-semester]').forEach(label => {
        const grid = label.nextElementSibling;
        if (!grid) return;
        const visible = [...grid.querySelectorAll('.course-card')].some(c => c.style.display !== 'none');
        label.style.display = visible ? '' : 'none';
        grid.style.display  = visible ? '' : 'none';
    });
};

// Reclamations modal
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('rec-modal');
    if (!modal) return;

    document.querySelectorAll('.btn-voir').forEach(btn => {
        btn.addEventListener('click', function () {
            const id       = this.dataset.id;
            const etudiant = this.dataset.etudiant;
            const module   = this.dataset.module;
            const note     = this.dataset.note;
            const message  = this.dataset.message;

            document.getElementById('modal-sub').textContent  = etudiant + ' — ' + module;
            document.getElementById('modal-note').textContent = note ? parseFloat(note).toFixed(2) + ' / 20' : '—';
            document.getElementById('modal-msg').textContent  = message;
            document.getElementById('modal-rec-id').value     = id;
            document.getElementById('rec-form').action        = modal.dataset.baseUrl + '/' + id;

            modal.classList.add('active');
        });
    });
});

window.closeRecModal = function () {
    const modal = document.getElementById('rec-modal');
    if (modal) modal.classList.remove('active');
};