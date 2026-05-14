@extends('layouts.agent', ['titlePage' => 'Documents à valider'])

@section('page_title', 'Documents à valider')
@section('page_sub', 'Validation des pièces justificatives déposées par les étudiants')

@section('content')
<div style="display:flex;gap:6px;margin-bottom:20px;flex-wrap:wrap">
  @foreach (['' => 'Tous', 'en_attente' => 'En attente', 'valide' => 'Validés', 'rejete' => 'Rejetés'] as $val => $label)
    <a href="{{ route('agent.documents', $val ? ['statut' => $val] : []) }}"
       class="btn {{ $statut === $val ? 'btn-green' : 'btn-outline' }}">{{ $label }}</a>
  @endforeach
</div>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>Étudiant</th><th>N° étudiant</th><th>Type de document</th>
        <th>Date dépôt</th><th>Statut</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($documents as $d)
        <tr>
          <td><strong>{{ $d->etudiant?->utilisateur?->prenom }} {{ $d->etudiant?->utilisateur?->nom }}</strong></td>
          <td><code style="font-family:monospace;font-size:12px">{{ $d->etudiant?->numero_etudiant }}</code></td>
          <td>{{ $d->type_document }}</td>
          <td style="color:#6b7280">{{ $d->date_depot->format('d/m/Y H:i') }}</td>
          <td><span class="badge-status badge-{{ $d->statut_validation }}">{{ ucfirst(str_replace('_',' ', $d->statut_validation)) }}</span></td>
          <td style="display:flex;gap:8px;flex-wrap:wrap">
            <a href="{{ asset('storage/'.$d->url_fichier) }}" target="_blank" class="btn btn-outline">
              <i class="fas fa-eye"></i> Voir
            </a>
            @if ($d->statut_validation === 'en_attente')
              <form method="POST" action="{{ route('agent.documents.valider', $d) }}" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-green"><i class="fas fa-check"></i> Valider</button>
              </form>
              <button class="btn btn-red" onclick="toggleReject({{ $d->id }})"><i class="fas fa-times"></i> Rejeter</button>
              <form id="rej-{{ $d->id }}" method="POST" action="{{ route('agent.documents.rejeter', $d) }}"
                    style="display:none;flex-basis:100%;margin-top:8px">
                @csrf
                <textarea name="commentaire" placeholder="Motif du rejet…" required
                          style="width:100%;padding:10px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:inherit;font-size:13px;min-height:60px"></textarea>
                <button type="submit" class="btn btn-red" style="margin-top:6px">Confirmer le rejet</button>
              </form>
            @endif
          </td>
        </tr>
      @empty
        <tr><td colspan="6"><div class="empty"><i class="fas fa-folder-open"></i> Aucun document</div></td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div style="margin-top:20px">{{ $documents->links() }}</div>

@push('scripts')
<script>
function toggleReject(id) {
  const el = document.getElementById('rej-' + id);
  el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>
@endpush
@endsection
