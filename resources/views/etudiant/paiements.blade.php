@extends('layouts.etudiant', ['titlePage' => 'Paiements — ESP'])

@section('page_title', 'Gestion des Paiements')
@section('page_sub', 'Scolarité et frais académiques · ESP Dakar')

@section('content')
<div class="stats-grid" style="grid-template-columns:repeat(3,1fr)">
  <div class="stat-card">
    <div class="stat-icon green"><i class="fas fa-coins"></i></div>
    <div>
      <div class="stat-value">{{ number_format($totalPaye, 0, ',', ' ') }} FCFA</div>
      <div class="stat-label">Montant payé</div>
      <div style="margin-top:8px">
        <div style="height:8px;background:#e5e7eb;border-radius:4px;overflow:hidden;width:120px">
          <div style="height:100%;width:{{ min(100, $fraisAnnuels>0?$totalPaye/$fraisAnnuels*100:0) }}%;background:linear-gradient(90deg,#00853F,#34d399)"></div>
        </div>
        <div style="font-size:10.5px;color:#6b7280;margin-top:4px">{{ round(min(100, $fraisAnnuels>0?$totalPaye/$fraisAnnuels*100:0)) }}% des frais annuels</div>
      </div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon {{ $solde > 0 ? 'red' : 'green' }}"><i class="fas fa-balance-scale"></i></div>
    <div>
      <div class="stat-value" style="color:{{ $solde > 0 ? '#E31E24' : '#00853F' }}">{{ number_format($solde, 0, ',', ' ') }} FCFA</div>
      <div class="stat-label">Solde restant</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon blue"><i class="fas fa-receipt"></i></div>
    <div>
      <div class="stat-value">{{ count($historique) }}</div>
      <div class="stat-label">Transactions</div>
    </div>
  </div>
</div>

<div class="card" style="padding:24px;margin-bottom:24px">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:18px;display:flex;align-items:center;gap:8px">
    <i class="fas fa-plus-circle" style="color:#00853F"></i> Effectuer un paiement
  </h3>
  <form method="POST" action="{{ route('etudiant.paiements') }}">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px">
      <div class="form-group">
        <label>Montant (FCFA)</label>
        <div class="iw"><i class="fas fa-coins"></i>
          <input type="number" name="montant" placeholder="150000" min="1000" step="500" required>
        </div>
      </div>
      <div class="form-group">
        <label>Mode</label>
        <div class="iw"><i class="fas fa-credit-card"></i>
          <select name="mode" required>
            <option value="">— Choisir —</option>
            <option value="orange_money">Orange Money</option>
            <option value="wave">Wave</option>
            <option value="especes">Espèces</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label>N° téléphone</label>
        <div class="iw"><i class="fas fa-phone"></i>
          <input type="tel" name="telephone" placeholder="77 000 00 00">
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-green" style="margin-top:8px;padding:12px 24px">
      <i class="fas fa-paper-plane"></i> Valider le paiement
    </button>
  </form>
</div>

<h2 style="font-size:16px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:8px">
  <i class="fas fa-history" style="color:#00853F"></i> Historique des paiements
</h2>
<div class="card">
  <table>
    <thead>
      <tr><th>Date</th><th>Montant</th><th>Mode</th><th>Statut</th><th>Référence</th></tr>
    </thead>
    <tbody>
      @forelse ($historique as $p)
        <tr>
          <td>{{ $p->date_paiement->format('d/m/Y H:i') }}</td>
          <td><strong>{{ number_format($p->montant, 0, ',', ' ') }} FCFA</strong></td>
          <td><span class="badge-status badge-valide">{{ str_replace('_',' ', ucfirst($p->mode)) }}</span></td>
          <td><span class="badge-status badge-{{ $p->statut }}">{{ ucfirst(str_replace('_',' ', $p->statut)) }}</span></td>
          <td><code style="font-family:monospace;font-size:12px;color:#6b7280">{{ $p->reference_trans ?? '—' }}</code></td>
        </tr>
      @empty
        <tr><td colspan="5"><div class="empty">Aucune transaction</div></td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
