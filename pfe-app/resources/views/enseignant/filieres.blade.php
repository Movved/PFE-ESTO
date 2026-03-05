<x-teacher-app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800">Filières</h2>
        </div>
    </x-slot>

    <!-- Filières Content -->
    <div class="max-w-6xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Mes Filières</h1>
                <p class="text-gray-500 mt-1">Consultez les filières et leurs programmes</p>
            </div>
        </div>

        <!-- Filières Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Filière Card Template -->
            @forelse($filieres ?? [] as $filiere)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden border-t-4 border-amber-600">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-amber-50 to-white p-6 border-b border-gray-100">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $filiere->nom_filiere }}</h3>
                        <p class="text-sm text-gray-600">{{ $filiere->description }}</p>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <div class="space-y-4 mb-4">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="text-gray-700"><strong>Responsable:</strong> {{ $filiere->responsable->prenom }} {{ $filiere->responsable->nom }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                                <span class="text-gray-700"><strong>Années:</strong> {{ $filiere->anneeAcademiques->count() }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M5 21v-4M3 5h4M21 5h-4M3 19h4M21 19h-4" />
                                </svg>
                                <span class="text-gray-700"><strong>Étudiants:</strong> {{ $filiere->student_count }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                        <a href="{{ route('enseignant.filiere.show', $filiere->id_filiere) }}" 
                           class="w-full block text-center bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            Consulter les détails
                        </a>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="text-center py-12 bg-white rounded-lg">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Aucune filière</h3>
                        <p class="text-gray-500">Vous n'êtes pas encore assigné à une filière.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-teacher-app>
