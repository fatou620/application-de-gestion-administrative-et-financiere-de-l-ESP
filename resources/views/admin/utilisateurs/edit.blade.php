@extends('admin.layout')

@section('title', 'Modifier un Compte')

@section('content')
<div class="card p-4" style="max-width: 700px; margin: auto;">
    <h5 class="mb-4"><i class="fas fa-user-edit me-2"></i>Modifier le compte</h5>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.utilisateurs.update', $utilisateur->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" value="{{ $utilisateur->nom }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" value="{{ $utilisateur->prenom }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $utilisateur->email }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Téléphone</label>
                <input type="text" name="telephone" class="form-control" value="{{ $utilisateur->telephone }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Rôle</label>
                <select name="role_id" class="form-select" required>
                    <option value="">-- Choisir un rôle --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $utilisateur->role_id == $role->id ? 'selected' : '' }}>
                            {{ $role->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-save me-2"></i>Modifier
            </button>
            <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>
    </form>
</div>
@endsection