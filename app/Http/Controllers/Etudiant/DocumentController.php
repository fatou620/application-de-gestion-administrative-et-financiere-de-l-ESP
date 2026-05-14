<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\DocumentNumerique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $etudiant = Auth::user()->etudiant;
        abort_unless($etudiant, 403);

        $documents = DocumentNumerique::where('etudiant_id', $etudiant->id)
            ->latest('date_depot')->get();

        return view('etudiant.documents', compact('documents'));
    }

    public function store(Request $request)
    {
        $etudiant = Auth::user()->etudiant;
        abort_unless($etudiant, 403);

        $data = $request->validate([
            'libelle' => ['required', 'string', 'max:120'],
            'fichier' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $path = $request->file('fichier')->store('documents', 'public');

        DocumentNumerique::create([
            'etudiant_id'       => $etudiant->id,
            'type_document'     => $data['libelle'],
            'url_fichier'       => $path,
            'statut_validation' => 'en_attente',
            'date_depot'        => now(),
        ]);

        return redirect()->route('etudiant.documents')
            ->with('success', 'Document importé avec succès.');
    }

    public function destroy(DocumentNumerique $doc)
    {
        $etudiant = Auth::user()->etudiant;
        abort_unless($etudiant && $doc->etudiant_id === $etudiant->id, 403);

        if ($doc->url_fichier && Storage::disk('public')->exists($doc->url_fichier)) {
            Storage::disk('public')->delete($doc->url_fichier);
        }
        $doc->delete();

        return redirect()->route('etudiant.documents')
            ->with('success', 'Document supprimé.');
    }
}
