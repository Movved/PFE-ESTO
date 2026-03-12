import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

window.toggleUserMenu = function () {
    const menu = document.getElementById('user-menu');
    if (menu) menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

window.toggleThemeFromMenu = function () {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    const label = document.getElementById('theme-label');
    if (label) label.textContent = isDark ? 'Mode clair' : 'Mode sombre';
}

window.openModal = function (idNote, label) {
    document.getElementById('modal-id-note').value = idNote;
    document.getElementById('modal-label').textContent = label;
    document.getElementById('modal').classList.add('open');
}

window.closeModal = function () {
    document.getElementById('modal').classList.remove('open');
}

window.closeModalIfOverlay = function (e) {
    if (e.target === document.getElementById('modal')) window.closeModal();
}

window.filterTable = function () {
    const query = document.getElementById('search-input').value.toLowerCase();
    document.querySelectorAll('#notes-table tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(query) ? '' : 'none';
    });
}

window.filterCourses = function () {
    const query = document.getElementById('search-input').value.toLowerCase();
    document.querySelectorAll('.course-card').forEach(card => {
        const name = card.getAttribute('data-name') || '';
        card.style.display = name.includes(query) ? '' : 'none';
    });
}
// Close menu (3 button)
document.addEventListener('DOMContentLoaded', function () {
    const label = document.getElementById('theme-label');
    if (label && localStorage.getItem('theme') === 'dark') {
        label.textContent = 'Mode clair';
    }


    document.addEventListener('click', function (e) {
        const menu = document.getElementById('user-menu');
        if (menu && !e.target.closest('#user-menu') && !e.target.closest('[onclick="toggleUserMenu()"]')) {
            menu.style.display = 'none';
        }
    });

    // le temps topbar right
    function updateClock() {
        const time = document.getElementById('topbar-time');
        const date = document.getElementById('topbar-date');
        if (!time || !date) return;
        const now = new Date();
        time.textContent = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        date.textContent = now.toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long' });
    }

    updateClock();
    setInterval(updateClock, 1000);

    // Escape key for modal
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && document.getElementById('modal')) window.closeModal();
    });
});

// loading tout les fonction bug fix

window.addEventListener('load', () => {
    setTimeout(() => {
        document.getElementById('no-transitions').remove();
    }, 100);
});
