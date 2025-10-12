<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $matieres = Matiere::with(['notes' => fn($q) => $q->where('user_id', Auth::id())])
            ->where('user_id', Auth::id())
            ->get();

        // Moyenne générale
        $totalCoef = $matieres->sum(fn($m) => $m->notes->sum('coef'));
        $totalNotes = $matieres->sum(fn($m) => $m->notes->sum(fn($n) => $n->valeur * $n->coef));
        $moyenneGenerale = $totalCoef ? $totalNotes / $totalCoef : null;

        // Moyennes par semestre
        $semestres = $matieres->groupBy(fn($m) => $m->semestre?->nom ?? 'Non attribué');
        $moyennesSemestres = [];
        foreach ($semestres as $nom => $matieresSemestre) {
            $totalCoefSem = $matieresSemestre->sum(fn($m) => $m->notes->sum('coef'));
            $totalNotesSem = $matieresSemestre->sum(fn($m) => $m->notes->sum(fn($n) => $n->valeur * $n->coef));
            $moyennesSemestres[$nom] = $totalCoefSem ? $totalNotesSem / $totalCoefSem : null;
        }

        // Nombre de notes par matière
        $notesParMatiere = [];
        foreach ($matieres as $m) {
            $notesParMatiere[$m->nom] = $m->notes->count();
        }

        return view('dashboard.index', compact('matieres', 'moyenneGenerale', 'moyennesSemestres', 'notesParMatiere'));
    }
}
