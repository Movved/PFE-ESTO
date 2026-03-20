document.addEventListener('DOMContentLoaded', function () {

    /* ── Live clock ─────────────────────────────── */
    function updateClock() {
        const now    = new Date();
        const timeEl = document.getElementById('topbar-time');
        const dateEl = document.getElementById('topbar-date');
        if (timeEl) timeEl.textContent =
            now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        if (dateEl) dateEl.textContent =
            now.toLocaleDateString('fr-FR', { weekday: 'short', day: 'numeric', month: 'short' });
    }

    updateClock();
    setInterval(updateClock, 1000);

});

/* ── Table search ───────────────────────────────
   Defined outside DOMContentLoaded so it is
   available the moment oninput fires.
   ─────────────────────────────────────────────── */
window.filterTable = function () {
    const q = document.getElementById('search-input')?.value.toLowerCase() || '';
    document.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
};