<x-teacher-app>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">Dashboard</h2>
    </x-slot>

    <!-- Dashboard Content -->
    <div class="max-w-6xl">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Filières Card -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-amber-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Mes Filières</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalFilieres }}</p>
                    </div>
                    <svg class="w-12 h-12 text-amber-600 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                </div>
            </div>

            <!-- Students Card -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-amber-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Étudiants</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalStudents }}</p>
                    </div>
                    <svg class="w-12 h-12 text-amber-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3.936A9.964 9.964 0 0115 3c4.97 0 9 4.029 9 9S19.97 21 15 21z" />
                    </svg>
                </div>
            </div>

            <!-- Evaluations Card -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-amber-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Évaluations</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEvaluations }}</p>
                    </div>
                    <svg class="w-12 h-12 text-amber-400 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pass/Fail Chart and Notifications -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Répartition des Étudiants</h3>
                <canvas id="passFailChart" width="300" height="200"></canvas>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Notifications</h3>
                <div class="space-y-3">
                    <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-700">Aucune nouvelle notification</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('passFailChart').getContext('2d');
        const passFailChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Réussi (>=10)', 'Échec (<10)'],
                datasets: [{
                    data: [{{ $passCount }}, {{ $failCount }}],
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgba(34, 197, 94, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
</x-teacher-app>