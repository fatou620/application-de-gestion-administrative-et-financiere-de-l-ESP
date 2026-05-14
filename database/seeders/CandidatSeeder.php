<?php

namespace Database\Seeders;

use App\Models\Candidat;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\Etudiant;
use App\Models\Niveau;
use Illuminate\Database\Seeder;

class CandidatSeeder extends Seeder
{
    public function run(): void
    {
        $filieres = Filiere::pluck('id', 'nom');

        $candidats = [
            ['SARR',  'Aminata',  'aminata.sarr@gmail.com',   '77 111 11 11', '2003-03-12', 'Dakar',       'Bac+2', 'Génie Logiciel',          'nouveau'],
            ['CISSÉ', 'Ousmane',  'ousmane.cisse@gmail.com',  '77 222 22 22', '2002-07-25', 'Thiès',       'Bac+2', 'Réseaux & Systèmes',      'en_cours'],
            ['BA',    'Khadidja', 'khadidja.ba@gmail.com',    '77 333 33 33', '2003-11-04', 'Saint-Louis', 'Bac+3', 'Génie Logiciel',          'valide'],
            ['NDOYE', 'Cheikh',   'cheikh.ndoye@gmail.com',   '77 444 44 44', '2001-02-19', 'Mbour',       'Bac+2', 'Électronique',            'incomplet'],
            ['FALL',  'Mariama',  'mariama.fall@gmail.com',   '77 555 55 55', '2003-09-30', 'Diourbel',    'Bac+2', 'Bâtiment & Travaux Publics', 'rejete'],
            ['DIOUF', 'Lamine',   'lamine.diouf@gmail.com',   '77 666 66 66', '2002-12-08', 'Kaolack',     'Bac+2', 'Énergie Renouvelable',    'nouveau'],
            ['SOW',   'Astou',    'astou.sow@gmail.com',      '77 777 77 77', '2003-06-15', 'Ziguinchor',  'Bac+2', 'Génie Logiciel',          'nouveau'],
            ['GAYE',  'Modou',    'modou.gaye@gmail.com',     '77 888 88 88', '2001-05-22', 'Tambacounda', 'Bac+3', 'Réseaux & Systèmes',      'en_cours'],
        ];

        foreach ($candidats as [$nom, $prenom, $email, $tel, $dn, $lieu, $diplome, $filiere, $statut]) {
            Candidat::updateOrCreate(
                ['email' => $email],
                [
                    'numero_candidature' => 'CAND-' . now()->format('Y') . '-' . str_pad((string) random_int(100, 999), 3, '0', STR_PAD_LEFT) . '-' . substr(strtoupper($nom), 0, 3),
                    'nom'                => $nom,
                    'prenom'             => $prenom,
                    'telephone'          => $tel,
                    'date_naissance'     => $dn,
                    'lieu_naissance'     => $lieu,
                    'diplome'            => $diplome,
                    'filiere_voulue_id'  => $filieres[$filiere] ?? null,
                    'statut'             => $statut,
                    'motif_rejet'        => $statut === 'rejete' ? 'Dossier incomplet — diplôme non conforme aux exigences de la filière demandée.' : null,
                    'date_traitement'    => in_array($statut, ['valide', 'rejete', 'incomplet']) ? now()->subDays(rand(1, 20)) : null,
                ],
            );
        }

        // Quelques inscriptions en attente
        $etudiant = Etudiant::first();
        $niveau = Niveau::where('libelle', 'L2')->first();
        if ($etudiant && $niveau) {
            Inscription::updateOrCreate(
                ['etudiant_id' => $etudiant->id, 'annee_academique' => '2026-2027'],
                [
                    'niveau_id'       => $niveau->id,
                    'statut'          => 'en_attente',
                    'frais_scolarite' => 750000,
                ],
            );
        }
    }
}
