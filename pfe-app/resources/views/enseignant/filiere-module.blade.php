<x-teacher-app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <a href="{{ route('enseignant.filieres') }}" class="text-amber-600 hover:text-amber-700 font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Retour aux filières
            </a>
            <div>
                <h2 class="font-semibold text-2xl text-gray-800">{{ $filiere->nom_filiere }} - {{ $module->nom_module }}</h2>
                <p class="text-gray-500 mt-1">Assigner les notes aux étudiants</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl">
        <!-- Module Info -->
        <div class="bg-white rounded-lg shadow p-6 mb-6 border-l-4 border-amber-600">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Module</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $module->nom_module }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Code</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $module->code_module }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Semestre</p>
                    <p class="text-lg font-semibold text-gray-800">S{{ $module->semestre_numero }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Étudiants</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $students->count() }}</p>
                </div>
            </div>
        </div>

        @if($evaluations->isNotEmpty())
            @php $evaluation = $evaluations->first(); @endphp

            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Saisie des Notes</h3>
                    <p class="text-sm text-gray-500 mt-1">Cliquez sur <strong>Assigner les notes</strong> pour saisir, puis <strong>Enregistrer</strong> pour sauvegarder.</p>
                </div>

                <table class="w-full">
                    <thead class="bg-amber-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Étudiant</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Session Normale <span class="text-gray-400">(/ 20)</span></th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Rattrapage <span class="text-gray-400">(/ 20)</span></th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Note Finale</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($students as $student)
                            @php
                                $studentNotes = $notes->get($student->id_user, collect());
                                $note = $studentNotes->firstWhere('id_evaluation', $evaluation->id_evaluation);
                            @endphp
                            <tr class="hover:bg-gray-50 transition group" id="row-{{ $student->id_user }}">

                                <!-- Student -->
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800">{{ $student->user->prenom }} {{ $student->user->nom }}</p>
                                    <p class="text-xs text-gray-500">{{ $student->cne }}</p>
                                </td>

                                <!-- Session Normale -->
                                <td class="px-6 py-4 text-center">
                                    <span class="display-note font-semibold text-gray-800">
                                        {{ $note ? $note->note : '—' }}
                                    </span>
                                    <input
                                        type="number" step="0.01" min="0" max="20"
                                        class="input-note hidden w-24 mx-auto border border-gray-300 rounded-lg px-3 py-1.5 text-sm text-center focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none"
                                        value="{{ $note->note ?? '' }}"
                                        placeholder="0 – 20"
                                    >
                                </td>

                                <!-- Rattrapage -->
                                <td class="px-6 py-4 text-center">
                                    <span class="display-ratt text-amber-600 font-medium">
                                        {{ ($note && $note->rattrapage) ? $note->rattrapage : '—' }}
                                    </span>
                                    <input
                                        type="number" step="0.01" min="0" max="20"
                                        class="input-ratt hidden w-24 mx-auto border border-dashed border-amber-300 rounded-lg px-3 py-1.5 text-sm text-center focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none"
                                        value="{{ $note->rattrapage ?? '' }}"
                                        placeholder="Optionnel"
                                    >
                                </td>

                                <!-- Note Finale -->
                                <td class="px-6 py-4 text-center">
                                    @if($note)
                                        @php $finale = $note->note_finale; @endphp
                                        <span class="inline-block px-2 py-0.5 rounded-full text-sm font-bold
                                            {{ $finale >= 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                            {{ $finale }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>

                                <!-- Action -->
                                <td class="px-6 py-4 text-center">
                                    <div class="idle-actions flex justify-center gap-2">
                                        <button
                                            type="button"
                                            onclick="startEdit({{ $student->id_user }})"
                                            class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-sm rounded-lg transition"
                                        >
                                            Assigner les notes
                                        </button>
                                        <a
                                            href="{{ route('enseignant.student.show', [$filiere->id_filiere, $student->id_user]) }}"
                                            class="px-3 py-1.5 bg-gray-500 hover:bg-gray-600 text-white text-sm rounded-lg transition"
                                        >
                                            Détails
                                        </a>
                                    </div>
                                    <div class="edit-actions hidden flex justify-center gap-2">
                                        <button
                                            type="button"
                                            onclick="saveGrade({{ $student->id_user }}, {{ $evaluation->id_evaluation }})"
                                            class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition flex items-center gap-1"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Enregistrer
                                        </button>
                                        <button
                                            type="button"
                                            onclick="cancelEdit({{ $student->id_user }})"
                                            class="px-3 py-1.5 bg-gray-400 hover:bg-gray-500 text-white text-sm rounded-lg transition"
                                        >
                                            Annuler
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else
            <div class="bg-gray-50 rounded-lg p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-500">Aucune évaluation pour ce module.</p>
            </div>
        @endif
    </div>

    <script>
        const CSRF       = '{{ csrf_token() }}';
const UPDATE_URL = '{{ route('enseignant.student.update-grade') }}';
        function startEdit(studentId) {
            const row = document.getElementById('row-' + studentId);
            row.querySelectorAll('.display-note, .display-ratt').forEach(el => el.classList.add('hidden'));
            row.querySelectorAll('.input-note, .input-ratt').forEach(el => el.classList.remove('hidden'));
            row.querySelector('.idle-actions').classList.add('hidden');
            row.querySelector('.edit-actions').classList.remove('hidden');
            row.querySelector('.input-note').focus();
        }

        function cancelEdit(studentId) {
            const row = document.getElementById('row-' + studentId);
            row.querySelectorAll('.display-note, .display-ratt').forEach(el => el.classList.remove('hidden'));
            row.querySelectorAll('.input-note, .input-ratt').forEach(el => el.classList.add('hidden'));
            row.querySelector('.idle-actions').classList.remove('hidden');
            row.querySelector('.edit-actions').classList.add('hidden');
        }

        async function saveGrade(studentId, evaluationId) {
            const row     = document.getElementById('row-' + studentId);
            const noteVal = row.querySelector('.input-note').value.trim();
            const rattVal = row.querySelector('.input-ratt').value.trim();
            const saveBtn = row.querySelector('.edit-actions button:first-child');

            if (noteVal === '') {
                showToast('Veuillez saisir la note de session normale.', 'error');
                return;
            }

            saveBtn.disabled = true;
            saveBtn.textContent = 'Enregistrement...';

            const formData = new FormData();
            formData.append('_token', CSRF);
            formData.append('student_id', studentId);
            formData.append('evaluation_id', evaluationId);
            formData.append('note', noteVal);
            if (rattVal !== '') formData.append('rattrapage', rattVal);

            try {
                const response = await fetch(UPDATE_URL, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' },
                    body: formData
                });
                const data = await response.json();

                if (data.success) {
                    // Update displayed values
                    row.querySelector('.display-note').textContent = noteVal;
                    row.querySelector('.display-ratt').textContent = rattVal !== '' ? rattVal : '—';

                    // Recalculate and update note finale badge
                    const finale = rattVal !== '' ? Math.max(parseFloat(noteVal), parseFloat(rattVal)) : parseFloat(noteVal);
                    const finaleCell = row.cells[3];
                    const isPass = finale >= 10;
                    finaleCell.innerHTML = `<span class="inline-block px-2 py-0.5 rounded-full text-sm font-bold
                        ${isPass ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600'}">
                        ${finale % 1 === 0 ? finale : finale.toFixed(2)}
                    </span>`;

                    cancelEdit(studentId);
                    showToast('Note enregistrée avec succès !', 'success');
                } else {
                    showToast(data.error || 'Une erreur est survenue.', 'error');
                }
            } catch (err) {
                showToast('Erreur réseau. Veuillez réessayer.', 'error');
            } finally {
                saveBtn.disabled = false;
                saveBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg> Enregistrer`;
            }
        }

        function showToast(message, type = 'success') {
            const existing = document.getElementById('toast');
            if (existing) existing.remove();

            const toast = document.createElement('div');
            toast.id = 'toast';
            toast.className = `fixed bottom-6 right-6 z-50 flex items-center gap-3 px-5 py-3 rounded-lg shadow-lg text-white text-sm
                ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
            toast.innerHTML = `
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'success'
                        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'
                        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'}
                </svg>
                <span>${message}</span>`;
            document.body.appendChild(toast);
            setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 400); }, 3000);
        }
    </script>
</x-teacher-app>