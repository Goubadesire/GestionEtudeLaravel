<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devoir extends Model
{
    use HasFactory;

    protected $table = 'devoirs';

    protected $fillable = [
        'user_id',
        'titre',
        'description',
        'date_limite',
        'statut',
    ];

    // Relation : appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function isTermine(): bool
    {
        return $this->statut === 'termine';
    }
}
