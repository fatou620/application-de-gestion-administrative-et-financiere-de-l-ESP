@extends('layouts.agent', ['titlePage' => 'Annonces — Agent Admin'])

@section('page_title', 'Annonces')
@section('page_sub', 'Communication officielle vers les étudiants et le personnel')

@section('content')
<div class="card" style="padding:24px;margin-bottom:24px">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:18px;display:flex;align-items:center;gap:8px">
    <i class="fas fa-bullhorn" style="color:#00853F"></i> Publier une annonce
  </h3>
  <form method="POST" action="{{ route('agent.annonces.store') }}">
    @csrf
    <div class="form-group">
      <label>Titre</label>
      <div class="iw"><i class="fas fa-heading"></i><input type="text" name="titre" required maxlength="200" placeholder="Sujet de l'annonce"></div>
    </div>
    <div class="form-group">
      <label>Contenu</label>
      <div class="iw" style="padding-left:0">
        <textarea name="contenu" required style="padding:11px 14px;width:100%;border:1.5px solid #e5e7eb;border-radius:10px;font-family:inherit;font-size:14px;background:#f9fafb;min-height:120px" placeholder="Détail de l'annonce…"></textarea>
      </div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
      <div class="form-group">
        <label>Priorité</label>
        <div class="iw"><i class="fas fa-exclamation-circle"></i>
          <select name="priorite" required>
            <option value="normale">Normale</option>
            <option value="urgente">Urgente</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label>Destinataires</label>
        <div class="iw"><i class="fas fa-users"></i>
          <select name="cible" required>
            <option value="tous">Tous</option>
            <option value="etudiants" selected>Étudiants</option>
            <option value="enseignants">Enseignants</option>
            <option value="agent_administratif">Personnel administratif</option>
          </select>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-green" style="padding:12px 24px">
      <i class="fas fa-paper-plane"></i> Publier l'annonce
    </button>
  </form>
</div>

<div class="card">
  <div class="card-head"><h3><i class="fas fa-history"></i> Annonces publiées</h3></div>
  <div style="padding:0">
    <table>
      <thead>
        <tr><th>Titre</th><th>Priorité</th><th>Cible</th><th>Date</th><th>Action</th></tr>
      </thead>
      <tbody>
        @forelse ($annonces as $a)
          <tr>
            <td>
              <strong>{{ $a->titre }}</strong>
              <div style="font-size:12px;color:#6b7280;margin-top:2px">{{ \Illuminate\Support\Str::limit($a->contenu, 100) }}</div>
            </td>
            <td><span class="badge-status badge-{{ $a->priorite === 'urgente' ? 'rejete' : 'valide' }}">{{ $a->priorite }}</span></td>
            <td>{{ ucfirst(str_replace('_',' ', $a->cible)) }}</td>
            <td style="color:#6b7280">{{ $a->date_publication->format('d/m/Y H:i') }}</td>
            <td>
              <form method="POST" action="{{ route('agent.annonces.destroy', $a) }}"
                    onsubmit="return confirm('Supprimer cette annonce ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-red"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5"><div class="empty"><i class="fas fa-bullhorn"></i> Aucune annonce</div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div style="margin-top:20px">{{ $annonces->links() }}</div>
@endsection
