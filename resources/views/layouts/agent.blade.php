@php $espaceLabel = 'Agent Administratif'; @endphp
@extends('layouts.sidebar')

@section('nav')
<div class="nav-section">
  <div class="nav-label">Principal</div>
  <a href="{{ route('agent.dashboard') }}" class="nav-link {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
    <i class="fas fa-home"></i> Tableau de bord
  </a>
</div>
<div class="nav-section">
  <div class="nav-label">Gestion académique</div>
  <a href="{{ route('agent.candidatures') }}" class="nav-link {{ request()->routeIs('agent.candidatures*') ? 'active' : '' }}">
    <i class="fas fa-user-plus"></i> Candidatures
  </a>
  <a href="{{ route('agent.inscriptions') }}" class="nav-link {{ request()->routeIs('agent.inscriptions*') ? 'active' : '' }}">
    <i class="fas fa-clipboard-check"></i> Inscriptions
  </a>
  <a href="{{ route('agent.documents') }}" class="nav-link {{ request()->routeIs('agent.documents*') ? 'active' : '' }}">
    <i class="fas fa-folder-open"></i> Documents à valider
  </a>
</div>
<div class="nav-section">
  <div class="nav-label">Communication</div>
  <a href="{{ route('agent.annonces') }}" class="nav-link {{ request()->routeIs('agent.annonces*') ? 'active' : '' }}">
    <i class="fas fa-bullhorn"></i> Annonces
  </a>
</div>
@endsection
