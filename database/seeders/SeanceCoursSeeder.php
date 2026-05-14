<?php

namespace Database\Seeders;

use App\Models\Matiere;
use App\Models\SeanceCours;
use Illuminate\Database\Seeder;

class SeanceCoursSeeder extends Seeder
{
    public function run(): void
    {
        $matieres = Matiere::pluck('id', 'nom')->all();
        if (empty($matieres)) return;

        $seances = [
            ['Programmation Web',        'Lundi',    '08:00', '10:00', 'A101', 'M. SARR'],
            ['Base de Données',          'Lundi',    '10:15', '12:15', 'A101', 'Mme DIOP'],
            ['Algorithmes & Structures', 'Mardi',    '08:00', '11:00', 'B202', 'M. FALL'],
            ['Réseaux Informatiques',    'Mardi',    '14:00', '16:00', 'A203', 'M. KA'],
            ['Mathématiques Discrètes',  'Mercredi', '08:00', '10:00', 'C301', 'Mme BA'],
            ['Génie Logiciel',           'Mercredi', '14:00', '17:00', 'A101', 'M. SARR'],
            ['Anglais Technique',        'Jeudi',    '10:00', '12:00', 'L01',  'Ms SMITH'],
            ['Programmation Web',        'Vendredi', '14:00', '17:00', 'TP1',  'M. SARR'],
        ];

        foreach ($seances as [$matNom, $jour, $debut, $fin, $salle, $ens]) {
            if (!isset($matieres[$matNom])) continue;
            SeanceCours::updateOrCreate(
                [
                    'matiere_id'   => $matieres[$matNom],
                    'jour_semaine' => $jour,
                    'heure_debut'  => $debut,
                ],
                [
                    'heure_fin'  => $fin,
                    'salle'      => $salle,
                    'enseignant' => $ens,
                ],
            );
        }
    }
}
