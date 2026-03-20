import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import './sidebar.js';
import './topbar.js';

// Called from onclick="toggleTheme()" in blade templates
window.toggleTheme = function () {
    applyTheme(!document.documentElement.classList.contains('dark'));
};

// Apply immediately on every page load
(function () {
    const saved = localStorage.getItem('theme');
    // Default to dark if nothing saved
    applyTheme(saved === null ? true : saved === 'dark');
})();

/* ============================================================
   TOPBAR SEARCH — universal table filter
   ============================================================ */
(function () {
    const input = document.getElementById('search-input');
    if (!input) return;

    window.filterTable = function () {
        const q = input.value.trim().toLowerCase();
        const rows = document.querySelectorAll('tbody tr:not(#no-results-row)');
        let visible = 0;

        rows.forEach(function (row) {
            const text = row.innerText.toLowerCase();
            const match = !q || text.includes(q);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        const noResults = document.getElementById('no-results-row');
        if (noResults) noResults.style.display = (q && visible === 0) ? '' : 'none';
    };

    input.addEventListener('input', filterTable);
})();

function applyTheme(dark) {
    document.documentElement.classList.toggle('dark', dark);

    const iconMenu = document.getElementById('theme-icon-menu');
    const label    = document.getElementById('theme-label');
    if (dark) {
        iconMenu?.classList.replace('fi-rr-moon', 'fi-rr-sun');
        if (label) label.textContent = 'Mode clair';
    } else {
        iconMenu?.classList.replace('fi-rr-sun', 'fi-rr-moon');
        if (label) label.textContent = 'Mode sombre';
    }

    document.getElementById('theme-toggle')?.classList.toggle('on', dark);

    localStorage.setItem('theme', dark ? 'dark' : 'light');
}