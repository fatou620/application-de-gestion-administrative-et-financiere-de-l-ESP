<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeanceCours extends Model
{
    protected $table = 'seances_cours';

    public $timestamps = false;

    protected $fillable = [
        'matiere_id', 'niveau_id', 'jour_semaine',
        'heure_debut', 'heure_fin', 'salle', 'enseignant',
    ];

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }
}
