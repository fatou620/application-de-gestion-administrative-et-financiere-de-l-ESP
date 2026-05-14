<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    private const FRAIS_ANNUELS = 750000;

    public function index()
    {
        $etudiant = Auth::user()->etudiant;
        abort_unless($etudiant, 403);

        $historique = Paiement::where('etudiant_id', $etudiant->id)
            ->latest('date_paiement')->get();

        $totalPaye = (float) $historique->sum('montant');
        $solde = max(0, self::FRAIS_ANNUELS - $totalPaye);

        return view('etudiant.paiements', [
            'historique'   => $historique,
            'totalPaye'    => $totalPaye,
            'solde'        => $solde,
            'fraisAnnuels' => self::FRAIS_ANNUELS,
        ]);
    }

    public function store(Request $request)
    {
        $etudiant = Auth::user()->etudiant;
        abort_unless($etudiant, 403);

        $data = $request->validate([
            'montant'   => ['required', 'numeric', 'min:1000'],
            'mode'      => ['required', 'in:orange_money,wave,especes'],
            'telephone' => ['nullable', 'string', 'max:30'],
        ]);

        $ref = 'ESP-' . strtoupper(substr($data['mode'], 0, 3)) . '-' . now()->format('Ymd') . '-' . random_int(10000, 99999);

        Paiement::create([
            'etudiant_id'     => $etudiant->id,
            'montant'         => $data['montant'],
            'mode'            => $data['mode'],
            'reference_trans' => $ref,
            'statut'          => 'en_attente', // sera validé par le responsable financier
            'date_paiement'   => now(),
        ]);

        return redirect()->route('etudiant.paiements')
            ->with('success', sprintf(
                'Paiement de %s FCFA enregistré. Référence : %s (en attente de validation)',
                number_format($data['montant'], 0, ',', ' '),
                $ref,
            ));
    }
}
