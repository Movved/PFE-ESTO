<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes Notes
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 rounded-lg px-4 py-3 text-sm">
                    ✓ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-300 text-red-800 rounded-lg px-4 py-3 text-sm">
                    ✗ {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Résultats de {{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3">Module</th>
                                <th class="px-6 py-3">Évaluation</th>
                                <th class="px-6 py-3">Type</th>
                                <th class="px-6 py-3 text-center">Note</th>
                                <th class="px-6 py-3 text-center">Rattrapage</th>
                                <th class="px-6 py-3 text-center">Note Finale</th>
                                <th class="px-6 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($notes as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $row->nom_module }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $row->libelle }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if($row->type === 'CC') bg-indigo-100 text-indigo-700
                                        @elseif($row->type === 'TP') bg-green-100 text-green-700
                                        @else bg-orange-100 text-orange-700 @endif">
                                        {{ $row->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center font-mono">
                                    {{ $row->note !== null ? number_format($row->note, 2) : '—' }}
                                </td>
                                <td class="px-6 py-4 text-center font-mono">
                                    {{ $row->rattrapage !== null ? number_format($row->rattrapage, 2) : '—' }}
                                </td>
                                <td class="px-6 py-4 text-center font-mono font-semibold
                                    @if($row->note_finale === null) text-gray-400
                                    @elseif($row->note_finale >= 12) text-green-600
                                    @elseif($row->note_finale >= 10) text-amber-600
                                    @else text-red-600 @endif">
                                    {{ $row->note_finale !== null ? number_format($row->note_finale, 2).'/20' : '—' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($row->id_note && !$row->has_reclamation)
                                        <button onclick="openModal({{ $row->id_note }}, '{{ addslashes($row->nom_module) }} — {{ addslashes($row->libelle) }}')"
                                            class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition">
                                            Signaler
                                        </button>
                                    @elseif($row->has_reclamation)
                                        <span class="text-xs text-amber-600 font-medium">En attente</span>
                                    @else
                                        <span class="text-gray-300 text-xs">—</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-400 text-sm">
                                    Aucune note disponible pour le moment.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div id="modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50" onclick="closeModalIfOverlay(event)">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="font-bold text-gray-900">Signaler une erreur</h4>
                    <p id="modal-label" class="text-sm text-gray-500 mt-0.5"></p>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-lg leading-none">&times;</button>
            </div>

            <form method="POST" action="{{ route('etudiant.reclamation.store') }}">
                @csrf
                <input type="hidden" name="id_note" id="modal-id-note">
                <textarea name="message" rows="4" required placeholder="Décrivez l'erreur constatée..."
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm resize-none focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-100"></textarea>
                <div class="flex gap-2 justify-end mt-4">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                        Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(idNote, label) {
            document.getElementById('modal-id-note').value = idNote;
            document.getElementById('modal-label').textContent = label;
            document.getElementById('modal').classList.replace('hidden', 'flex');
        }
        function closeModal() {
            document.getElementById('modal').classList.replace('flex', 'hidden');
        }
        function closeModalIfOverlay(e) {
            if (e.target === document.getElementById('modal')) closeModal();
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
    </script>
</x-app-layout>