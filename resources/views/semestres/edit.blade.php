<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le semestre
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto p-6 bg-white shadow rounded">
        <form action="{{ route('semestres.update', $semestre->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nom" class="block text-gray-700">Nom du semestre</label>
                <input type="text" name="nom" id="nom" class="w-full mt-1 p-2 border rounded" 
                       value="{{ old('nom', $semestre->nom) }}" required>
            </div>

            <button type="submit" class="btn btn-warning">
                Enregistrer les modifications
            </button>
        </form>
    </div>
</x-app-layout>
