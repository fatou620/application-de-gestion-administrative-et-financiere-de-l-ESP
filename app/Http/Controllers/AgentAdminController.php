<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Candidat;
use App\Models\DocumentNumerique;
use App\Models\Filiere;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentAdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'candidatures_total'   => Candidat::count(),
            'candidatures_attente' => Candidat::whereIn('statut', ['nouveau', 'en_cours'])->count(),
            'candidatures_valides' => Candidat::where('statut', 'valide')->count(),
            'candidatures_rejets'  => Candidat::where('statut', 'rejete')->count(),

            'inscriptions_attente' => Inscription::where('statut', 'en_attente')->count(),
            'inscriptions_validees'=> Inscription::where('statut', 'validee')->count(),

            'docs_attente' => DocumentNumerique::where('statut_validation', 'en_attente')->count(),
        ];

        $candidatsRecents = Candidat::latest()->limit(6)->get();
        $docsRecents = DocumentNumerique::with('etudiant.utilisateur')
            ->where('statut_validation', 'en_attente')
            ->latest('date_depot')->limit(6)->get();

        return view('agent.dashboard', compact('stats', 'candidatsRecents', 'docsRecents'));
    }

    // ───── Candidatures ─────
    public function candidatures(Request $request)
    {
        $statut = $request->query('statut');
        $q = Candidat::with('filiereVoulue')->latest();
        if ($statut) $q->where('statut', $statut);
        if ($search = $request->query('q')) {
            $q->where(function ($w) use ($search) {
                $w->where('nom', 'like', "%$search%")
                  ->orWhere('prenom', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('numero_candidature', 'like', "%$search%");
            });
        }
        $candidats = $q->paginate(15)->withQueryString();

        return view('agent.candidatures', compact('candidats', 'statut'));
    }

    public function showCandidature(Candidat $candidat)
    {
        $candidat->load('filiereVoulue', 'dossier');
        return view('agent.candidature-show', compact('candidat'));
    }

    public function validerCandidature(Candidat $candidat)
    {
        $candidat->update([
            'statut'           => 'valide',
            'traite_par'       => Auth::id(),
            'date_traitement'  => now(),
            'motif_rejet'      => null,
        ]);
        return back()->with('success', 'Candidature validée.');
    }

    public function rejeterCandidature(Request $request, Candidat $candidat)
    {
        $data = $request->validate(['motif' => ['required', 'string', 'max:500']]);
        $candidat->update([
            'statut'           => 'rejete',
            'traite_par'       => Auth::id(),
            'date_traitement'  => now(),
            'motif_rejet'      => $data['motif'],
        ]);
        return back()->with('success', 'Candidature rejetée.');
    }

    // ───── Inscriptions ─────
    public function inscriptions()
    {
        $inscriptions = Inscription::with(['etudiant.utilisateur', 'niveau.filiere'])
            ->latest()->paginate(15);
        return view('agent.inscriptions', compact('inscriptions'));
    }

    public function validerInscription(Inscription $inscription)
    {
        $inscription->update([
            'statut'          => 'validee',
            'valide_par'      => Auth::id(),
            'date_validation' => now(),
        ]);
        return back()->with('success', 'Inscription validée.');
    }

    // ───── Documents ─────
    public function documents(Request $request)
    {
        $statut = $request->query('statut', 'en_attente');
        $documents = DocumentNumerique::with('etudiant.utilisateur')
            ->when($statut, fn ($q) => $q->where('statut_validation', $statut))
            ->latest('date_depot')->paginate(15)->withQueryString();
        return view('agent.documents', compact('documents', 'statut'));
    }

    public function validerDocument(DocumentNumerique $doc)
    {
        $doc->update([
            'statut_validation' => 'valide',
            'valide_par'        => Auth::id(),
            'date_validation'   => now(),
        ]);
        return back()->with('success', 'Document validé.');
    }

    public function rejeterDocument(Request $request, DocumentNumerique $doc)
    {
        $data = $request->validate(['commentaire' => ['required', 'string', 'max:500']]);
        $doc->update([
            'statut_validation' => 'rejete',
            'commentaire'       => $data['commentaire'],
            'valide_par'        => Auth::id(),
            'date_validation'   => now(),
        ]);
        return back()->with('success', 'Document rejeté.');
    }

    // ───── Annonces ─────
    public function annonces()
    {
        $annonces = Annonce::latest('date_publication')->paginate(10);
        return view('agent.annonces', compact('annonces'));
    }

    public function storeAnnonce(Request $request)
    {
        $data = $request->validate([
            'titre'    => ['required', 'string', 'max:200'],
            'contenu'  => ['required', 'string'],
            'priorite' => ['required', 'in:normale,urgente'],
            'cible'    => ['required', 'in:tous,etudiants,enseignants,agent_administratif'],
        ]);
        Annonce::create($data + [
            'auteur_id'        => Auth::id(),
            'date_publication' => now(),
        ]);
        return redirect()->route('agent.annonces')->with('success', 'Annonce publiée.');
    }

    public function destroyAnnonce(Annonce $ann)
    {
        $ann->delete();
        return back()->with('success', 'Annonce supprimée.');
    }
}
