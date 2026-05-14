<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nom' => 'etudiant',              'description' => 'Étudiant inscrit'],
            ['nom' => 'enseignant',            'description' => 'Enseignant'],
            ['nom' => 'agent_administratif',   'description' => 'Agent administratif / scolarité'],
            ['nom' => 'responsable_financier', 'description' => 'Responsable financier'],
            ['nom' => 'admin',                 'description' => 'Administrateur système'],
        ];

        foreach ($roles as $r) {
            Role::updateOrCreate(['nom' => $r['nom']], $r);
        }
    }
}
