<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Models\Role;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUtilisateurs = Utilisateur::count();
        $totalActifs = Utilisateur::where('statut', 'actif')->count();
        $totalInactifs = Utilisateur::where('statut', 'inactif')->count();
        $totalRoles = Role::count();
        $derniersUtilisateurs = Utilisateur::with('role')->latest('id')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUtilisateurs',
            'totalActifs',
            'totalInactifs',
            'totalRoles',
            'derniersUtilisateurs'
        ));
    }
}