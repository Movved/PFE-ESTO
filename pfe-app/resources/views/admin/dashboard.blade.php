<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de Bord - Administrateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Gestion du Système</h3>
                    <p>Bienvenue, {{ Auth::user()->nom }}. Vous avez un accès complet pour gérer les utilisateurs, les filières et les années académiques.vous etes un admin</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>