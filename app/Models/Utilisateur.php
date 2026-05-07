<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $table = 'utilisateurs';
    public $timestamps = false;

    protected $fillable = [
        'role_id',
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'telephone',
        'statut'
    ];

    protected $hidden = [
        'mot_de_passe'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}