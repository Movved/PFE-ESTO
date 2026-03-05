<x-teacher-app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <a href="{{ route('enseignant.filiere.show', $filiere->id_filiere) }}" class="text-amber-600 hover:text-amber-700 font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Retour
            </a>
            <div>
                <h2 class="font-semibold text-2xl text-gray-800">Détails Étudiant</h2>
                <p class="text-gray-500 mt-1">{{ $student->user->prenom }} {{ $student->user->nom }} - {{ $module->nom_module }}</p>
            </div>
            
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <!-- Student Info -->
        <div class="bg-white rounded-lg shadow p-6 mb-6 border-l-4 border-amber-600">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Nom</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $student->user->nom }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Prénom</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $student->user->prenom }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">CNE</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $student->cne }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Filière</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $filiere->nom_filiere }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Année</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $student->annee_actuelle }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Email</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $student->user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Statut</p>
                    @if($student->user->actif)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Actif</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Inactif</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Evaluations Table -->
        @if($evaluations->isNotEmpty())
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-amber-50 to-white border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Évaluation</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Date</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700">Note</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700">Rattrapage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($evaluations as $eval)
                            @php
                                $note = $notes->get($eval->id_evaluation);
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    {{ $eval->libelle }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($eval->date_evaluation)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $note->note ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $note->rattrapage ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-gray-50 rounded-lg p-12 text-center">
                <p class="text-gray-500">Aucune évaluation définie pour ce module.</p>
            </div>
        @endif
    </div>
</x-teacher-app>
