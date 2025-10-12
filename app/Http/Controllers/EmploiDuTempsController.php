<?php
namespace App\Http\Controllers;

use App\Models\EmploiDuTemps;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmploiDuTempsController extends Controller
{
    public function index()
    {
        $emplois = EmploiDuTemps::with('matiere')
            ->where('user_id', Auth::id())
            ->orderBy('jour')
            ->orderBy('heure_debut')
            ->get()
            ->groupBy('jour');

        return view('planning.index', compact('emplois'));
    }

    public function create()
    {
        $matieres = Matiere::where('user_id', Auth::id())->get();
        return view('planning.create', compact('matieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matiere_id' => 'nullable|exists:matieres,id',
            'jour' => 'required|string|max:20',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'salle' => 'nullable|string|max:50',
        ]);

        EmploiDuTemps::create([
            'user_id' => Auth::id(),
            'matiere_id' => $request->matiere_id,
            'jour' => $request->jour,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
            'salle' => $request->salle,
        ]);

        return redirect()->route('planning.index')->with('success', 'Créneau ajouté avec succès.');
    }

    // ⚡ On change le paramètre pour correspondre au binding automatique
    public function edit(EmploiDuTemps $planning)
    {
        if ($planning->user_id !== Auth::id()) {
            return redirect()->route('planning.index')->with('error', 'Vous n’êtes pas autorisé à modifier ce créneau.');
        }

        $matieres = Matiere::where('user_id', Auth::id())->get();
        return view('planning.edite', compact('planning', 'matieres'));
    }

    public function update(Request $request, EmploiDuTemps $planning)
    {
        if ($planning->user_id !== Auth::id()) {
            return redirect()->route('planning.index')->with('error', 'Vous n’êtes pas autorisé à modifier ce créneau.');
        }

        $request->validate([
            'matiere_id' => 'nullable|exists:matieres,id',
            'jour' => 'required|string|max:20',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'salle' => 'nullable|string|max:50',
        ]);

        $planning->update($request->only('matiere_id', 'jour', 'heure_debut', 'heure_fin', 'salle'));

        return redirect()->route('planning.index')->with('success', 'Créneau mis à jour avec succès.');
    }

    public function destroy(EmploiDuTemps $planning)
    {
        if ($planning->user_id !== Auth::id()) {
            return redirect()->route('planning.index')->with('error', 'Vous n’êtes pas autorisé à supprimer ce créneau.');
        }

        $planning->delete();
        return redirect()->route('planning.index')->with('success', 'Créneau supprimé avec succès.');
    }
}
