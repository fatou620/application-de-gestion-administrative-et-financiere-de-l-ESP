<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentNumerique extends Model
{
    protected $table = 'documents_numeriques';

    public $timestamps = false;

    protected $fillable = [
        'etudiant_id', 'type_document', 'url_fichier',
        'statut_validation', 'commentaire', 'valide_par',
        'date_depot', 'date_validation',
    ];

    protected $casts = [
        'date_depot'      => 'datetime',
        'date_validation' => 'datetime',
    ];

    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function validateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'valide_par');
    }
}
