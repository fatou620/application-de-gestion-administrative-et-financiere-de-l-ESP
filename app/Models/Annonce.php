<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Annonce extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'niveau_id', 'auteur_id', 'titre', 'contenu',
        'priorite', 'cible', 'date_publication',
    ];

    protected $casts = [
        'date_publication' => 'datetime',
    ];

    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }

    public function auteur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'auteur_id');
    }
}
