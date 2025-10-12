<?php

namespace App\Http\Controllers;

use App\Models\Devoir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevoirController extends Controller
{
    public function __construct()
    {
        // Toutes les routes nécessitent l'authentification
        $this->middleware('auth');
    }

    // Liste des devoirs de l'utilisateur (triés par date_limite croissante)
    public function index()
    {
        $user = Auth::user();
        $devoirs = Devoir::where('user_id', $user->id)
                    ->orderByRaw('CASE WHEN date_limite IS NULL THEN 1 ELSE 0 END') // nulls last
                    ->orderBy('date_limite', 'asc')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('devoirs.index', compact('devoirs'));
    }

    // Affiche le formulaire de création (optionnel si on intègre le form sur index)
    public function create()
    {
        return view('devoirs.create');
    }

    // Enregistre un nouveau devoir
    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_limite' => 'nullable|date',
        ]);

        $data['user_id'] = Auth::id();
        $data['statut'] = 'a_faire';

        Devoir::create($data);

        return redirect()->route('devoirs.index')->with('success', 'Devoir ajouté.');
    }

    // Formulaire édition
    public function edit(Devoir $devoir)
    {
        // sécurité : appartient à l'utilisateur
        if ($devoir->user_id !== Auth::id()) {
            abort(403);
        }

        return view('devoirs.edit', compact('devoir'));
    }

    // Mettre à jour
    public function update(Request $request, Devoir $devoir)
    {
        if ($devoir->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_limite' => 'nullable|date',
            'statut' => 'nullable|in:a_faire,termine',
        ]);

        $devoir->update($data);

        return redirect()->route('devoirs.index')->with('success', 'Devoir mis à jour.');
    }

    // Supprimer
    public function destroy(Devoir $devoir)
    {
        if ($devoir->user_id !== Auth::id()) {
            abort(403);
        }

        $devoir->delete();
        return redirect()->route('devoirs.index')->with('success', 'Devoir supprimé.');
    }

    // Route pour toggler statut (optionnel, facilite l'UX)
    public function toggleStatut(Devoir $devoir)
    {
        if ($devoir->user_id !== Auth::id()) {
            abort(403);
        }

        $devoir->statut = $devoir->statut === 'a_faire' ? 'termine' : 'a_faire';
        $devoir->save();

        return redirect()->route('devoirs.index')->with('success', 'Statut mis à jour.');
    }
}
