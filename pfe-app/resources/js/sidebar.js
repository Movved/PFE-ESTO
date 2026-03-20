document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('sidebar');
    const mainEl  = document.getElementById('main-content');
    const tooltip = document.getElementById('sb-tooltip');

    // Sidebar or main might not exist on every page — guard
    if (!sidebar || !mainEl) return;

    /* ── Restore state on load ──────────────────── */
    if (localStorage.getItem('sb') === 'collapsed') {
        sidebar.classList.add('collapsed');
        mainEl.classList.add('sidebar-collapsed');
        activateTooltips();
    }

    /* ── Collapse / Expand ──────────────────────── */
    window.collapseSidebar = function () {
        sidebar.classList.add('collapsed');
        mainEl.classList.add('sidebar-collapsed');
        localStorage.setItem('sb', 'collapsed');
        activateTooltips();
    };

    window.expandSidebar = function () {
        sidebar.classList.remove('collapsed');
        mainEl.classList.remove('sidebar-collapsed');
        localStorage.setItem('sb', 'expanded');
        deactivateTooltips();
    };

    /* ── Tooltips (collapsed mode) ──────────────── */
    function activateTooltips() {
        document.querySelectorAll('.sb-item').forEach(el => {
            el.addEventListener('mouseenter', showTip);
            el.addEventListener('mouseleave', hideTip);
        });
    }

    function deactivateTooltips() {
        document.querySelectorAll('.sb-item').forEach(el => {
            el.removeEventListener('mouseenter', showTip);
            el.removeEventListener('mouseleave', hideTip);
        });
        hideTip();
    }

    function showTip(e) {
        if (!tooltip) return;
        const label = e.currentTarget.querySelector('.sb-item-label');
        if (!label) return;
        const rect = e.currentTarget.getBoundingClientRect();
        tooltip.textContent = label.textContent.trim();
        tooltip.style.top  = (rect.top + rect.height / 2 - 14) + 'px';
        tooltip.style.left = (rect.right + 10) + 'px';
        tooltip.classList.add('visible');
    }

    function hideTip() {
        tooltip?.classList.remove('visible');
    }

    /* ── User menu ──────────────────────────────── */
    window.toggleUserMenu = function (e) {
        e.stopPropagation();
        document.getElementById('sb-user-menu')?.classList.toggle('open');
    };

    window.closeSbMenu = function () {
        document.getElementById('sb-user-menu')?.classList.remove('open');
    };

    // Close when clicking anywhere outside the menu
    document.addEventListener('click', function () {
        document.getElementById('sb-user-menu')?.classList.remove('open');
    });

});