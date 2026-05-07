<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    public function index()
    {
        $utilisateurs = Utilisateur::with('role')->get();
        return view('admin.utilisateurs.index', compact('utilisateurs'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.utilisateurs.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'       => 'required|string|max:100',
            'prenom'    => 'required|string|max:100',
            'email'     => 'required|email|unique:utilisateurs,email',
            'role_id'   => 'required|exists:roles,id',
            'telephone' => 'nullable|string|max:20',
        ]);

        Utilisateur::create([
            'nom'        => $request->nom,
            'prenom'     => $request->prenom,
            'email'      => $request->email,
            'role_id'    => $request->role_id,
            'telephone'  => $request->telephone,
            'mot_de_passe' => Hash::make('Password123!'),
            'statut'     => 'actif',
        ]);

        return redirect()->route('admin.utilisateurs.index')
            ->with('success', 'Compte créé avec succès ! Mot de passe par défaut : Password123!');
    }

    public function edit($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $roles = Role::all();
        return view('admin.utilisateurs.edit', compact('utilisateur', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);

        $request->validate([
            'nom'       => 'required|string|max:100',
            'prenom'    => 'required|string|max:100',
            'email'     => 'required|email|unique:utilisateurs,email,' . $id,
            'role_id'   => 'required|exists:roles,id',
            'telephone' => 'nullable|string|max:20',
        ]);

        $utilisateur->update($request->only([
            'nom', 'prenom', 'email', 'role_id', 'telephone'
        ]));

        return redirect()->route('admin.utilisateurs.index')
            ->with('success', 'Compte modifié avec succès !');
    }

    public function toggleStatut($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->statut = $utilisateur->statut === 'actif' ? 'inactif' : 'actif';
        $utilisateur->save();

        return redirect()->route('admin.utilisateurs.index')
            ->with('success', 'Statut modifié avec succès !');
    }
}