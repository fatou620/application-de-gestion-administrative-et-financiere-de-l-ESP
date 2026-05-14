@extends('layouts.finance', ['titlePage' => 'Irrégularités — Finance'])

@section('page_title', 'Étudiants en irrégularité financière')
@section('page_sub', 'Étudiants n\'ayant pas réglé l\'intégralité des frais annuels ('.number_format($frais, 0, ',', ' ').' FCFA)')

@section('content')
<div class="card">
  <table>
    <thead>
      <tr>
        <th>N° étudiant</th><th>Nom complet</th>
        <th>Total payé</th><th>Solde dû</th>
        <th>% payé</th><th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($irreguliers as $e)
        @php
          $paye  = (float) $e->total_paye;
          $solde = $frais - $paye;
          $pct   = $frais > 0 ? round($paye / $frais * 100, 1) : 0;
        @endphp
        <tr>
          <td><code style="font-family:monospace;font-size:12px">{{ $e->numero_etudiant }}</code></td>
          <td><strong>{{ $e->utilisateur?->prenom }} {{ $e->utilisateur?->nom }}</strong></td>
          <td>{{ number_format($paye, 0, ',', ' ') }} FCFA</td>
          <td style="color:#E31E24;font-weight:800">
            {{ number_format($solde, 0, ',', ' ') }} FCFA
          </td>
          <td>
            <span class="badge-status badge-{{ $pct >= 50 ? 'en_attente' : 'rejete' }}">{{ $pct }}%</span>
          </td>
          <td>
            <a href="{{ route('finance.paiements', ['q' => $e->numero_etudiant]) }}" class="btn btn-outline">
              <i class="fas fa-search"></i> Voir paiements
            </a>
          </td>
        </tr>
      @empty
        <tr><td colspan="6">
          <div class="empty" style="color:#00853F">
            <i class="fas fa-check-circle"></i>
            <p>Aucun étudiant en irrégularité — tous les frais sont à jour ✨</p>
          </div>
        </td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div style="margin-top:20px">{{ $irreguliers->links() }}</div>
@endsection
