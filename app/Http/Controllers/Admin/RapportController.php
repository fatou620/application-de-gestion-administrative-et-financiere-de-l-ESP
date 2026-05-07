<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Models\Role;

class RapportController extends Controller
{
    public function index()
    {
        $totalUtilisateurs = Utilisateur::count();
        $totalActifs = Utilisateur::where('statut', 'actif')->count();
        $totalInactifs = Utilisateur::where('statut', 'inactif')->count();
        $totalRoles = Role::count();

        $utilisateursParRole = Role::withCount('utilisateurs')->get();

        $tauxActivite = $totalUtilisateurs > 0 
            ? round(($totalActifs / $totalUtilisateurs) * 100, 1) 
            : 0;

        return view('admin.rapports.index', compact(
            'totalUtilisateurs',
            'totalActifs',
            'totalInactifs',
            'totalRoles',
            'utilisateursParRole',
            'tauxActivite'
        ));
    }
}