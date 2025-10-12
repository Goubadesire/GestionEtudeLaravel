<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajouter un semestre
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto p-6 bg-white shadow rounded">
        <form action="{{ route('semestres.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nom" class="block text-gray-700">Nom du semestre</label>
                <input type="text" name="nom" id="nom" class="w-full mt-1 p-2 border rounded" required>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500 transition">
                Ajouter
            </button>
        </form>
    </div>
</x-app-layout>
