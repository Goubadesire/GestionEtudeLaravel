<x-app-layout>
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Ajouter un créneau</h2>

        <form action="{{ route('planning.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Matière -->
            <div>
                <label for="matiere_id" class="block text-gray-700 font-medium mb-1">Matière</label>
                <select name="matiere_id" id="matiere_id" class="w-full border-gray-300 rounded shadow-sm">
                    <option value="">Sélectionner une matière (facultatif)</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                    @endforeach
                </select>
                @error('matiere_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Jour -->
            <div>
                <label for="jour" class="block text-gray-700 font-medium mb-1">Jour</label>
                <select name="jour" id="jour" class="w-full border-gray-300 rounded shadow-sm">
                    <option value="">Sélectionner un jour</option>
                    <option value="Lundi">Lundi</option>
                    <option value="Mardi">Mardi</option>
                    <option value="Mercredi">Mercredi</option>
                    <option value="Jeudi">Jeudi</option>
                    <option value="Vendredi">Vendredi</option>
                    <option value="Samedi">Samedi</option>
                    <option value="Dimanche">Dimanche</option>
                </select>
                @error('jour')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Heure début -->
            <div>
                <label for="heure_debut" class="block text-gray-700 font-medium mb-1">Heure de début</label>
                <input type="time" name="heure_debut" id="heure_debut" class="w-full border-gray-300 rounded shadow-sm">
                @error('heure_debut')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Heure fin -->
            <div>
                <label for="heure_fin" class="block text-gray-700 font-medium mb-1">Heure de fin</label>
                <input type="time" name="heure_fin" id="heure_fin" class="w-full border-gray-300 rounded shadow-sm">
                @error('heure_fin')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Salle -->
            <div>
                <label for="salle" class="block text-gray-700 font-medium mb-1">Salle (facultatif)</label>
                <input type="text" name="salle" id="salle" class="w-full border-gray-300 rounded shadow-sm" placeholder="Ex: B101">
                @error('salle')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Bouton -->
            <div class="mt-4">
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded shadow hover:bg-green-500 transition">
                    Ajouter le créneau
                </button>
                <a href="{{ route('planning.index') }}" class="ml-4 px-6 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-200 transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
