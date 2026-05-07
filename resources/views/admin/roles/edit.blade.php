@extends('admin.layout')

@section('title', 'Modifier un Rôle')

@section('content')
<div class="card p-4" style="max-width: 600px; margin: auto;">
    <h5 class="mb-4"><i class="fas fa-edit me-2"></i>Modifier le rôle</h5>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nom du rôle</label>
            <input type="text" name="nom" class="form-control" value="{{ $role->nom }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $role->description }}</textarea>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-save me-2"></i>Modifier
            </button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>
    </form>
</div>
@endsection