<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Models\Role;

class SurveillanceController extends Controller
{
    public function index()
    {
        $infos = [
            'php_version'    => phpversion(),
            'laravel_version'=> app()->version(),
            'os'             => php_uname(),
            'memoire_limite' => ini_get('memory_limit'),
            'memoire_utilisee' => round(memory_get_usage() / 1024 / 1024, 2) . ' MB',
            'uptime'         => now()->format('d/m/Y H:i:s'),
            'db_status'      => $this->checkDatabase(),
            'total_users'    => Utilisateur::count(),
            'users_actifs'   => Utilisateur::where('statut', 'actif')->count(),
            'total_roles'    => Role::count(),
        ];

        return view('admin.surveillance.index', compact('infos'));
    }

    private function checkDatabase()
    {
        try {
            \DB::connection()->getPdo();
            return 'Connecté ✅';
        } catch (\Exception $e) {
            return 'Déconnecté ❌';
        }
    }
}