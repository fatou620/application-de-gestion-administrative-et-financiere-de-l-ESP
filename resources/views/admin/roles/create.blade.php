@extends('admin.layout')

@section('title', 'Créer un Rôle')

@section('content')
<div class="card p-4" style="max-width: 600px; margin: auto;">
    <h5 class="mb-4"><i class="fas fa-plus me-2"></i>Créer un nouveau rôle</h5>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nom du rôle</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" placeholder="ex: etudiant, enseignant..." required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Description du rôle...">{{ old('description') }}</textarea>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Créer
            </button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>
    </form>
</div>
@endsection