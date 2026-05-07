<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UtilisateurController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SurveillanceController;
use App\Http\Controllers\Admin\SauvegardeController;
use App\Http\Controllers\Admin\RapportController;

Route::get('/', function () {
    return redirect('/login');
});

// Routes Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Utilisateurs
    Route::get('/utilisateurs', [UtilisateurController::class, 'index'])->name('utilisateurs.index');
    Route::get('/utilisateurs/create', [UtilisateurController::class, 'create'])->name('utilisateurs.create');
    Route::post('/utilisateurs', [UtilisateurController::class, 'store'])->name('utilisateurs.store');
    Route::get('/utilisateurs/{id}/edit', [UtilisateurController::class, 'edit'])->name('utilisateurs.edit');
    Route::put('/utilisateurs/{id}', [UtilisateurController::class, 'update'])->name('utilisateurs.update');
    Route::get('/utilisateurs/{id}/toggle', [UtilisateurController::class, 'toggleStatut'])->name('utilisateurs.toggle');

    // Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');

    // Surveillance
    Route::get('/surveillance', [SurveillanceController::class, 'index'])->name('surveillance.index');

    // Sauvegardes
    Route::get('/sauvegardes', [SauvegardeController::class, 'index'])->name('sauvegardes.index');
    Route::get('/sauvegardes/creer', [SauvegardeController::class, 'creer'])->name('sauvegardes.creer');

    // Rapports
    Route::get('/rapports', [RapportController::class, 'index'])->name('rapports.index');
});

require __DIR__.'/auth.php';