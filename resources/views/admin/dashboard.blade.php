@extends('admin.layout')

@section('title', 'Dashboard Administrateur')

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
                    <p class="text-muted mb-1">Total Rôles</p>
                    <h3 class="fw-bold text-warning">{{ $totalRoles }}</h3>
                </div>
                <i class="fas fa-user-tag fa-2x text-warning"></i>
            </div>
        </div>
    </div>
</div>

<div class="card p-4">
    <h5 class="mb-3"><i class="fas fa-clock me-2"></i>Derniers utilisateurs créés</h5>
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($derniersUtilisateurs as $u)
            <tr>
                <td>{{ $u->nom }}</td>
                <td>{{ $u->prenom }}</td>
                <td>{{ $u->email }}</td>
                <td><span class="badge bg-primary">{{ $u->role->nom ?? 'N/A' }}</span></td>
                <td>
                    @if($u->statut === 'actif')
                        <span class="badge bg-success">Actif</span>
                    @else
                        <span class="badge bg-danger">Inactif</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection