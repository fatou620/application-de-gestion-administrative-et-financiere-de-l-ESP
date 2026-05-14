<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\SeanceCours;

class EmploiAnnonceController extends Controller
{
    public function index()
    {
        $seances = SeanceCours::with('matiere')
            ->orderByRaw("FIELD(jour_semaine,'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi')")
            ->orderBy('heure_debut')
            ->get();

        $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
        $emploi = array_fill_keys($jours, []);
        foreach ($seances as $s) {
            $emploi[$s->jour_semaine][] = $s;
        }

        $annonces = Annonce::whereIn('cible', ['tous', 'etudiants'])
            ->latest('date_publication')->get();

        $joursFr = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
        $jourAujourdhui = $joursFr[now()->dayOfWeek];

        return view('etudiant.emploi', compact('jours', 'emploi', 'annonces', 'jourAujourdhui'));
    }
}
