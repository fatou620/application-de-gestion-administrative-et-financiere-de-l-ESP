<?php

namespace Database\Seeders;

use App\Models\DocumentNumerique;
use App\Models\Etudiant;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Paiement;
use Illuminate\Database\Seeder;

class NotesPaiementsSeeder extends Seeder
{
    public function run(): void
    {
        // Cible l'étudiant test "Mohamed KAMARA" (créé par ComptesTestSeeder)
        $etudiant = Etudiant::where('numero_etudiant', 'ESP2024001')->first();
        if (!$etudiant) return;

        $matieres = Matiere::all();

        // Notes : 1 CC + 1 examen par matière
        foreach ($matieres as $i => $m) {
            Note::updateOrCreate(
                ['etudiant_id' => $etudiant->id, 'matiere_id' => $m->id, 'type_eval' => 'cc'],
                ['valeur' => round(10 + ($i * 1.3) % 8, 2)],
            );
            Note::updateOrCreate(
                ['etudiant_id' => $etudiant->id, 'matiere_id' => $m->id, 'type_eval' => 'examen'],
                ['valeur' => round(11 + ($i * 1.7) % 7, 2)],
            );
        }

        // Paiements
        $paiements = [
            ['montant' => 250000, 'mode' => 'orange_money', 'ref' => 'ESP-ORA-20260301-12345', 'statut' => 'valide',     'date' => now()->subDays(60)],
            ['montant' => 150000, 'mode' => 'wave',         'ref' => 'ESP-WAV-20260315-67890', 'statut' => 'valide',     'date' => now()->subDays(30)],
            ['montant' => 100000, 'mode' => 'especes',      'ref' => 'ESP-ESP-20260502-11223', 'statut' => 'en_attente', 'date' => now()->subDays(5)],
        ];
        foreach ($paiements as $p) {
            Paiement::updateOrCreate(
                ['reference_trans' => $p['ref']],
                [
                    'etudiant_id'   => $etudiant->id,
                    'montant'       => $p['montant'],
                    'mode'          => $p['mode'],
                    'statut'        => $p['statut'],
                    'date_paiement' => $p['date'],
                ],
            );
        }

        // Documents
        $docs = [
            ['type' => 'Carte Nationale d\'Identité', 'statut' => 'valide'],
            ['type' => 'Diplôme du Baccalauréat',     'statut' => 'valide'],
            ['type' => 'Relevé de notes Bac+1',       'statut' => 'en_attente'],
        ];
        foreach ($docs as $d) {
            DocumentNumerique::updateOrCreate(
                ['etudiant_id' => $etudiant->id, 'type_document' => $d['type']],
                [
                    'url_fichier'       => 'uploads/documents/sample.pdf',
                    'statut_validation' => $d['statut'],
                    'date_depot'        => now()->subDays(rand(1, 30)),
                ],
            );
        }
    }
}
