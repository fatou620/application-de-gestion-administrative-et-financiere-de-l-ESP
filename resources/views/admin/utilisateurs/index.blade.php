@extends('admin.layout')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5><i class="fas fa-users me-2"></i>Liste des Utilisateurs</h5>
        <a href="{{ route('admin.utilisateurs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Créer un compte
        </a>
    </div>
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nom Complet</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Rôle</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($utilisateurs as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->nom }} {{ $u->prenom }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->telephone ?? '-' }}</td>
                <td><span class="badge bg-primary">{{ $u->role->nom ?? 'N/A' }}</span></td>
                <td>
                    @if($u->statut === 'actif')
                        <span class="badge bg-success">Actif</span>
                    @else
                        <span class="badge bg-danger">Inactif</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.utilisateurs.edit', $u->id) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{ route('admin.utilisateurs.toggle', $u->id) }}" class="btn btn-sm {{ $u->statut === 'actif' ? 'btn-danger' : 'btn-success' }}">
                        <i class="fas fa-{{ $u->statut === 'actif' ? 'ban' : 'check' }}"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection