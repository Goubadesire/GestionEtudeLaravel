<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Mes Matières</h2>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        @foreach($matieres as $matiere)
            <div class="bg-white p-5 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-lg font-bold">{{ $matiere->nom }}</h3>
                <p class="text-gray-500 mt-1">Coefficient : {{ $matiere->coefficient }}</p>
                <p class="text-gray-400 mt-1">Semestre : {{ $matiere->semestre?->nom ?? 'Non attribué' }}</p>

                <div class="mt-3 flex justify-between">
                    <a href="{{ route('matieres.edit', $matiere) }}" class="text-blue-600 hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen-icon lucide-pen"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/></svg>
                    </a>
                    <form action="{{ route('matieres.destroy', $matiere) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette matière ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        <a href="{{ route('matieres.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Ajouter une matière</a>
    </div>
</x-app-layout>
