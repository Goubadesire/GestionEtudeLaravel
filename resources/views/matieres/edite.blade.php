<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Modifier la matière
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <form action="{{ route('matieres.update', $matiere->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nom -->
            <div class="mb-4">
                <label for="nom" class="block text-gray-700 font-medium mb-1">Nom de la matière</label>
                <input type="text" name="nom" id="nom" value="{{ old('nom', $matiere->nom) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('nom')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Coefficient -->
            <div class="mb-4">
                <label for="coefficient" class="block text-gray-700 font-medium mb-1">Coefficient</label>
                <input type="number" name="coefficient" id="coefficient" value="{{ old('coefficient', $matiere->coefficient) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="1">
                @error('coefficient')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Semestre -->
            <div class="mb-4">
                <label for="semestre_id" class="block text-gray-700 font-medium mb-1">Semestre</label>
                <select name="semestre_id" id="semestre_id"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Non attribué --</option>
                    @foreach($semestres as $semestre)
                        <option value="{{ $semestre->id }}"
                            {{ old('semestre_id', $matiere->semestre_id) == $semestre->id ? 'selected' : '' }}>
                            {{ $semestre->nom }}
                        </option>
                    @endforeach
                </select>
                @error('semestre_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Bouton -->
            <div class="mt-6">
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Enregistrer
                </button>
                <a href="{{ route('matieres.index') }}"
                   class="ml-4 px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
