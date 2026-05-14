<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Redirige vers le dashboard correspondant au rôle.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $route = match ($user->role?->nom) {
            'etudiant'              => 'etudiant.dashboard',
            'agent_administratif'   => 'agent.dashboard',
            'responsable_financier' => 'finance.dashboard',
            'enseignant'            => 'enseignant.dashboard',
            'admin'                 => 'admin.dashboard',
            default                 => 'login',
        };

        return redirect()->route($route);
    }
}
