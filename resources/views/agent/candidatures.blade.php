@extends('layouts.agent', ['titlePage' => 'Candidatures — Agent Admin'])

@section('page_title', 'Candidatures')
@section('page_sub', 'Gestion des candidatures à l\'ESP')

@section('content')
<div class="card" style="padding:18px;margin-bottom:20px;display:flex;gap:16px;align-items:center;flex-wrap:wrap">
  <form method="GET" style="display:flex;gap:8px;flex:1;min-width:240px">
    <div class="iw" style="flex:1"><i class="fas fa-search"></i>
      <input type="search" name="q" value="{{ request('q') }}" placeholder="Rechercher (nom, email, n° candidature)…">
    </div>
    <input type="hidden" name="statut" value="{{ $statut }}">
    <button class="btn btn-green">Rechercher</button>
  </form>
  <div style="display:flex;gap:6px;flex-wrap:wrap">
    @php
      $statuts = [
        ''         => ['Tous', '#6b7280'],
        'nouveau'  => ['Nouveau', '#3b82f6'],
        'en_cours' => ['En cours', '#f97316'],
        'incomplet'=> ['Incomplet', '#E31E24'],
        'valide'   => ['Validé', '#00853F'],
        'rejete'   => ['Rejeté', '#E31E24'],
      ];
    @endphp
    @foreach ($statuts as $val => [$label, $color])
      <a href="{{ route('agent.candidatures', array_filter(['statut' => $val ?: null, 'q' => request('q')])) }}"
         class="btn {{ $statut === $val ? 'btn-green' : 'btn-outline' }}"
         style="padding:6px 14px;font-size:12px">{{ $label }}</a>
    @endforeach
  </div>
</div>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>N° Candidature</th><th>Nom complet</th><th>Email</th>
        <th>Filière voulue</th><th>Diplôme</th><th>Statut</th><th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($candidats as $c)
        <tr>
          <td><code style="font-family:monospace;font-size:12px">{{ $c->numero_candidature }}</code></td>
          <td><strong>{{ $c->prenom }} {{ $c->nom }}</strong></td>
          <td>{{ $c->email }}</td>
          <td>{{ $c->filiereVoulue->nom ?? '—' }}</td>
          <td>{{ $c->diplome }}</td>
          <td><span class="badge-status badge-{{ $c->statut }}">{{ ucfirst(str_replace('_',' ', $c->statut)) }}</span></td>
          <td>
            <a href="{{ route('agent.candidatures.show', $c) }}" class="btn btn-outline">
              <i class="fas fa-eye"></i> Examiner
            </a>
          </td>
        </tr>
      @empty
        <tr><td colspan="7"><div class="empty"><i class="fas fa-inbox"></i> Aucune candidature trouvée</div></td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div style="margin-top:20px">
  {{ $candidats->links() }}
</div>
@endsection
