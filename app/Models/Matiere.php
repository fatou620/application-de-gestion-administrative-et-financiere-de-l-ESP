<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matiere extends Model
{
    public $timestamps = false;

    protected $fillable = ['filiere_id', 'nom', 'credits', 'coefficient'];

    protected $casts = [
        'coefficient' => 'decimal:1',
    ];

    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function seances(): HasMany
    {
        return $this->hasMany(SeanceCours::class);
    }
}
