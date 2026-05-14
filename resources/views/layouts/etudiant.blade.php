@php $espaceLabel = 'Espace Étudiant'; @endphp
@extends('layouts.sidebar')

@section('nav')
<div class="nav-section">
  <div class="nav-label">Principal</div>
  <a href="{{ route('etudiant.dashboard') }}" class="nav-link {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}">
    <i class="fas fa-home"></i> Tableau de bord
  </a>
  <a href="{{ route('etudiant.notes') }}" class="nav-link {{ request()->routeIs('etudiant.notes') ? 'active' : '' }}">
    <i class="fas fa-star"></i> Mes notes
  </a>
  <a href="{{ route('etudiant.emploi') }}" class="nav-link {{ request()->routeIs('etudiant.emploi') ? 'active' : '' }}">
    <i class="fas fa-calendar-week"></i> Emploi & Annonces
  </a>
</div>
<div class="nav-section">
  <div class="nav-label">Administratif</div>
  <a href="{{ route('etudiant.paiements') }}" class="nav-link {{ request()->routeIs('etudiant.paiements') ? 'active' : '' }}">
    <i class="fas fa-money-bill-wave"></i> Paiements
  </a>
  <a href="{{ route('etudiant.documents') }}" class="nav-link {{ request()->routeIs('etudiant.documents') ? 'active' : '' }}">
    <i class="fas fa-file-alt"></i> Documents
  </a>
</div>
<div class="nav-section">
  <div class="nav-label">Compte</div>
  <a href="{{ route('etudiant.profil') }}" class="nav-link {{ request()->routeIs('etudiant.profil') ? 'active' : '' }}">
    <i class="fas fa-user-circle"></i> Mon Profil
  </a>
</div>
@endsection
