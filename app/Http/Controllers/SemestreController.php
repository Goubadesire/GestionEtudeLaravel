<?php

namespace App\Http\Controllers;

use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SemestreController extends Controller
{
    public function index()
    {
        $semestres = Semestre::where('user_id', Auth::id())->get();
        return view('semestres.index', compact('semestres'));
    }

    public function create()
    {
        return view('semestres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        Semestre::create([
            'nom' => $request->nom,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('semestres.index')->with('success', 'Semestre créé avec succès.');
    }

    public function edit(Semestre $semestre)
    {
        
        return view('semestres.edit', compact('semestre'));
    }

    public function update(Request $request, Semestre $semestre)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $semestre->update([
            'nom' => $request->nom,
        ]);

        return redirect()->route('semestres.index')->with('success', 'Semestre mis à jour.');
    }

    public function destroy(Semestre $semestre)
    {
        $semestre->delete();
        return redirect()->route('semestres.index')->with('success', 'Semestre supprimé.');
    }
}
