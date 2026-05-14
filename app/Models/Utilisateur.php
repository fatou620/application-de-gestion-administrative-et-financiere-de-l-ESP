<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'utilisateurs';

    public $timestamps = false;

    protected $fillable = [
        'role_id', 'nom', 'prenom', 'email', 'mot_de_passe',
        'telephone', 'photo', 'notif_email', 'notif_sms', 'statut',
    ];

    protected $hidden = ['mot_de_passe', 'remember_token'];

    protected function casts(): array
    {
        return [
            'mot_de_passe' => 'hashed',
            'notif_email'  => 'boolean',
            'notif_sms'    => 'boolean',
        ];
    }

    public function getAuthPassword(): string
    {
        return $this->mot_de_passe;
    }

    public function getAuthPasswordName(): string
    {
        return 'mot_de_passe';
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function etudiant(): HasOne
    {
        return $this->hasOne(Etudiant::class, 'utilisateur_id');
    }

    public function hasRole(string $nom): bool
    {
        return $this->role?->nom === $nom;
    }

    public function hasAnyRole(array $noms): bool
    {
        return in_array($this->role?->nom, $noms, true);
    }

    public function getNomCompletAttribute(): string
    {
        return trim($this->prenom . ' ' . $this->nom);
    }
}
