<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmploiDuTemps extends Model
{
    use HasFactory;

    // Définir explicitement le nom de la table
    protected $table = 'emplois_du_temps';

    protected $fillable = [
        'user_id',
        'matiere_id',
        'jour',
        'heure_debut',
        'heure_fin',
        'salle',
    ];

    // Relation avec Matiere
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}
