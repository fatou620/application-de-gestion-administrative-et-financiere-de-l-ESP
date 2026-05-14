@extends('layouts.finance', ['titlePage' => 'Rapport — Finance'])

@section('page_title', 'Rapport financier')
@section('page_sub', 'Synthèse globale des recettes')

@section('content')
<div class="stats-grid" style="grid-template-columns:repeat(3,1fr)">
  <div class="stat-card">
    <div class="stat-icon green"><i class="fas fa-coins"></i></div>
    <div>
      <div class="stat-value">{{ number_format($totalEncaisse, 0, ',', ' ') }}</div>
      <div class="stat-label">FCFA encaissés</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon blue"><i class="fas fa-target"></i></div>
    <div>
      <div class="stat-value">{{ number_format($totalAttendu, 0, ',', ' ') }}</div>
      <div class="stat-label">FCFA attendus (théorique)</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon {{ $tauxRecouv >= 80 ? 'green' : ($tauxRecouv >= 50 ? 'orange' : 'red') }}">
      <i class="fas fa-percentage"></i>
    </div>
    <div>
      <div class="stat-value">{{ $tauxRecouv }}%</div>
      <div class="stat-label">Taux de recouvrement</div>
    </div>
  </div>
</div>

<div class="grid-2">
  <div class="card">
    <div class="card-head"><h3><i class="fas fa-chart-pie"></i> Répartition par mode</h3></div>
    <div class="card-body-inner">
      @forelse ($parMode as $m)
        @php $pct = $totalEncaisse > 0 ? round($m->total / $totalEncaisse * 100, 1) : 0; @endphp
        <div style="margin-bottom:14px">
          <div style="display:flex;justify-content:space-between;font-size:13.5px;font-weight:600;margin-bottom:6px">
            <span>{{ ucfirst(str_replace('_',' ', $m->mode)) }} <small style="color:#6b7280">({{ $m->nb }} trx)</small></span>
            <span>{{ number_format($m->total, 0, ',', ' ') }} FCFA — {{ $pct }}%</span>
          </div>
          <div style="height:10px;background:#e5e7eb;border-radius:5px;overflow:hidden">
            <div style="height:100%;width:{{ $pct }}%;background:linear-gradient(90deg,#00853F,#34d399)"></div>
          </div>
        </div>
      @empty
        <div class="empty"><i class="fas fa-chart-pie"></i> Aucune recette</div>
      @endforelse
    </div>
  </div>

  <div class="card">
    <div class="card-head"><h3><i class="fas fa-chart-line"></i> Évolution mensuelle</h3></div>
    <div class="card-body-inner">
      <table>
        <thead><tr><th>Mois</th><th>Transactions</th><th>Total</th></tr></thead>
        <tbody>
          @forelse ($parMois as $m)
            <tr>
              <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $m->mois)->translatedFormat('F Y') }}</td>
              <td>{{ $m->nb }}</td>
              <td><strong>{{ number_format($m->total, 0, ',', ' ') }} FCFA</strong></td>
            </tr>
          @empty
            <tr><td colspan="3"><div class="empty">Aucune donnée</div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="card" style="padding:24px;text-align:center;background:linear-gradient(135deg,rgba(0,133,63,.05),rgba(253,239,66,.05))">
  <p style="font-size:13px;color:#6b7280;margin-bottom:10px">Rapport généré le {{ now()->translatedFormat('l d F Y à H:i') }}</p>
  <button onclick="window.print()" class="btn btn-green" style="padding:12px 28px">
    <i class="fas fa-print"></i> Imprimer le rapport
  </button>
</div>
@endsection
