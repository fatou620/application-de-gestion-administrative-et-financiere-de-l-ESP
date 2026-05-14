<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\DocumentNumerique;
use App\Models\Note;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;
        abort_unless($etudiant, 403);

        $stats = [
            'nb_notes'     => Note::where('etudiant_id', $etudiant->id)->count(),
            'nb_paiements' => Paiement::where('etudiant_id', $etudiant->id)->count(),
            'nb_docs'      => DocumentNumerique::where('etudiant_id', $etudiant->id)->count(),
            'moyenne'      => round((float) Note::where('etudiant_id', $etudiant->id)->avg('valeur'), 2),
        ];

        return view('etudiant.profil', compact('user', 'etudiant', 'stats'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'telephone'   => ['nullable', 'string', 'max:30'],
            'photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'notif_email' => ['nullable', 'boolean'],
            'notif_sms'   => ['nullable', 'boolean'],
        ]);

        $user->telephone   = $data['telephone'] ?? null;
        $user->notif_email = $request->boolean('notif_email');
        $user->notif_sms   = $request->boolean('notif_sms');

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('avatars', 'public');
        }

        $user->save();

        return redirect()->route('etudiant.profil')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'ancien_pw'  => ['required'],
            'nouveau_pw' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!Hash::check($data['ancien_pw'], $user->mot_de_passe)) {
            return back()->with('error', 'Ancien mot de passe incorrect.');
        }

        $user->mot_de_passe = Hash::make($data['nouveau_pw']);
        $user->save();

        return redirect()->route('etudiant.profil')
            ->with('success', 'Mot de passe modifié avec succès.');
    }
}
