<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DossierCandidature extends Model
{
    protected $table = 'dossiers_candidature';

    protected $fillable = [
        'candidat_id', 'type_piece', 'url_fichier',
        'statut', 'commentaire', 'date_depot',
    ];

    protected $casts = [
        'date_depot' => 'datetime',
    ];

    public function candidat(): BelongsTo
    {
        return $this->belongsTo(Candidat::class);
    }
}
