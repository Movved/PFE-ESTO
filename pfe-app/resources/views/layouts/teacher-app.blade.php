<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Teacher Dashboard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="flex h-screen" x-data="{ sidebarOpen: true }">
            <!-- Sidebar -->
            <aside :class="{'w-64': sidebarOpen, 'w-20': !sidebarOpen}" class="bg-white border-r border-gray-200 shadow-lg transition-all duration-300 overflow-hidden">
                <!-- Logo Section -->
                <div class="flex items-center justify-between h-20 px-4 border-b border-gray-200 bg-gradient-to-r from-white to-amber-50">
                    <a href="{{ route('enseignant.dashboard') }}" :class="{'block': sidebarOpen, 'hidden': !sidebarOpen}" class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-amber-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">E</span>
                        </div>
                        <span class="text-xl font-bold text-gray-800">PFE</span>
                    </a>
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-6 px-3 space-y-2">
                    <!-- Dashboard Link -->
                    <a href="{{ route('enseignant.dashboard') }}" 
                       :class="{'bg-amber-50 border-l-4 border-amber-600': request()->routeIs('enseignant.dashboard')}"
                       class="flex items-center gap-4 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition group relative">
                        <svg class="w-6 h-6 text-amber-600 flex-shrink-0" :class="{'text-amber-600': request()->routeIs('enseignant.dashboard')}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v7a1 1 0 001 1h12a1 1 0 001-1V9" />
                        </svg>
                        <span :class="{'block': sidebarOpen, 'hidden': !sidebarOpen}" class="font-medium">Dashboard</span>
                        <span :class="{'hidden': sidebarOpen, 'block': !sidebarOpen}" class="absolute left-16 bg-gray-800 text-white px-2 py-1 rounded text-sm whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none">Dashboard</span>
                    </a>

                    <!-- Filieres Link -->
                    <a href="{{ route('enseignant.filieres') }}" 
                       :class="{'bg-amber-50 border-l-4 border-amber-600': request()->routeIs('enseignant.filieres')}"
                       class="flex items-center gap-4 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition group relative">
                        <svg class="w-6 h-6 text-amber-600 flex-shrink-0" :class="{'text-amber-600': request()->routeIs('enseignant.filieres')}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747m0-13c5.5 0 10 4.745 10 10.747S17.5 28 12 28" />
                        </svg>
                        <span :class="{'block': sidebarOpen, 'hidden': !sidebarOpen}" class="font-medium">Filières</span>
                        <span :class="{'hidden': sidebarOpen, 'block': !sidebarOpen}" class="absolute left-16 bg-gray-800 text-white px-2 py-1 rounded text-sm whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none">Filières</span>
                    </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Header Bar -->
                <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm">
                    <div class="flex-1">
                        @isset($header)
                            {{ $header }}
                        @else
                            <h1 class="text-2xl font-bold text-gray-800">Espace Enseignant</h1>
                        @endisset
                    </div>

                    <!-- Profile & Logout Dropdown -->
                    @if(auth()->check())
                        <div x-data="{ profileOpen: false }" class="relative ml-6">
                            <button @click="profileOpen = !profileOpen" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                                <div class="w-10 h-10 bg-amber-600 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold">{{ substr(auth()->user()->nom ?? 'U', 0, 1) }}</span>
                                </div>
                                <div class="text-left hidden md:block">
                                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->prenom ?? 'User' }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                            </button>

                            <!-- Profile Dropdown -->
                            <div x-show="profileOpen" @click.outside="profileOpen = false" 
                                 x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-50 overflow-hidden">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 transition border-b border-gray-100">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-red-50 transition">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-auto bg-gray-50 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
