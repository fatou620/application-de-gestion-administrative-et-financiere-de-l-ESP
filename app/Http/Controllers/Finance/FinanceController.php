<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    private const FRAIS_ANNUELS = 750000;

    public function dashboard()
    {
        $totalEncaisse = (float) Paiement::where('statut', 'valide')->sum('montant');
        $totalAttente  = (float) Paiement::where('statut', 'en_attente')->sum('montant');
        $nbPaiements   = Paiement::count();
        $nbEnAttente   = Paiement::where('statut', 'en_attente')->count();

        // Revenus par mode
        $parMode = Paiement::select('mode', DB::raw('SUM(montant) as total'), DB::raw('COUNT(*) as nb'))
            ->where('statut', 'valide')
            ->groupBy('mode')->get();

        // Revenus 7 derniers jours
        $parJour = Paiement::select(
                DB::raw('DATE(date_paiement) as jour'),
                DB::raw('SUM(montant) as total'),
            )
            ->where('statut', 'valide')
            ->where('date_paiement', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('jour')->orderBy('jour')->get();

        $paiementsRecents = Paiement::with('etudiant.utilisateur')
            ->latest('date_paiement')->limit(8)->get();

        return view('finance.dashboard', compact(
            'totalEncaisse', 'totalAttente', 'nbPaiements', 'nbEnAttente',
            'parMode', 'parJour', 'paiementsRecents',
        ));
    }

    public function paiements(Request $request)
    {
        $statut = $request->query('statut');
        $mode   = $request->query('mode');

        $q = Paiement::with('etudiant.utilisateur')->latest('date_paiement');
        if ($statut) $q->where('statut', $statut);
        if ($mode)   $q->where('mode', $mode);
        if ($search = $request->query('q')) {
            $q->where(function ($w) use ($search) {
                $w->where('reference_trans', 'like', "%$search%")
                  ->orWhereHas('etudiant', fn ($e) => $e->where('numero_etudiant', 'like', "%$search%"))
                  ->orWhereHas('etudiant.utilisateur', function ($u) use ($search) {
                      $u->where('nom', 'like', "%$search%")
                        ->orWhere('prenom', 'like', "%$search%");
                  });
            });
        }
        $paiements = $q->paginate(20)->withQueryString();

        return view('finance.paiements', compact('paiements', 'statut', 'mode'));
    }

    public function validerPaiement(Paiement $paiement)
    {
        $paiement->update([
            'statut'     => 'valide',
            'valide_par' => Auth::id(),
        ]);
        return back()->with('success', 'Paiement validé.');
    }

    public function recu(Paiement $paiement)
    {
        $paiement->load('etudiant.utilisateur');
        return view('finance.recu', compact('paiement'));
    }

    public function etudiants(Request $request)
    {
        $etudiants = Etudiant::with('utilisateur')
            ->select('etudiants.*')
            ->selectSub(
                Paiement::selectRaw('COALESCE(SUM(montant),0)')
                    ->whereColumn('etudiant_id', 'etudiants.id')
                    ->where('statut', 'valide'),
                'total_paye',
            )
            ->when($q = $request->query('q'), function ($builder) use ($q) {
                $builder->where(function ($w) use ($q) {
                    $w->where('numero_etudiant', 'like', "%$q%")
                      ->orWhereHas('utilisateur', function ($u) use ($q) {
                          $u->where('nom', 'like', "%$q%")
                            ->orWhere('prenom', 'like', "%$q%");
                      });
                });
            })
            ->paginate(15)->withQueryString();

        return view('finance.etudiants', [
            'etudiants'    => $etudiants,
            'fraisAnnuels' => self::FRAIS_ANNUELS,
        ]);
    }

    public function irregularites()
    {
        $frais = self::FRAIS_ANNUELS;

        $irreguliers = Etudiant::with('utilisateur')
            ->select('etudiants.*')
            ->selectSub(
                Paiement::selectRaw('COALESCE(SUM(montant),0)')
                    ->whereColumn('etudiant_id', 'etudiants.id')
                    ->where('statut', 'valide'),
                'total_paye',
            )
            ->havingRaw('total_paye < ?', [$frais])
            ->orderBy('total_paye', 'asc')
            ->paginate(20);

        return view('finance.irregularites', compact('irreguliers', 'frais'));
    }

    public function rapport()
    {
        $totalEncaisse = (float) Paiement::where('statut', 'valide')->sum('montant');
        $totalAttendu  = Etudiant::count() * self::FRAIS_ANNUELS;
        $tauxRecouv    = $totalAttendu > 0 ? round($totalEncaisse / $totalAttendu * 100, 1) : 0;

        $parMode = Paiement::select('mode',
                DB::raw('SUM(montant) as total'),
                DB::raw('COUNT(*) as nb'),
            )
            ->where('statut', 'valide')
            ->groupBy('mode')->get();

        $parMois = Paiement::select(
                DB::raw("DATE_FORMAT(date_paiement, '%Y-%m') as mois"),
                DB::raw('SUM(montant) as total'),
                DB::raw('COUNT(*) as nb'),
            )
            ->where('statut', 'valide')
            ->groupBy('mois')->orderBy('mois')->get();

        return view('finance.rapport', compact(
            'totalEncaisse', 'totalAttendu', 'tauxRecouv',
            'parMode', 'parMois',
        ));
    }
}
