@extends('layouts.agent', ['titlePage' => 'Tableau de bord — Agent Admin'])

@section('page_title', 'Tableau de bord — Agent Administratif')
@section('page_sub', \Carbon\Carbon::now()->translatedFormat('l d F Y'))

@section('topbar_extra')
  <button class="notif-btn" title="Tâches en attente">
    <i class="fas fa-tasks"></i>
    @php $alerts = $stats['candidatures_attente'] + $stats['inscriptions_attente'] + $stats['docs_attente']; @endphp
    @if ($alerts > 0)<span class="badge">{{ $alerts }}</span>@endif
  </button>
@endsection

@section('content')
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon blue"><i class="fas fa-inbox"></i></div>
    <div>
      <div class="stat-value">{{ $stats['candidatures_total'] }}</div>
      <div class="stat-label">Candidatures totales</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon orange"><i class="fas fa-hourglass-half"></i></div>
    <div>
      <div class="stat-value">{{ $stats['candidatures_attente'] }}</div>
      <div class="stat-label">Candidatures en attente</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
    <div>
      <div class="stat-value">{{ $stats['candidatures_valides'] }}</div>
      <div class="stat-label">Candidatures validées</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon red"><i class="fas fa-times-circle"></i></div>
    <div>
      <div class="stat-value">{{ $stats['candidatures_rejets'] }}</div>
      <div class="stat-label">Candidatures rejetées</div>
    </div>
  </div>
</div>

<div class="stats-grid" style="grid-template-columns:repeat(3,1fr)">
  <div class="stat-card">
    <div class="stat-icon purple"><i class="fas fa-clipboard-check"></i></div>
    <div>
      <div class="stat-value">{{ $stats['inscriptions_attente'] }}</div>
      <div class="stat-label">Inscriptions à valider</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
    <div>
      <div class="stat-value">{{ $stats['inscriptions_validees'] }}</div>
      <div class="stat-label">Inscriptions validées</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon orange"><i class="fas fa-folder-open"></i></div>
    <div>
      <div class="stat-value">{{ $stats['docs_attente'] }}</div>
      <div class="stat-label">Documents à valider</div>
    </div>
  </div>
</div>

<div class="grid-2">
  <div class="card">
    <div class="card-head">
      <h3><i class="fas fa-user-plus"></i> Candidatures récentes</h3>
      <a href="{{ route('agent.candidatures') }}" class="see-all">Tout voir →</a>
    </div>
    <div class="card-body-inner" style="padding:0">
      <table>
        <thead><tr><th>Candidat</th><th>Filière</th><th>Statut</th></tr></thead>
        <tbody>
          @forelse ($candidatsRecents as $c)
            <tr>
              <td>
                <strong>{{ $c->prenom }} {{ $c->nom }}</strong><br>
                <small style="color:#6b7280">{{ $c->numero_candidature }}</small>
              </td>
              <td>{{ $c->filiereVoulue->nom ?? '—' }}</td>
              <td><span class="badge-status badge-{{ $c->statut }}">{{ ucfirst(str_replace('_',' ', $c->statut)) }}</span></td>
            </tr>
          @empty
            <tr><td colspan="3"><div class="empty">Aucune candidature</div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="card">
    <div class="card-head">
      <h3><i class="fas fa-file-upload"></i> Documents à valider</h3>
      <a href="{{ route('agent.documents') }}" class="see-all">Tout voir →</a>
    </div>
    <div class="card-body-inner" style="padding:0">
      <table>
        <thead><tr><th>Étudiant</th><th>Document</th><th>Dépôt</th></tr></thead>
        <tbody>
          @forelse ($docsRecents as $d)
            <tr>
              <td>{{ $d->etudiant?->utilisateur?->prenom }} {{ $d->etudiant?->utilisateur?->nom }}</td>
              <td>{{ $d->type_document }}</td>
              <td style="color:#6b7280">{{ $d->date_depot->format('d/m/Y') }}</td>
            </tr>
          @empty
            <tr><td colspan="3"><div class="empty">Aucun document en attente</div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="card" style="padding:20px;display:flex;justify-content:space-between;align-items:center;background:linear-gradient(135deg,rgba(0,133,63,.05),rgba(253,239,66,.05))">
  <div>
    <h3 style="font-size:15px;font-weight:700;margin-bottom:4px">Actions rapides</h3>
    <p style="font-size:12.5px;color:#6b7280">Accédez directement à vos tâches principales</p>
  </div>
  <div style="display:flex;gap:10px;flex-wrap:wrap">
    <a href="{{ route('agent.candidatures', ['statut' => 'nouveau']) }}" class="btn btn-green">
      <i class="fas fa-inbox"></i> Nouvelles candidatures
    </a>
    <a href="{{ route('agent.annonces') }}" class="btn btn-outline">
      <i class="fas fa-bullhorn"></i> Publier une annonce
    </a>
  </div>
</div>
@endsection
