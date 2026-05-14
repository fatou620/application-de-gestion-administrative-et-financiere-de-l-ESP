@extends('layouts.finance', ['titlePage' => 'Tableau de bord — Finance'])

@section('page_title', 'Tableau de bord — Responsable Financier')
@section('page_sub', \Carbon\Carbon::now()->translatedFormat('l d F Y'))

@section('topbar_extra')
  <button class="notif-btn" title="Paiements à valider">
    <i class="fas fa-clock"></i>
    @if ($nbEnAttente > 0)<span class="badge">{{ $nbEnAttente }}</span>@endif
  </button>
@endsection

@section('content')
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon green"><i class="fas fa-coins"></i></div>
    <div>
      <div class="stat-value">{{ number_format($totalEncaisse, 0, ',', ' ') }}</div>
      <div class="stat-label">FCFA encaissés (validés)</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon orange"><i class="fas fa-hourglass-half"></i></div>
    <div>
      <div class="stat-value">{{ number_format($totalAttente, 0, ',', ' ') }}</div>
      <div class="stat-label">FCFA en attente de validation</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon blue"><i class="fas fa-receipt"></i></div>
    <div>
      <div class="stat-value">{{ $nbPaiements }}</div>
      <div class="stat-label">Transactions totales</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon purple"><i class="fas fa-clock"></i></div>
    <div>
      <div class="stat-value">{{ $nbEnAttente }}</div>
      <div class="stat-label">À valider</div>
    </div>
  </div>
</div>

<div class="grid-2">
  <div class="card">
    <div class="card-head"><h3><i class="fas fa-chart-pie"></i> Recettes par mode</h3></div>
    <div class="card-body-inner">
      @forelse ($parMode as $m)
        @php $pct = $totalEncaisse > 0 ? round($m->total / $totalEncaisse * 100, 1) : 0; @endphp
        <div style="margin-bottom:14px">
          <div style="display:flex;justify-content:space-between;font-size:13px;font-weight:600;margin-bottom:6px">
            <span>{{ ucfirst(str_replace('_',' ', $m->mode)) }} <small style="color:#6b7280">({{ $m->nb }} trx)</small></span>
            <span>{{ number_format($m->total, 0, ',', ' ') }} FCFA</span>
          </div>
          <div style="height:8px;background:#e5e7eb;border-radius:4px;overflow:hidden">
            <div style="height:100%;width:{{ $pct }}%;background:linear-gradient(90deg,#00853F,#34d399)"></div>
          </div>
          <div style="font-size:10.5px;color:#6b7280;margin-top:2px">{{ $pct }}%</div>
        </div>
      @empty
        <div class="empty"><i class="fas fa-chart-pie"></i> Pas encore de recettes</div>
      @endforelse
    </div>
  </div>

  <div class="card">
    <div class="card-head"><h3><i class="fas fa-calendar-day"></i> 7 derniers jours</h3></div>
    <div class="card-body-inner">
      @forelse ($parJour as $j)
        <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #e5e7eb">
          <span style="font-size:13.5px">{{ \Carbon\Carbon::parse($j->jour)->translatedFormat('l d/m') }}</span>
          <span style="font-weight:700">{{ number_format($j->total, 0, ',', ' ') }} FCFA</span>
        </div>
      @empty
        <div class="empty"><i class="fas fa-calendar"></i> Aucune transaction récente</div>
      @endforelse
    </div>
  </div>
</div>

<div class="card">
  <div class="card-head">
    <h3><i class="fas fa-list"></i> Paiements récents</h3>
    <a href="{{ route('finance.paiements') }}" class="see-all">Tout voir →</a>
  </div>
  <table>
    <thead>
      <tr><th>Date</th><th>Étudiant</th><th>Référence</th><th>Mode</th><th>Montant</th><th>Statut</th><th>Action</th></tr>
    </thead>
    <tbody>
      @forelse ($paiementsRecents as $p)
        <tr>
          <td>{{ $p->date_paiement->format('d/m/Y H:i') }}</td>
          <td>{{ $p->etudiant?->utilisateur?->prenom }} {{ $p->etudiant?->utilisateur?->nom }}</td>
          <td><code style="font-family:monospace;font-size:11px">{{ $p->reference_trans }}</code></td>
          <td>{{ ucfirst(str_replace('_',' ', $p->mode)) }}</td>
          <td><strong>{{ number_format($p->montant, 0, ',', ' ') }} FCFA</strong></td>
          <td><span class="badge-status badge-{{ $p->statut }}">{{ ucfirst(str_replace('_',' ', $p->statut)) }}</span></td>
          <td>
            <a href="{{ route('finance.paiements.recu', $p) }}" target="_blank" class="btn btn-outline">
              <i class="fas fa-print"></i> Reçu
            </a>
          </td>
        </tr>
      @empty
        <tr><td colspan="7"><div class="empty">Aucune transaction</div></td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
