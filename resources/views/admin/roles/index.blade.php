@extends('admin.layout')

@section('title', 'Gestion des Rôles')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5><i class="fas fa-user-tag me-2"></i>Liste des Rôles</h5>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Créer un rôle
        </a>
    </div>
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Utilisateurs</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td><span class="badge bg-primary">{{ $role->nom }}</span></td>
                <td>{{ $role->description ?? '-' }}</td>
                <td><span class="badge bg-secondary">{{ $role->utilisateurs_count }}</span></td>
                <td>
                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection