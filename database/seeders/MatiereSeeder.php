<?php

namespace Database\Seeders;

use App\Models\Filiere;
use App\Models\Matiere;
use Illuminate\Database\Seeder;

class MatiereSeeder extends Seeder
{
    public function run(): void
    {
        // Rattache toutes les matières à la filière Génie Logiciel
        $filiere = Filiere::where('code', 'GL')->first();
        if (!$filiere) return;

        $matieres = [
            ['nom' => 'Programmation Web',        'credits' => 6, 'coefficient' => 3.0],
            ['nom' => 'Base de Données',          'credits' => 5, 'coefficient' => 3.0],
            ['nom' => 'Algorithmes & Structures', 'credits' => 6, 'coefficient' => 4.0],
            ['nom' => 'Réseaux Informatiques',    'credits' => 4, 'coefficient' => 2.0],
            ['nom' => 'Mathématiques Discrètes',  'credits' => 4, 'coefficient' => 2.0],
            ['nom' => 'Génie Logiciel',           'credits' => 5, 'coefficient' => 3.0],
            ['nom' => 'Anglais Technique',        'credits' => 2, 'coefficient' => 1.0],
        ];

        foreach ($matieres as $m) {
            Matiere::updateOrCreate(
                ['filiere_id' => $filiere->id, 'nom' => $m['nom']],
                ['credits' => $m['credits'], 'coefficient' => $m['coefficient']],
            );
        }
    }
}
