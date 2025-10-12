<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 leading-tight">
            Ajouter une nouvelle matière
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-8">
        <!-- Card contenant le formulaire -->
        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
            <!-- Affichage des erreurs de validation -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('matieres.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Nom de la matière -->
                <div>
                    <label for="nom" class="block text-gray-700 font-medium mb-2">Nom de la matière</label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom') }}" placeholder="Ex: Mathématiques"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <!-- Coefficient -->
                <div>
                    <label for="coefficient" class="block text-gray-700 font-medium mb-2">Coefficient</label>
                    <input type="number" name="coefficient" id="coefficient" value="{{ old('coefficient') }}" min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <!-- Bouton de soumission -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-blue-700 transition">
                        Ajouter la matière
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
