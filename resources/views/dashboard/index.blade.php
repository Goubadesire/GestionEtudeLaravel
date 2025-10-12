<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Dashboard</h2>
    </x-slot>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Nombre de matières --}}
        <div class="bg-white p-5 rounded-lg shadow flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold">📚 Matières</h3>
                <p class="text-2xl mt-2 font-semibold">{{ $matieres->count() }}</p>
            </div>
        </div>

        {{-- Nombre de notes --}}
        <div class="bg-white p-5 rounded-lg shadow flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold">📝 Notes</h3>
                <p class="text-2xl mt-2 font-semibold">{{ $matieres->sum(fn($m) => $m->notes->count()) }}</p>
            </div>
        </div>

        {{-- Moyenne générale --}}
        @php
        function colorMoyenne($moyenne) {
            if ($moyenne === null) return 'bg-gray-100 text-gray-700';
            if ($moyenne < 10) return 'bg-red-100 text-red-700';
            if ($moyenne < 12) return 'bg-yellow-100 text-yellow-700';
            if ($moyenne < 16) return 'bg-blue-100 text-blue-700';
            return 'bg-green-100 text-green-700';
        }
        $colorMoyenneGenerale = colorMoyenne($moyenneGenerale);
        @endphp

        <div class="{{ $colorMoyenneGenerale }} p-5 rounded-lg shadow flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold">🎯 Moyenne générale</h3>
                <p class="text-2xl mt-2 font-semibold">
                    {{ $moyenneGenerale !== null ? number_format($moyenneGenerale, 2) : 'Aucune note' }}
                </p>
            </div>
            <div class="text-4xl">🏆</div>
        </div>

    </div>

    {{-- Graphiques --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <div class="bg-white p-5 rounded-lg shadow">
            <h3 class="text-lg font-bold mb-4">📊 Moyenne par semestre</h3>
            <canvas id="chartSemestres"></canvas>
        </div>

        <div class="bg-white p-5 rounded-lg shadow">
            <h3 class="text-lg font-bold mb-4">📊 Nombre de notes par matière</h3>
            <canvas id="chartNotesMatiere"></canvas>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Moyenne par semestre
        const ctxSem = document.getElementById('chartSemestres').getContext('2d');
        const moyennesSemestres = @json($moyennesSemestres);
        const colorsSem = Object.values(moyennesSemestres).map(m => {
            if (m === null) return 'rgba(200,200,200,0.7)';
            if (m < 10) return 'rgba(255,99,132,0.7)';
            if (m < 12) return 'rgba(255,206,86,0.7)';
            if (m < 16) return 'rgba(54,162,235,0.7)';
            return 'rgba(75,192,192,0.7)';
        });

        new Chart(ctxSem, {
            type: 'bar',
            data: {
                labels: Object.keys(moyennesSemestres),
                datasets: [{
                    label: 'Moyenne',
                    data: Object.values(moyennesSemestres),
                    backgroundColor: colorsSem,
                    borderColor: colorsSem.map(c => c.replace('0.7','1')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true, max: 20 } }
            }
        });

        // Nombre de notes par matière
        const ctxNotes = document.getElementById('chartNotesMatiere').getContext('2d');
        const notesMatiere = @json($notesParMatiere);

        new Chart(ctxNotes, {
            type: 'bar',
            data: {
                labels: Object.keys(notesMatiere),
                datasets: [{
                    label: 'Nombre de notes',
                    data: Object.values(notesMatiere),
                    backgroundColor: 'rgba(54,162,235,0.7)',
                    borderColor: 'rgba(54,162,235,1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>

</x-app-layout>
