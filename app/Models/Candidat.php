<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidat extends Model
{
    protected $fillable = [
        'numero_candidature', 'nom', 'prenom', 'email', 'telephone',
        'date_naissance', 'lieu_naissance', 'diplome',
        'filiere_voulue_id', 'statut', 'motif_rejet',
        'traite_par', 'date_traitement',
    ];

    protected $casts = [
        'date_naissance'  => 'date',
        'date_traitement' => 'datetime',
    ];

    public function filiereVoulue(): BelongsTo
    {
        return $this->belongsTo(Filiere::class, 'filiere_voulue_id');
    }

    public function traiteur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'traite_par');
    }

    public function dossier(): HasMany
    {
        return $this->hasMany(DossierCandidature::class);
    }
}
