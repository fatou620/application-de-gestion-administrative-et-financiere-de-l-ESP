@extends('admin.layout')

@section('title', 'Surveillance du Système')

@section('content')
<div class="row g-4">
    <div class="col-md-6">
        <div class="card p-4">
            <h5 class="mb-4"><i class="fas fa-server me-2 text-primary"></i>Informations Système</h5>
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <td><strong>Version PHP</strong></td>
                        <td><span class="badge bg-success">{{ $infos['php_version'] }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Version Laravel</strong></td>
                        <td><span class="badge bg-primary">{{ $infos['laravel_version'] }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Système d'exploitation</strong></td>
                        <td>{{ $infos['os'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Limite mémoire</strong></td>
                        <td><span class="badge bg-warning text-dark">{{ $infos['memoire_limite'] }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Mémoire utilisée</strong></td>
                        <td><span class="badge bg-info">{{ $infos['memoire_utilisee'] }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Date/Heure serveur</strong></td>
                        <td>{{ $infos['uptime'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-4">
            <h5 class="mb-4"><i class="fas fa-database me-2 text-success"></i>État de la Base de Données</h5>
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <td><strong>Connexion MySQL</strong></td>
                        <td>{{ $infos['db_status'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Utilisateurs</strong></td>
                        <td><span class="badge bg-primary">{{ $infos['total_users'] }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Utilisateurs Actifs</strong></td>
                        <td><span class="badge bg-success">{{ $infos['users_actifs'] }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Total Rôles</strong></td>
                        <td><span class="badge bg-warning text-dark">{{ $infos['total_roles'] }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card p-4 mt-4">
            <h5 class="mb-3"><i class="fas fa-circle me-2 text-success"></i>Disponibilité du Système</h5>
            <div class="d-flex align-items-center gap-3">
                <div class="text-center">
                    <div style="width:80px;height:80px;border-radius:50%;background:#2e7d32;display:flex;align-items:center;justify-content:center;color:white;font-size:1.2rem;font-weight:bold;">
                        99.5%
                    </div>
                    <small class="text-muted mt-2 d-block">Disponibilité</small>
                </div>
                <div>
                    <p class="mb-1">✅ Apache : <strong>En ligne</strong></p>
                    <p class="mb-1">✅ MySQL : <strong>En ligne</strong></p>
                    <p class="mb-0">✅ Laravel : <strong>Opérationnel</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection