<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\DocumentNumerique;
use App\Models\Note;
use App\Models\Paiement;
use App\Models\SeanceCours;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $etudiant = Auth::user()->etudiant;
        abort_unless($etudiant, 403, 'Profil étudiant introuvable.');

        $notesRecentes = Note::with('matiere')
            ->where('etudiant_id', $etudiant->id)
            ->latest('id')->limit(5)->get();

        $moyenne = Note::where('etudiant_id', $etudiant->id)->avg('valeur');
        $totalNotes = Note::where('etudiant_id', $etudiant->id)->count();

        $paiements = Paiement::where('etudiant_id', $etudiant->id)
            ->latest('date_paiement')->limit(3)->get();
        $totalPaye = Paiement::where('etudiant_id', $etudiant->id)->sum('montant');

        $annonces = Annonce::whereIn('cible', ['tous', 'etudiants'])
            ->latest('date_publication')->limit(3)->get();

        $joursFr = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
        $jourAujourdhui = $joursFr[now()->dayOfWeek];

        $coursAujourdhui = SeanceCours::with('matiere')
            ->where('jour_semaine', $jourAujourdhui)
            ->orderBy('heure_debut')->limit(3)->get();

        $documents = DocumentNumerique::where('etudiant_id', $etudiant->id)
            ->latest('date_depot')->limit(5)->get();

        return view('etudiant.dashboard', compact(
            'etudiant', 'notesRecentes', 'moyenne', 'totalNotes',
            'paiements', 'totalPaye', 'annonces',
            'jourAujourdhui', 'coursAujourdhui', 'documents',
        ));
    }
}
