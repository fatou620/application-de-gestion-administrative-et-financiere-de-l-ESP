<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Role;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [], [
            'email'    => 'adresse email',
            'password' => 'mot de passe',
        ]);

        $user = Utilisateur::where('email', $data['email'])
            ->where('statut', 'actif')
            ->first();

        if (!$user || !Hash::check($data['password'], $user->mot_de_passe)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email ou mot de passe incorrect.');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nom'             => ['required', 'string', 'max:80'],
            'prenom'          => ['required', 'string', 'max:80'],
            'email'           => ['required', 'email', 'unique:utilisateurs,email'],
            'password'        => ['required', 'string', 'min:6', 'confirmed'],
            'telephone'       => ['nullable', 'string', 'max:30'],
            'numero_etudiant' => ['required', 'string', 'max:30', 'unique:etudiants,numero_etudiant'],
            'date_naissance'  => ['nullable', 'date', 'before:today'],
        ]);

        $roleEtu = Role::where('nom', 'etudiant')->firstOrFail();

        DB::transaction(function () use ($data, $roleEtu) {
            $user = Utilisateur::create([
                'role_id'      => $roleEtu->id,
                'nom'          => strtoupper($data['nom']),
                'prenom'       => ucfirst($data['prenom']),
                'email'        => $data['email'],
                'mot_de_passe' => Hash::make($data['password']),
                'telephone'    => $data['telephone'] ?? null,
                'statut'       => 'actif',
            ]);

            Etudiant::create([
                'utilisateur_id'  => $user->id,
                'numero_etudiant' => strtoupper($data['numero_etudiant']),
                'date_naissance'  => $data['date_naissance'] ?? null,
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Compte créé avec succès. Vous pouvez vous connecter.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Vous avez été déconnecté.');
    }
}
