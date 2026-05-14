<?php

namespace Database\Seeders;

use App\Models\Etudiant;
use App\Models\Niveau;
use App\Models\Role;
use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ComptesTestSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Role::pluck('id', 'nom')->all();
        $niveau = Niveau::where('libelle', 'L2')->first();

        // === Étudiant test ===
        $userEtu = Utilisateur::updateOrCreate(
            ['email' => 'etudiant@esp.sn'],
            [
                'role_id'      => $roles['etudiant'],
                'nom'          => 'KAMARA',
                'prenom'       => 'Mohamed',
                'mot_de_passe' => Hash::make('password'),
                'telephone'    => '77 100 00 01',
                'statut'       => 'actif',
            ],
        );
        Etudiant::updateOrCreate(
            ['utilisateur_id' => $userEtu->id],
            [
                'niveau_id'        => $niveau?->id,
                'numero_etudiant'  => 'ESP2024001',
                'date_naissance'   => '2002-05-10',
                'lieu_naissance'   => 'Dakar',
                'adresse'          => 'Liberté 6, Dakar',
            ],
        );

        // === Agent administratif ===
        Utilisateur::updateOrCreate(
            ['email' => 'agent@esp.sn'],
            [
                'role_id'      => $roles['agent_administratif'],
                'nom'          => 'DIOP',
                'prenom'       => 'Awa',
                'mot_de_passe' => Hash::make('password'),
                'telephone'    => '77 200 00 02',
                'statut'       => 'actif',
            ],
        );

        // === Responsable financier ===
        Utilisateur::updateOrCreate(
            ['email' => 'finance@esp.sn'],
            [
                'role_id'      => $roles['responsable_financier'],
                'nom'          => 'NDIAYE',
                'prenom'       => 'Fatou',
                'mot_de_passe' => Hash::make('password'),
                'telephone'    => '77 300 00 03',
                'statut'       => 'actif',
            ],
        );

        // === Enseignant ===
        Utilisateur::updateOrCreate(
            ['email' => 'enseignant@esp.sn'],
            [
                'role_id'      => $roles['enseignant'],
                'nom'          => 'SARR',
                'prenom'       => 'Ibrahima',
                'mot_de_passe' => Hash::make('password'),
                'telephone'    => '77 400 00 04',
                'statut'       => 'actif',
            ],
        );

        // === Admin système ===
        Utilisateur::updateOrCreate(
            ['email' => 'admin@esp.sn'],
            [
                'role_id'      => $roles['admin'],
                'nom'          => 'FALL',
                'prenom'       => 'Cheikh',
                'mot_de_passe' => Hash::make('password'),
                'telephone'    => '77 500 00 05',
                'statut'       => 'actif',
            ],
        );
    }
}
