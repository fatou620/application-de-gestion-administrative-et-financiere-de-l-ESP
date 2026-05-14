@extends('layouts.finance', ['titlePage' => 'Paiements — Finance'])

@section('page_title', 'Paiements')
@section('page_sub', 'Toutes les transactions financières')

@section('content')
<div class="card" style="padding:18px;margin-bottom:20px">
  <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end">
    <div class="iw" style="flex:1;min-width:200px"><i class="fas fa-search"></i>
      <input type="search" name="q" value="{{ request('q') }}" placeholder="Référence, étudiant, n°…">
    </div>
    <select name="statut" class="iw-input" style="padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:10px;font-family:inherit">
      <option value="">— Tous statuts —</option>
      @foreach (['en_attente' => 'En attente', 'valide' => 'Validé', 'rejete' => 'Rejeté'] as $v => $l)
        <option value="{{ $v }}" {{ $statut === $v ? 'selected' : '' }}>{{ $l }}</option>
      @endforeach
    </select>
    <select name="mode" style="padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:10px;font-family:inherit">
      <option value="">— Tous modes —</option>
      @foreach (['orange_money' => 'Orange Money', 'wave' => 'Wave', 'especes' => 'Espèces'] as $v => $l)
        <option value="{{ $v }}" {{ $mode === $v ? 'selected' : '' }}>{{ $l }}</option>
      @endforeach
    </select>
    <button class="btn btn-green">Filtrer</button>
  </form>
</div>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>Date</th><th>Étudiant</th><th>Référence</th>
        <th>Mode</th><th>Montant</th><th>Statut</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($paiements as $p)
        <tr>
          <td>{{ $p->date_paiement->format('d/m/Y H:i') }}</td>
          <td>
            <strong>{{ $p->etudiant?->utilisateur?->prenom }} {{ $p->etudiant?->utilisateur?->nom }}</strong><br>
            <small style="color:#6b7280">{{ $p->etudiant?->numero_etudiant }}</small>
          </td>
          <td><code style="font-family:monospace;font-size:11px">{{ $p->reference_trans }}</code></td>
          <td>{{ ucfirst(str_replace('_',' ', $p->mode)) }}</td>
          <td><strong>{{ number_format($p->montant, 0, ',', ' ') }} FCFA</strong></td>
          <td><span class="badge-status badge-{{ $p->statut }}">{{ ucfirst(str_replace('_',' ', $p->statut)) }}</span></td>
          <td style="display:flex;gap:6px;flex-wrap:wrap">
            <a href="{{ route('finance.paiements.recu', $p) }}" target="_blank" class="btn btn-outline">
              <i class="fas fa-print"></i> Reçu
            </a>
            @if ($p->statut === 'en_attente')
              <form method="POST" action="{{ route('finance.paiements.valider', $p) }}" style="display:inline">
                @csrf
                <button class="btn btn-green"><i class="fas fa-check"></i> Valider</button>
              </form>
            @endif
          </td>
        </tr>
      @empty
        <tr><td colspan="7"><div class="empty"><i class="fas fa-receipt"></i> Aucun paiement</div></td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div style="margin-top:20px">{{ $paiements->links() }}</div>
@endsection
