<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matiere extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'coefficient', 'semestre_id', 'user_id'];

    public function semestre() {
        return $this->belongsTo(Semestre::class);
    }

     // Relation vers les notes
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}