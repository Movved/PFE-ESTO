document.addEventListener('DOMContentLoaded', function () {
    const sb = document.getElementById('sidebar');
    const tooltip = document.getElementById('sb-tooltip');

    if (!sb) return; // Exit if sidebar is not present on this page

    /* ── Restore state without animation on load ── */
    sb.style.transition = 'none';
    if (localStorage.getItem('sb_collapsed') === '1') sb.classList.add('collapsed');
    requestAnimationFrame(() => { sb.style.transition = ''; });

    /* ── Toggle ── */
    window.toggleSidebar = function () {
        sb.classList.toggle('collapsed');
        localStorage.setItem('sb_collapsed', sb.classList.contains('collapsed') ? '1' : '0');
        /* Hide tooltip immediately on toggle */
        if (tooltip) tooltip.style.opacity = '0';
    };

    /* ── Tooltips (collapsed only) ── */
    if (tooltip) {
        document.querySelectorAll('.sb-item').forEach(function (item) {
            const label = item.querySelector('.sb-item-label');
            if (!label) return;
            item.addEventListener('mouseenter', function () {
                if (!sb.classList.contains('collapsed')) return;
                const r = item.getBoundingClientRect();
                tooltip.textContent = label.textContent.trim();
                tooltip.style.top = (r.top + r.height / 2) + 'px';
                tooltip.style.left = (r.right + 12) + 'px';
                tooltip.style.opacity = '1';
            });
            item.addEventListener('mouseleave', function () {
                tooltip.style.opacity = '0';
            });
        });
    }

    /* ── User menu ── */
    window.toggleUserMenu = function (e) {
        if (e) e.stopPropagation();
        const userMenu = document.getElementById('sb-user-menu');
        if (userMenu) userMenu.classList.toggle('open');
    };
    document.addEventListener('click', function (e) {
        const userMenu = document.getElementById('sb-user-menu');
        const userBtn = document.getElementById('sb-user-btn');
        if (userMenu && userMenu.classList.contains('open')) {
            if (userBtn && userBtn.contains(e.target)) return;
            if (userMenu.contains(e.target)) return;
            userMenu.classList.remove('open');
        }
    });

    /* ── Theme ── */
    function updateThemeLabel() {
        const lbl = document.getElementById('theme-label');
        const icon = document.getElementById('theme-icon-menu');
        const isDark = document.documentElement.classList.contains('dark');
        if (lbl) lbl.textContent = isDark ? 'Mode clair' : 'Mode sombre';
        if (icon) {
            icon.className = isDark ? 'fi fi-rr-sun' : 'fi fi-rr-moon';
        }
    }
    updateThemeLabel();
    window.toggleThemeFromMenu = function () {
        const dark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', dark ? 'dark' : 'light');
        updateThemeLabel();
    };
});
