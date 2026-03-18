<header class="topbar">
    <span class="topbar-title">{{ $title ?? '' }}</span>

    @if(isset($search) && $search)
        <div class="topbar-search">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="text" placeholder="{{ $searchPlaceholder ?? 'Rechercher...' }}"
                id="search-input" oninput="filterTable()"
                style="border:none;background:transparent;font-size:13px;font-family:inherit;color:var(--text-primary);outline:none;width:100%;padding:0;" />
        </div>
    @endif

    <div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
        <span id="topbar-time" style="font-size:14px; font-weight:600; color:var(--text-primary); font-family:'SF Mono','Fira Code',monospace;"></span>
        <span id="topbar-date" style="font-size:11px; color:var(--text-secondary);"></span>
    </div>
</header>