@php $espaceLabel = 'Responsable Financier'; @endphp
@extends('layouts.sidebar')

@section('nav')
<div class="nav-section">
  <div class="nav-label">Principal</div>
  <a href="{{ route('finance.dashboard') }}" class="nav-link {{ request()->routeIs('finance.dashboard') ? 'active' : '' }}">
    <i class="fas fa-home"></i> Tableau de bord
  </a>
</div>
<div class="nav-section">
  <div class="nav-label">Finances</div>
  <a href="{{ route('finance.paiements') }}" class="nav-link {{ request()->routeIs('finance.paiements*') ? 'active' : '' }}">
    <i class="fas fa-money-check-alt"></i> Paiements
  </a>
  <a href="{{ route('finance.etudiants') }}" class="nav-link {{ request()->routeIs('finance.etudiants*') ? 'active' : '' }}">
    <i class="fas fa-user-graduate"></i> Étudiants
  </a>
  <a href="{{ route('finance.irregularites') }}" class="nav-link {{ request()->routeIs('finance.irregularites*') ? 'active' : '' }}">
    <i class="fas fa-exclamation-triangle"></i> Irrégularités
  </a>
</div>
<div class="nav-section">
  <div class="nav-label">Reporting</div>
  <a href="{{ route('finance.rapport') }}" class="nav-link {{ request()->routeIs('finance.rapport') ? 'active' : '' }}">
    <i class="fas fa-chart-line"></i> Rapport
  </a>
</div>
@endsection
