<?php

namespace Database\Seeders;

use App\Models\Annonce;
use Illuminate\Database\Seeder;

class AnnonceSeeder extends Seeder
{
    public function run(): void
    {
        $annonces = [
            [
                'titre'    => 'Reprise des cours après les congés',
                'contenu'  => 'Les cours reprennent le lundi 19 mai à 8h00. Merci de vous présenter à l\'heure.',
                'priorite' => 'normale',
                'cible'    => 'etudiants',
            ],
            [
                'titre'    => 'Échéance paiement scolarité',
                'contenu'  => 'La date limite de paiement de la 2ᵉ tranche est fixée au 31 mai. Au-delà, des pénalités s\'appliquent.',
                'priorite' => 'urgente',
                'cible'    => 'tous',
            ],
            [
                'titre'    => 'Inscriptions année 2026-2027 ouvertes',
                'contenu'  => 'Les candidatures pour la nouvelle année académique sont ouvertes du 1er juin au 15 juillet.',
                'priorite' => 'normale',
                'cible'    => 'tous',
            ],
        ];

        foreach ($annonces as $a) {
            Annonce::updateOrCreate(['titre' => $a['titre']], $a + ['date_publication' => now()]);
        }
    }
}
