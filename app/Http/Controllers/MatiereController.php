<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatiereController extends Controller
{
    public function index()
    {
        $matieres = Matiere::with('semestre')
            ->where('user_id', Auth::id())
            ->get();
        return view('matieres.index', compact('matieres'));
    }

    public function create()
    {
        $semestres = Semestre::where('user_id', Auth::id())->get();
        return view('matieres.create', compact('semestres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'coefficient' => 'required|integer|min:1',
            'semestre_id' => 'nullable|exists:semestres,id',
        ]);

        Matiere::create([
            'nom' => $request->nom,
            'coefficient' => $request->coefficient,
            'semestre_id' => $request->semestre_id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('matieres.index')->with('success', 'Matière ajoutée avec succès.');
    }

    public function edit(Matiere $matiere)
    {
        
        $semestres = Semestre::where('user_id', Auth::id())->get();
        return view('matieres.edite', compact('matiere', 'semestres'));
    }

    public function update(Request $request, Matiere $matiere)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'coefficient' => 'required|integer|min:1',
            'semestre_id' => 'nullable|exists:semestres,id',
        ]);

        $matiere->update([
            'nom' => $request->nom,
            'coefficient' => $request->coefficient,
            'semestre_id' => $request->semestre_id,
        ]);

        return redirect()->route('matieres.index')->with('success', 'Matière mise à jour.');
    }

    public function destroy(Matiere $matiere)
    {
        $matiere->delete();
        return redirect()->route('matieres.index')->with('success', 'Matière supprimée.');
    }
}
