<?php

namespace Database\Seeders;

use App\Models\Departement;
use App\Models\Filiere;
use App\Models\Niveau;
use Illuminate\Database\Seeder;

class StructureAcademiqueSeeder extends Seeder
{
    public function run(): void
    {
        // Structure : Département => Code => [ Filière (code) => [niveaux] ]
        $structure = [
            ['GI', 'Génie Informatique', [
                ['GL',  'Génie Logiciel',         ['L1', 'L2', 'L3', 'M1', 'M2']],
                ['RS',  'Réseaux & Systèmes',     ['L1', 'L2', 'L3', 'M1', 'M2']],
            ]],
            ['GE', 'Génie Électrique', [
                ['ELN', 'Électronique',           ['L1', 'L2', 'L3']],
                ['ENR', 'Énergie Renouvelable',   ['L1', 'L2', 'L3']],
            ]],
            ['GC', 'Génie Civil', [
                ['BTP', 'Bâtiment & Travaux Publics', ['L1', 'L2', 'L3']],
            ]],
        ];

        foreach ($structure as [$deptCode, $deptNom, $filieres]) {
            $dept = Departement::updateOrCreate(
                ['code' => $deptCode],
                ['nom' => $deptNom],
            );
            foreach ($filieres as [$filCode, $filNom, $niveaux]) {
                $filiere = Filiere::updateOrCreate(
                    ['code' => $filCode],
                    ['departement_id' => $dept->id, 'nom' => $filNom],
                );
                foreach ($niveaux as $libelle) {
                    Niveau::updateOrCreate(
                        ['filiere_id' => $filiere->id, 'libelle' => $libelle],
                    );
                }
            }
        }
    }
}
