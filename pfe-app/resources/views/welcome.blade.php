<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PFE - Gestion Académique</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">
    
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-red-500 selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
            
            <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                <div class="flex lg:justify-center lg:col-start-2">
                    <h1 class="text-3xl font-bold text-red-600">PFE <span class="text-gray-800">ESTO</span></h1>
                </div>
                
                <nav class="-mx-3 flex flex-1 justify-end">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md px-4 py-2 bg-red-600 text-white font-semibold shadow-sm hover:bg-red-500 transition focus:outline-none">
                            Connexion
                        </a>
                    @endauth
                </nav>
            </header>

            <main class="mt-6">
                <div class="text-center">
                    <h2 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-6xl">
                        Plateforme de Gestion des Évaluations
                    </h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Bienvenue sur l'espace numérique de l'École Supérieure de Technologie d'Oujda. 
                        Une solution complète pour les étudiants, les enseignants et l'administration.
                    </p>
                </div>

                <div class="mt-16 grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div class="flex flex-col items-start gap-4 rounded-lg bg-white p-6 shadow-md ring-1 ring-gray-200">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Administration</h3>
                        <p class="text-sm text-gray-500 text-left">Gérez les comptes utilisateurs, les filières et les configurations globales du système.</p>
                    </div>

                    <div class="flex flex-col items-start gap-4 rounded-lg bg-white p-6 shadow-md ring-1 ring-gray-200">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Enseignants</h3>
                        <p class="text-sm text-gray-500 text-left">Saisissez les notes, gérez vos modules et suivez les performances de vos classes.</p>
                    </div>

                    <div class="flex flex-col items-start gap-4 rounded-lg bg-white p-6 shadow-md ring-1 ring-gray-200">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Étudiants</h3>
                        <p class="text-sm text-gray-500 text-left">Consultez vos résultats d'examen, votre emploi du temps et votre historique académique.</p>
                    </div>
                </div>
            </main>

            <footer class="py-16 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} ESTO Oujda - Tous droits réservés.
            </footer>
        </div>
    </div>
</body>
</html>