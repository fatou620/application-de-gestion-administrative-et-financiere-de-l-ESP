@extends('admin.layout')

@section('title', 'Gestion des Sauvegardes')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5><i class="fas fa-database me-2"></i>Sauvegardes de la Base de Données</h5>
        <a href="{{ route('admin.sauvegardes.creer') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle Sauvegarde
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card p-3 text-center border-primary">
                <i class="fas fa-shield-alt fa-2x text-primary mb-2"></i>
                <h6>Sauvegarde Automatique</h6>
                <span class="badge bg-success">Activée</span>
                <small class="text-muted d-block mt-1">Tous les jours à 00:00</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 text-center border-success">
                <i class="fas fa-clock fa-2x text-success mb-2"></i>
                <h6>Dernière Sauvegarde</h6>
                <span class="badge bg-primary">{{ now()->format('d/m/Y') }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 text-center border-warning">
                <i class="fas fa-folder fa-2x text-warning mb-2"></i>
                <h6>Total Sauvegardes</h6>
                <span class="badge bg-warning text-dark">{{ count($sauvegardes) }}</span>
            </div>
        </div>
    </div>

    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nom du fichier</th>
                <th>Taille</th>
                <th>Date de création</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sauvegardes as $index => $s)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><i class="fas fa-file-alt me-2 text-primary"></i>{{ $s['nom'] }}</td>
                <td>{{ $s['taille'] }}</td>
                <td>{{ $s['date'] }}</td>
                <td><span class="badge bg-success">Complète</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">
                    Aucune sauvegarde disponible. Cliquez sur "Nouvelle Sauvegarde" pour en créer une.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
