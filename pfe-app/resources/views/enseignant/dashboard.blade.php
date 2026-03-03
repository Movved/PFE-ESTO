<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Espace Enseignant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Mes Modules</h3>
                    <p>Bonjour M./Mme {{ Auth::user()->nom }}. Vous pouvez ici consulter vos affectations et gérer les évaluations des étudiants.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>