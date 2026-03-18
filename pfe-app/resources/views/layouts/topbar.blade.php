{{-- TOPBAR --}}
<header class="topbar">

    <span class="topbar-title">{{ $title ?? '' }}</span>
    <div class="topbar-right">
        @if(isset($search) && $search)
            <div class="topbar-search">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" id="search-input" placeholder="{{ $searchPlaceholder ?? 'Rechercher...' }}"
                    oninput="filterTable()" />
            </div>
        @endif

        <div class="topbar-clock">
            <span id="topbar-time"></span>
            <span id="topbar-date"></span>
        </div>
    </div>      
</header>