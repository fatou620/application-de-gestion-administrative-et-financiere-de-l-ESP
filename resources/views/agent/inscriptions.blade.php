@extends('layouts.agent', ['titlePage' => 'Inscriptions — Agent Admin'])

@section('page_title', 'Inscriptions')
@section('page_sub', 'Validation des inscriptions étudiantes')

@section('content')
<div class="card">
  <table>
    <thead>
      <tr>
        <th>N° étudiant</th><th>Étudiant</th><th>Filière / Niveau</th>
        <th>Année</th><th>Frais</th><th>Statut</th><th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($inscriptions as $i)
        <tr>
          <td><code style="font-family:monospace;font-size:12px">{{ $i->etudiant->numero_etudiant }}</code></td>
          <td><strong>{{ $i->etudiant->utilisateur->prenom }} {{ $i->etudiant->utilisateur->nom }}</strong></td>
          <td>{{ $i->niveau->filiere->nom ?? '—' }} — {{ $i->niveau->libelle ?? '—' }}</td>
          <td>{{ $i->annee_academique }}</td>
          <td>{{ number_format($i->frais_scolarite, 0, ',', ' ') }} FCFA</td>
          <td><span class="badge-status badge-{{ $i->statut }}">{{ ucfirst(str_replace('_',' ', $i->statut)) }}</span></td>
          <td>
            @if ($i->statut === 'en_attente')
              <form method="POST" action="{{ route('agent.inscriptions.valider', $i) }}">
                @csrf
                <button type="submit" class="btn btn-green"><i class="fas fa-check"></i> Valider</button>
              </form>
            @else
              <small style="color:#6b7280">{{ $i->date_validation?->format('d/m/Y') }}</small>
            @endif
          </td>
        </tr>
      @empty
        <tr><td colspan="7"><div class="empty"><i class="fas fa-clipboard-list"></i> Aucune inscription pour l'instant</div></td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div style="margin-top:20px">{{ $inscriptions->links() }}</div>
@endsection
