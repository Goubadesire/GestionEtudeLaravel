<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">📅 Emploi du temps</h2>
    </x-slot>

    <div class="px-6 py-4">

        {{-- ✅ Messages flash --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- ✅ Bouton d’ajout --}}
        <div class="flex justify-end mb-6">
            <a href="{{ route('planning.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Nouveau créneau
            </a>
        </div>

        {{-- ✅ Vérification des créneaux --}}
        @if($emplois->isEmpty())
            <p class="text-gray-500 text-center">
                Aucun créneau pour le moment.<br>
                Cliquez sur “+ Nouveau créneau” pour en ajouter un.
            </p>
        @else
            {{-- ✅ Groupement par jour --}}
            @foreach($emplois as $jour => $creneaux)
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-indigo-700 mb-4 border-b pb-1">
                        {{ ucfirst($jour) }}
                    </h2>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($creneaux as $emploi)
                            <div class="bg-white rounded-xl shadow p-4 border border-gray-200">
                                <h3 class="text-lg font-bold text-gray-700 mb-1">
                                    {{ $emploi->matiere->nom ?? 'Matière non attribuée' }}
                                </h3>

                                <p class="text-gray-600 text-sm mb-1">
                                    ⏰ {{ $emploi->heure_debut }} - {{ $emploi->heure_fin }}
                                </p>

                                <p class="text-gray-600 text-sm mb-2">
                                    🏫 Salle : {{ $emploi->salle ?? 'Non spécifiée' }}
                                </p>

                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('planning.edit', $emploi->id) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                        Modifier
                                    </a>

                                    <form action="{{ route('planning.destroy', $emploi->id) }}" method="POST"
                                          onsubmit="return confirm('Voulez-vous vraiment supprimer ce créneau ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif

    </div>
</x-app-layout>
