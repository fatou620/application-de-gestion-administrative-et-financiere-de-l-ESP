<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etudiant extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'utilisateur_id', 'niveau_id', 'numero_etudiant',
        'date_naissance', 'lieu_naissance', 'adresse',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(DocumentNumerique::class);
    }

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }
}
