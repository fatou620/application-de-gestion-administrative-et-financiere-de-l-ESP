@extends('layouts.etudiant', ['titlePage' => 'Tableau de bord — ESP'])

@section('page_title', 'Tableau de bord')
@section('page_sub', 'Bienvenue, '.auth()->user()->prenom.' · '.\Carbon\Carbon::now()->translatedFormat('d/m/Y'))

@section('topbar_extra')
  <button class="notif-btn" title="Notifications">
    <i class="fas fa-bell"></i>
    @if (count($annonces) > 0)<span class="badge">{{ count($annonces) }}</span>@endif
  </button>
@endsection

@section('content')
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon green"><i class="fas fa-star"></i></div>
    <div>
      <div class="stat-value">{{ $moyenne ? number_format($moyenne, 2) : '—' }}/20</div>
      <div class="stat-label">Moyenne générale</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon blue"><i class="fas fa-book-open"></i></div>
    <div>
      <div class="stat-value">{{ $totalNotes }}</div>
      <div class="stat-label">Notes enregistrées</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon orange"><i class="fas fa-wallet"></i></div>
    <div>
      <div class="stat-value">{{ number_format($totalPaye, 0, ',', ' ') }} FCFA</div>
      <div class="stat-label">Total payé</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon purple"><i class="fas fa-file-alt"></i></div>
    <div>
      <div class="stat-value">{{ count($documents) }}</div>
      <div class="stat-label">Documents déposés</div>
    </div>
  </div>
</div>

<div class="grid-3">
  <div class="card">
    <div class="card-head">
      <h3><i class="fas fa-star"></i> Notes récentes</h3>
      <a href="{{ route('etudiant.notes') }}" class="see-all">Voir tout →</a>
    </div>
    <div class="card-body-inner">
      @forelse ($notesRecentes as $n)
        @php
          $cls = $n->valeur >= 14 ? '#00853F' : ($n->valeur >= 10 ? '#f97316' : '#E31E24');
        @endphp
        <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #e5e7eb">
          <div>
            <div style="font-size:13.5px;font-weight:500">{{ $n->matiere->nom }}</div>
            <div style="font-size:11px;color:#6b7280;text-transform:uppercase;letter-spacing:.5px">
              {{ $n->type_eval === 'cc' ? 'Contrôle continu' : ($n->type_eval === 'examen' ? 'Examen' : 'TP') }}
            </div>
          </div>
          <div style="font-size:18px;font-weight:800;color:{{ $cls }}">{{ number_format($n->valeur,2) }}</div>
        </div>
      @empty
        <div class="empty"><i class="fas fa-star"></i> Aucune note disponible</div>
      @endforelse
    </div>
  </div>

  <div class="card">
    <div class="card-head"><h3><i class="fas fa-calendar-day"></i> Aujourd'hui</h3></div>
    <div class="card-body-inner">
      <div style="font-size:11px;color:#6b7280;margin-bottom:12px;font-weight:600;text-transform:uppercase">{{ $jourAujourdhui }}</div>
      @forelse ($coursAujourdhui as $c)
        <div style="display:flex;gap:14px;align-items:center;padding:10px 0;border-bottom:1px solid #e5e7eb">
          <div style="background:rgba(0,133,63,.08);color:#00853F;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:700;text-align:center;min-width:64px">
            {{ substr($c->heure_debut, 0, 5) }}<br>{{ substr($c->heure_fin, 0, 5) }}
          </div>
          <div>
            <div style="font-size:13.5px;font-weight:600">{{ $c->matiere->nom }}</div>
            <div style="font-size:11px;color:#6b7280"><i class="fas fa-map-marker-alt"></i> Salle {{ $c->salle }}</div>
          </div>
        </div>
      @empty
        <div class="empty"><i class="fas fa-coffee"></i> Pas de cours ce jour</div>
      @endforelse
    </div>
  </div>
</div>

<div class="grid-2">
  <div class="card">
    <div class="card-head">
      <h3><i class="fas fa-money-bill-wave"></i> Paiements récents</h3>
      <a href="{{ route('etudiant.paiements') }}" class="see-all">Voir tout →</a>
    </div>
    <div class="card-body-inner">
      @forelse ($paiements as $p)
        <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #e5e7eb">
          <div>
            <span class="badge-status badge-{{ $p->statut }}">{{ str_replace('_',' ', ucfirst($p->mode)) }}</span>
            <div style="font-size:11px;color:#6b7280;margin-top:4px">{{ $p->date_paiement->format('d/m/Y') }}</div>
          </div>
          <div style="font-size:15px;font-weight:700">{{ number_format($p->montant, 0, ',', ' ') }} FCFA</div>
        </div>
      @empty
        <div class="empty"><i class="fas fa-receipt"></i> Aucun paiement</div>
      @endforelse
    </div>
  </div>

  <div class="card">
    <div class="card-head"><h3><i class="fas fa-bullhorn"></i> Annonces</h3></div>
    <div class="card-body-inner">
      @forelse ($annonces as $a)
        <div style="padding:12px 0;border-bottom:1px solid #e5e7eb">
          <div style="font-size:13.5px;font-weight:600">
            {{ $a->titre }}
            <span class="badge-status badge-{{ $a->priorite === 'urgente' ? 'rejete' : 'valide' }}">{{ $a->priorite }}</span>
          </div>
          <div style="font-size:11px;color:#6b7280;margin-top:2px">{{ $a->date_publication->format('d/m/Y H:i') }}</div>
        </div>
      @empty
        <div class="empty"><i class="fas fa-bullhorn"></i> Aucune annonce</div>
      @endforelse
    </div>
  </div>
</div>

<div class="card">
  <div class="card-head"><h3><i class="fas fa-file-alt"></i> Mes documents</h3></div>
  <div class="card-body-inner">
    @if (count($documents))
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px">
        @foreach ($documents as $d)
          <div style="border:1px solid #e5e7eb;border-radius:10px;padding:14px;display:flex;flex-direction:column;gap:8px">
            <div style="font-size:13.5px;font-weight:600">{{ $d->type_document }}</div>
            <div style="font-size:11px;color:#6b7280">{{ $d->date_depot->format('d/m/Y') }}</div>
            <span class="badge-status badge-{{ $d->statut_validation }}">
              <i class="fas fa-{{ $d->statut_validation === 'valide' ? 'check-circle' : ($d->statut_validation === 'rejete' ? 'times-circle' : 'clock') }}"></i>
              {{ ucfirst(str_replace('_',' ', $d->statut_validation)) }}
            </span>
          </div>
        @endforeach
      </div>
    @else
      <div class="empty"><i class="fas fa-folder-open"></i> Aucun document déposé</div>
    @endif
  </div>
</div>
@endsection
