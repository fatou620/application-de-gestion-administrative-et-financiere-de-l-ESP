@extends('layouts.etudiant', ['titlePage' => 'Emploi & Annonces — ESP'])

@section('page_title', 'Emploi du temps & Annonces')
@section('page_sub', 'Informations académiques · ESP Dakar')

@section('content')
<div style="display:flex;gap:4px;margin-bottom:24px;background:#fff;border-radius:12px;padding:6px;border:1px solid #e5e7eb;width:fit-content">
  <button id="t-edt" class="btn btn-green" onclick="switchTab('emploi')">
    <i class="fas fa-calendar-week"></i> Emploi du temps
  </button>
  <button id="t-ann" class="btn btn-outline" onclick="switchTab('annonces')">
    <i class="fas fa-bullhorn"></i> Annonces ({{ count($annonces) }})
  </button>
</div>

<div id="panel-emploi">
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px" class="edt-grid">
    @foreach ($jours as $j)
      <div class="card">
        <div style="padding:14px 18px;font-size:14px;font-weight:700;border-bottom:1px solid #e5e7eb;display:flex;justify-content:space-between;align-items:center;{{ $j === $jourAujourdhui ? 'background:rgba(0,133,63,.08);color:#00853F' : '' }}">
          <span>{{ $j }}</span>
          @if ($j === $jourAujourdhui)
            <span style="background:#00853F;color:#fff;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px">Aujourd'hui</span>
          @endif
        </div>
        @forelse ($emploi[$j] as $s)
          <div style="padding:12px 18px;border-bottom:1px solid #e5e7eb;display:flex;gap:12px;align-items:flex-start">
            <div style="background:rgba(0,133,63,.1);color:#00853F;border-radius:8px;padding:6px 10px;font-size:11px;font-weight:700;min-width:70px;text-align:center">
              {{ substr($s->heure_debut, 0, 5) }}<br>{{ substr($s->heure_fin, 0, 5) }}
            </div>
            <div>
              <div style="font-size:13px;font-weight:600">{{ $s->matiere->nom }}</div>
              <div style="font-size:11px;color:#6b7280"><i class="fas fa-door-open"></i> Salle {{ $s->salle }}</div>
              @if ($s->enseignant)<div style="font-size:11px;color:#6b7280"><i class="fas fa-chalkboard-teacher"></i> {{ $s->enseignant }}</div>@endif
            </div>
          </div>
        @empty
          <div class="empty"><i class="fas fa-coffee"></i> Pas de cours</div>
        @endforelse
      </div>
    @endforeach
  </div>
</div>

<div id="panel-annonces" style="display:none">
  @forelse ($annonces as $a)
    <div class="card" style="padding:20px 24px;display:flex;gap:16px;margin-bottom:16px">
      <div style="width:42px;height:42px;border-radius:10px;flex-shrink:0;display:flex;align-items:center;justify-content:center;background:{{ $a->priorite === 'urgente' ? 'rgba(227,30,36,.12)' : 'rgba(0,133,63,.12)' }};color:{{ $a->priorite === 'urgente' ? '#E31E24' : '#00853F' }}">
        <i class="fas fa-{{ $a->priorite === 'urgente' ? 'exclamation-triangle' : 'bullhorn' }}" style="font-size:18px"></i>
      </div>
      <div style="flex:1">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
          <div style="font-size:15px;font-weight:700">{{ $a->titre }}</div>
          <span class="badge-status badge-{{ $a->priorite === 'urgente' ? 'rejete' : 'valide' }}">{{ $a->priorite }}</span>
        </div>
        <div style="font-size:13.5px;color:#374151;line-height:1.6;margin-top:6px">{!! nl2br(e($a->contenu)) !!}</div>
        <div style="margin-top:8px;font-size:11px;color:#6b7280">
          <i class="fas fa-clock"></i> {{ $a->date_publication->format('d/m/Y H:i') }}
        </div>
      </div>
    </div>
  @empty
    <div class="empty"><i class="fas fa-bullhorn"></i><p>Aucune annonce disponible</p></div>
  @endforelse
</div>

@push('styles')
<style>
  @media(max-width:1000px) { .edt-grid { grid-template-columns:1fr 1fr !important; } }
  @media(max-width:650px)  { .edt-grid { grid-template-columns:1fr !important; } }
</style>
@endpush

@push('scripts')
<script>
function switchTab(p) {
  document.getElementById('panel-emploi').style.display   = p === 'emploi' ? '' : 'none';
  document.getElementById('panel-annonces').style.display = p === 'annonces' ? '' : 'none';
  document.getElementById('t-edt').className = 'btn ' + (p === 'emploi'   ? 'btn-green' : 'btn-outline');
  document.getElementById('t-ann').className = 'btn ' + (p === 'annonces' ? 'btn-green' : 'btn-outline');
}
</script>
@endpush
@endsection
