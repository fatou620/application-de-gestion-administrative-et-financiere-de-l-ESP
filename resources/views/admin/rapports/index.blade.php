@extends('admin.layout')

@section('title', 'Rapports d\'Activité')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card p-3" style="border-left-color: #1a237e;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Total Utilisateurs</p>
                    <h3 class="fw-bold">{{ $totalUtilisateurs }}</h3>
                </div>
                <i class="fas fa-users fa-2x text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3" style="border-left-color: #2e7d32;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Comptes Actifs</p>
                    <h3 class="fw-bold text-success">{{ $totalActifs }}</h3>
                </div>
                <i class="fas fa-user-check fa-2x text-success"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3" style="border-left-color: #c62828;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Comptes Inactifs</p>
                    <h3 class="fw-bold text-danger">{{ $totalInactifs }}</h3>
                </div>
                <i class="fas fa-user-times fa-2x text-danger"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3" style="border-left-color: #e65100;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Taux d'Activité</p>
                    <h3 class="fw-bold text-warning">{{ $tauxActivite }}%</h3>
                </div>
                <i class="fas fa-chart-pie fa-2x text-warning"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card p-4">
            <h5 class="mb-4"><i class="fas fa-chart-bar me-2 text-primary"></i>Utilisateurs par Rôle</h5>
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Rôle</th>
                        <th>Nombre</th>
                        <th>Pourcentage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($utilisateursParRole as $role)
                    <tr>
                        <td><span class="badge bg-primary">{{ $role->nom }}</span></td>
                        <td>{{ $role->utilisateurs_count }}</td>
                        <td>
                            @if($totalUtilisateurs > 0)
                                {{ round(($role->utilisateurs_count / $totalUtilisateurs) * 100, 1) }}%
                            @else
                                0%
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-4">
            <h5 class="mb-4"><i class="fas fa-chart-pie me-2 text-success"></i>Taux d'Activité Global</h5>
            <div class="text-center py-3">
                <div style="width:150px;height:150px;border-radius:50%;background:conic-gradient(#2e7d32 {{ $tauxActivite }}%, #c62828 0);margin:auto;display:flex;align-items:center;justify-content:center;">
                    <div style="width:100px;height:100px;border-radius:50%;background:white;display:flex;align-items:center;justify-content:center;">
                        <strong>{{ $tauxActivite }}%</strong>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="me-3"><i class="fas fa-circle text-success"></i> Actifs ({{ $totalActifs }})</span>
                    <span><i class="fas fa-circle text-danger"></i> Inactifs ({{ $totalInactifs }})</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
