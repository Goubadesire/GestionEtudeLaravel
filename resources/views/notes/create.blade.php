<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Ajouter une note</h2>
    </x-slot>

    <div class="mt-6 max-w-md mx-auto bg-white p-6 rounded-lg shadow">
        <form action="{{ route('notes.store') }}" method="POST">
            @csrf

            {{-- Matière --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="matiere_id">Matière</label>
                <select name="matiere_id" id="matiere_id" class="w-full border-gray-300 rounded px-3 py-2">
                    <option value="">-- Sélectionnez une matière --</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                    @endforeach
                </select>
                @error('matiere_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Valeur --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="valeur">Valeur</label>
                <input type="number" name="valeur" id="valeur" step="0.01" class="w-full border-gray-300 rounded px-3 py-2" value="{{ old('valeur') }}">
                @error('valeur')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Coefficient --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="coef">Coefficient</label>
                <input type="number" name="coef" id="coef" step="0.01" class="w-full border-gray-300 rounded px-3 py-2" value="{{ old('coef', 1) }}">
                @error('coef')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Commentaire --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="commentaire">Commentaire</label>
                <textarea name="commentaire" id="commentaire" class="w-full border-gray-300 rounded px-3 py-2">{{ old('commentaire') }}</textarea>
                @error('commentaire')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Bouton --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Ajouter la note
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
