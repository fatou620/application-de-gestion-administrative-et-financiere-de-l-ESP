@extends('layouts.etudiant', ['titlePage' => 'Documents — ESP'])

@section('page_title', 'Dossier Numérique')
@section('page_sub', 'Gérez vos pièces justificatives')

@section('content')
<div class="card" style="padding:24px;margin-bottom:24px">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:18px;display:flex;align-items:center;gap:8px">
    <i class="fas fa-cloud-upload-alt" style="color:#00853F"></i> Importer un document
  </h3>
  <form method="POST" action="{{ route('etudiant.documents') }}" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 1fr auto;gap:16px;align-items:flex-end">
      <div class="form-group">
        <label>Libellé (ex : CNI, Diplôme Bac…)</label>
        <div class="iw"><i class="fas fa-tag"></i>
          <input type="text" name="libelle" placeholder="Saisir un nom…" required>
        </div>
      </div>
      <div class="form-group">
        <label>Fichier (PDF, JPG, PNG · 5 Mo max)</label>
        <div class="iw" style="padding-left:0">
          <input type="file" name="fichier" required style="padding-left:14px">
        </div>
      </div>
      <button type="submit" class="btn btn-green" style="padding:12px 22px">
        <i class="fas fa-upload"></i> Envoyer
      </button>
    </div>
  </form>
</div>

<div class="card">
  <div class="card-head"><h3><i class="fas fa-file-medical"></i> Mes pièces déposées</h3></div>
  <table>
    <thead>
      <tr><th>Libellé</th><th>Date</th><th>Statut</th><th>Actions</th></tr>
    </thead>
    <tbody>
      @forelse ($documents as $d)
        <tr>
          <td><strong>{{ $d->type_document }}</strong></td>
          <td style="color:#6b7280">{{ $d->date_depot->format('d/m/Y H:i') }}</td>
          <td><span class="badge-status badge-{{ $d->statut_validation }}">{{ ucfirst(str_replace('_',' ', $d->statut_validation)) }}</span></td>
          <td style="display:flex;gap:10px">
            <a href="{{ asset('storage/'.$d->url_fichier) }}" target="_blank" class="btn btn-outline">
              <i class="fas fa-eye"></i> Voir
            </a>
            <form method="POST" action="{{ route('etudiant.documents.destroy', $d) }}"
                  onsubmit="return confirm('Supprimer ce document ?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-red">
                <i class="fas fa-trash-alt"></i> Supprimer
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="4"><div class="empty"><i class="fas fa-folder-open"></i> Aucun document dans votre dossier</div></td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
