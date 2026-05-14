<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $etudiant = Auth::user()->etudiant;
        abort_unless($etudiant, 403);

        $notes = Note::with('matiere')
            ->where('etudiant_id', $etudiant->id)
            ->get();

        // Regrouper par matière
        $matieres = [];
        foreach ($notes as $n) {
            $mid = $n->matiere_id;
            if (!isset($matieres[$mid])) {
                $matieres[$mid] = [
                    'nom'         => $n->matiere->nom,
                    'coefficient' => $n->matiere->coefficient,
                    'credits'     => $n->matiere->credits,
                    'cc'          => null,
                    'examen'      => null,
                    'moyenne'     => null,
                ];
            }
            $matieres[$mid][$n->type_eval] = (float) $n->valeur;
        }

        // Calcul moyenne pondérée (CC 40% + Examen 60%)
        $totalPondere = 0; $totalCoeff = 0;
        foreach ($matieres as $mid => &$m) {
            $cc = $m['cc']; $ex = $m['examen'];
            if ($cc !== null && $ex !== null) {
                $m['moyenne'] = round($cc * 0.4 + $ex * 0.6, 2);
            } elseif ($ex !== null) {
                $m['moyenne'] = $ex;
            } elseif ($cc !== null) {
                $m['moyenne'] = $cc;
            }
            if ($m['moyenne'] !== null) {
                $totalPondere += $m['moyenne'] * $m['coefficient'];
                $totalCoeff   += $m['coefficient'];
            }
        }
        unset($m);

        $moyGen = $totalCoeff > 0 ? round($totalPondere / $totalCoeff, 2) : null;
        $mention = match (true) {
            $moyGen === null    => '—',
            $moyGen >= 16       => 'Très Bien',
            $moyGen >= 14       => 'Bien',
            $moyGen >= 12       => 'Assez Bien',
            $moyGen >= 10       => 'Passable',
            default             => 'Insuffisant',
        };

        return view('etudiant.notes', [
            'matieres'  => $matieres,
            'moyGen'    => $moyGen,
            'mention'   => $mention,
            'totalNotes'=> $notes->count(),
        ]);
    }
}
