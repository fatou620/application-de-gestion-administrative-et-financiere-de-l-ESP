<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SauvegardeController extends Controller
{
    public function index()
    {
        $sauvegardes = $this->listerSauvegardes();
        return view('admin.sauvegardes.index', compact('sauvegardes'));
    }

    public function creer()
    {
        $dossier = storage_path('app/sauvegardes');
        if (!file_exists($dossier)) {
            mkdir($dossier, 0755, true);
        }

        $nomFichier = 'sauvegarde_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $chemin = $dossier . '/' . $nomFichier;

        $host     = config('database.connections.mysql.host');
        $port     = config('database.connections.mysql.port');
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        $commande = "mysqldump --host={$host} --port={$port} --user={$username} --password={$password} {$database} > \"{$chemin}\"";
        exec($commande, $output, $code);

        if ($code === 0) {
            return redirect()->route('admin.sauvegardes.index')
                ->with('success', "Sauvegarde créée avec succès : {$nomFichier}");
        } else {
            return redirect()->route('admin.sauvegardes.index')
                ->with('error', 'Erreur lors de la sauvegarde.');
        }
    }

    private function listerSauvegardes()
    {
        $dossier = storage_path('app/sauvegardes');
        if (!file_exists($dossier)) {
            return [];
        }

        $fichiers = glob($dossier . '/*.sql');
        $sauvegardes = [];

        foreach ($fichiers as $fichier) {
            $sauvegardes[] = [
                'nom'   => basename($fichier),
                'taille' => round(filesize($fichier) / 1024, 2) . ' KB',
                'date'  => date('d/m/Y H:i:s', filemtime($fichier)),
            ];
        }

        return array_reverse($sauvegardes);
    }
}