@extends('layouts.finance', ['titlePage' => 'Étudiants — Finance'])

@section('page_title', 'Étudiants — Situation financière')
@section('page_sub', 'Vue par étudiant : montants payés et solde restant')

@section('content')
<div class="card" style="padding:18px;margin-bottom:20px">
  <form method="GET" style="display:flex;gap:10px;align-items:flex-end">
    <div class="iw" style="flex:1"><i class="fas fa-search"></i>
      <input type="search" name="q" value="{{ request('q') }}" placeholder="Nom, prénom ou n° étudiant…">
    </div>
    <button class="btn btn-green">Rechercher</button>
  </form>
</div>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>N° étudiant</th><th>Nom complet</th>
        <th>Total payé</th><th>Frais annuels</th>
        <th>Solde</th><th>Progression</th><th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($etudiants as $e)
        @php
          $paye = (float) $e->total_paye;
          $solde = max(0, $fraisAnnuels - $paye);
          $pct = $fraisAnnuels > 0 ? min(100, $paye / $fraisAnnuels * 100) : 0;
          $couleur = $pct >= 100 ? '#00853F' : ($pct >= 50 ? '#f97316' : '#E31E24');
        @endphp
        <tr>
          <td><code style="font-family:monospace;font-size:12px">{{ $e->numero_etudiant }}</code></td>
          <td><strong>{{ $e->utilisateur?->prenom }} {{ $e->utilisateur?->nom }}</strong></td>
          <td>{{ number_format($paye, 0, ',', ' ') }} FCFA</td>
          <td>{{ number_format($fraisAnnuels, 0, ',', ' ') }} FCFA</td>
          <td style="color:{{ $solde > 0 ? '#E31E24' : '#00853F' }};font-weight:700">
            {{ number_format($solde, 0, ',', ' ') }} FCFA
          </td>
          <td style="width:160px">
            <div style="height:8px;background:#e5e7eb;border-radius:4px;overflow:hidden">
              <div style="height:100%;width:{{ $pct }}%;background:{{ $couleur }}"></div>
            </div>
            <div style="font-size:10.5px;color:#6b7280;margin-top:2px">{{ round($pct) }}%</div>
          </td>
          <td>
            <a href="{{ route('finance.paiements', ['q' => $e->numero_etudiant]) }}" class="btn btn-outline">
              <i class="fas fa-eye"></i> Détail
            </a>
          </td>
        </tr>
      @empty
        <tr><td colspan="7"><div class="empty"><i class="fas fa-user-graduate"></i> Aucun étudiant trouvé</div></td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div style="margin-top:20px">{{ $etudiants->links() }}</div>
@endsection
