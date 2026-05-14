<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Filiere extends Model
{
    public $timestamps = false;

    protected $fillable = ['departement_id', 'nom', 'code'];

    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }

    public function niveaux(): HasMany
    {
        return $this->hasMany(Niveau::class);
    }
}
