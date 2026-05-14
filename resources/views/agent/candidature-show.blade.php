@extends('layouts.agent', ['titlePage' => 'Candidature '.$candidat->numero_candidature])

@section('page_title', 'Examen de candidature')
@section('page_sub', $candidat->numero_candidature.' · '.$candidat->prenom.' '.$candidat->nom)

@section('content')
<a href="{{ route('agent.candidatures') }}" class="btn btn-outline" style="margin-bottom:20px">
  <i class="fas fa-arrow-left"></i> Retour à la liste
</a>

<div style="display:grid;grid-template-columns:1fr 350px;gap:24px" class="cand-layout">
  <div class="card">
    <div class="card-head"><h3><i class="fas fa-user-graduate"></i> Informations candidat</h3></div>
    <div style="padding:24px">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px">
        <div><strong style="font-size:11px;color:#6b7280;text-transform:uppercase">Nom complet</strong><br>{{ $candidat->prenom }} {{ $candidat->nom }}</div>
        <div><strong style="font-size:11px;color:#6b7280;text-transform:uppercase">N° de candidature</strong><br><code>{{ $candidat->numero_candidature }}</code></div>
        <div><strong style="font-size:11px;color:#6b7280;text-transform:uppercase">Email</strong><br>{{ $candidat->email }}</div>
        <div><strong style="font-size:11px;color:#6b7280;text-transform:uppercase">Téléphone</strong><br>{{ $candidat->telephone ?? '—' }}</div>
        <div><strong style="font-size:11px;color:#6b7280;text-transform:uppercase">Date de naissance</strong><br>{{ $candidat->date_naissance?->format('d/m/Y') ?? '—' }}</div>
        <div><strong style="font-size:11px;color:#6b7280;text-transform:uppercase">Lieu de naissance</strong><br>{{ $candidat->lieu_naissance ?? '—' }}</div>
        <div><strong style="font-size:11px;color:#6b7280;text-transform:uppercase">Diplôme</strong><br>{{ $candidat->diplome }}</div>
        <div><strong style="font-size:11px;color:#6b7280;text-transform:uppercase">Filière voulue</strong><br>{{ $candidat->filiereVoulue->nom ?? '—' }}</div>
      </div>

      <h3 style="font-size:14px;font-weight:700;margin-top:28px;margin-bottom:14px"><i class="fas fa-paperclip" style="color:#00853F"></i> Pièces du dossier</h3>
      @if (count($candidat->dossier))
        <table>
          <thead><tr><th>Type</th><th>Date dépôt</th><th>Statut</th><th>Action</th></tr></thead>
          <tbody>
            @foreach ($candidat->dossier as $piece)
              <tr>
                <td>{{ $piece->type_piece }}</td>
                <td style="color:#6b7280">{{ $piece->date_depot->format('d/m/Y') }}</td>
                <td><span class="badge-status badge-{{ $piece->statut }}">{{ ucfirst(str_replace('_',' ', $piece->statut)) }}</span></td>
                <td><a href="{{ asset('storage/'.$piece->url_fichier) }}" target="_blank" class="btn btn-outline"><i class="fas fa-eye"></i></a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="empty"><i class="fas fa-paperclip"></i> Aucune pièce déposée</div>
      @endif
    </div>
  </div>

  <div>
    <div class="card" style="margin-bottom:20px">
      <div class="card-head"><h3><i class="fas fa-clipboard-check"></i> Décision</h3></div>
      <div style="padding:20px">
        <p style="font-size:13px;margin-bottom:14px">Statut actuel : <span class="badge-status badge-{{ $candidat->statut }}">{{ ucfirst(str_replace('_',' ', $candidat->statut)) }}</span></p>

        @if ($candidat->statut === 'rejete' && $candidat->motif_rejet)
          <div class="alert alert-error" style="font-size:12.5px"><i class="fas fa-times-circle"></i> {{ $candidat->motif_rejet }}</div>
        @endif

        <form method="POST" action="{{ route('agent.candidatures.valider', $candidat) }}" style="margin-bottom:10px">
          @csrf
          <button type="submit" class="btn btn-green" style="width:100%;padding:12px">
            <i class="fas fa-check-circle"></i> Valider la candidature
          </button>
        </form>

        <form method="POST" action="{{ route('agent.candidatures.rejeter', $candidat) }}">
          @csrf
          <div class="form-group">
            <label>Motif du rejet</label>
            <div class="iw" style="padding-left:0">
              <textarea name="motif" placeholder="Précisez le motif…" required style="padding:11px 14px;width:100%;border:1.5px solid #e5e7eb;border-radius:10px;font-family:inherit;font-size:14px;background:#f9fafb;min-height:80px"></textarea>
            </div>
          </div>
          <button type="submit" class="btn btn-red" style="width:100%;padding:12px">
            <i class="fas fa-times-circle"></i> Rejeter
          </button>
        </form>
      </div>
    </div>

    @if ($candidat->date_traitement)
      <div class="card" style="padding:18px;font-size:12px;color:#6b7280">
        <i class="fas fa-history"></i> Dernier traitement : {{ $candidat->date_traitement->format('d/m/Y H:i') }}
      </div>
    @endif
  </div>
</div>

@push('styles')
<style>@media(max-width:900px){ .cand-layout { grid-template-columns:1fr !important; } }</style>
@endpush
@endsection
