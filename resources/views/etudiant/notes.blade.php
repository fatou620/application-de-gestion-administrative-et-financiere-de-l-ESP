@extends('layouts.etudiant', ['titlePage' => 'Mes Notes — ESP'])

@section('page_title', 'Mes Notes')
@section('page_sub', 'Résultats académiques · '.date('Y'))

@section('content')
<div class="stats-grid" style="grid-template-columns:repeat(3,1fr)">
  <div class="stat-card">
    <div class="stat-icon green"><i class="fas fa-star"></i></div>
    <div>
      <div class="stat-value">{{ $moyGen ?? '—' }}/20</div>
      <div class="stat-label">Moyenne pondérée — {{ $mention }}</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon blue"><i class="fas fa-book"></i></div>
    <div>
      <div class="stat-value">{{ count($matieres) }}</div>
      <div class="stat-label">Matières</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon purple"><i class="fas fa-clipboard-list"></i></div>
    <div>
      <div class="stat-value">{{ $totalNotes }}</div>
      <div class="stat-label">Notes totales</div>
    </div>
  </div>
</div>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>Matière</th>
        <th>Coeff.</th>
        <th>CC (40%)</th>
        <th>Examen (60%)</th>
        <th>Moyenne</th>
        <th>Barre</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($matieres as $m)
        @php
          $cls = $m['moyenne'] >= 14 ? '#00853F' : ($m['moyenne'] >= 10 ? '#f97316' : '#E31E24');
          $pct = $m['moyenne'] ? min(100, $m['moyenne']/20*100) : 0;
        @endphp
        <tr>
          <td>
            <strong>{{ $m['nom'] }}</strong><br>
            <small style="color:#6b7280">{{ $m['credits'] }} crédits</small>
          </td>
          <td>{{ $m['coefficient'] }}</td>
          <td style="font-weight:700;color:{{ isset($m['cc']) ? ($m['cc']>=10?'#00853F':'#E31E24') : '#6b7280' }}">
            {{ isset($m['cc']) ? number_format($m['cc'],2) : '—' }}
          </td>
          <td style="font-weight:700;color:{{ isset($m['examen']) ? ($m['examen']>=10?'#00853F':'#E31E24') : '#6b7280' }}">
            {{ isset($m['examen']) ? number_format($m['examen'],2) : '—' }}
          </td>
          <td style="font-weight:700;font-size:16px;color:{{ $m['moyenne'] !== null ? $cls : '#6b7280' }}">
            {{ $m['moyenne'] ?? '—' }}
          </td>
          <td style="width:140px">
            @if ($m['moyenne'])
              <div style="height:6px;background:#e5e7eb;border-radius:3px;overflow:hidden">
                <div style="height:100%;width:{{ $pct }}%;background:linear-gradient(90deg,#00853F,#34d399)"></div>
              </div>
              <div style="font-size:10px;color:#6b7280;margin-top:2px">{{ round($pct) }}%</div>
            @endif
          </td>
        </tr>
      @empty
        <tr><td colspan="6"><div class="empty"><i class="fas fa-star"></i> Aucune note disponible pour le moment</div></td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
