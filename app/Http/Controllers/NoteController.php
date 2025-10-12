<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $matieres = Matiere::where('user_id', Auth::id())->get();
        return view('notes.index', compact('matieres'));
    }

    public function create()
    {
        $matieres = Matiere::where('user_id', Auth::id())->get();
        return view('notes.create', compact('matieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matiere_id' => 'nullable|exists:matieres,id',
            'valeur' => 'required|numeric|min:0|max:20',
            'coef' => 'required|numeric|min:0',
            'commentaire' => 'nullable|string|max:255',
        ]);

        Note::create([
            'user_id' => Auth::id(),
            'matiere_id' => $request->matiere_id,
            'valeur' => $request->valeur,
            'coef' => $request->coef,
            'commentaire' => $request->commentaire,
        ]);

        return redirect()->route('notes.index')->with('success', 'Note ajoutée avec succès.');
    }

    public function edit(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            return redirect()->route('notes.index')->with('error', 'Vous n’êtes pas autorisé à modifier cette note.');
        }

        $matieres = Matiere::where('user_id', Auth::id())->get();
        return view('notes.edite', compact('note', 'matieres'));
    }

    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            return redirect()->route('notes.index')->with('error', 'Vous n’êtes pas autorisé à modifier cette note.');
        }

        $request->validate([
            'matiere_id' => 'nullable|exists:matieres,id',
            'valeur' => 'required|numeric|min:0|max:20',
            'coef' => 'required|numeric|min:0',
            'commentaire' => 'nullable|string|max:255',
        ]);

        $note->update($request->only('matiere_id', 'valeur', 'coef', 'commentaire'));

        return redirect()->route('notes.index')->with('success', 'Note mise à jour avec succès.');
    }

    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            return redirect()->route('notes.index')->with('error', 'Vous n’êtes pas autorisé à supprimer cette note.');
        }

        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Note supprimée avec succès.');
    }
}
