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

    // Hide semester labels if all cards in that section are hidden
    document.querySelectorAll('[data-semester]').forEach(label => {
        const grid = label.nextElementSibling;
        if (!grid) return;
        const visible = [...grid.querySelectorAll('.course-card')].some(c => c.style.display !== 'none');
        label.style.display = visible ? '' : 'none';
        grid.style.display  = visible ? '' : 'none';
    });
};