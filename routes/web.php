<?php

use App\Http\Controllers\AgentAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Etudiant\DashboardController as EtuDashboard;
use App\Http\Controllers\Etudiant\DocumentController as EtuDocument;
use App\Http\Controllers\Etudiant\EmploiAnnonceController as EtuEmploi;
use App\Http\Controllers\Etudiant\NoteController as EtuNote;
use App\Http\Controllers\Etudiant\PaiementController as EtuPaiement;
use App\Http\Controllers\Etudiant\ProfilController as EtuProfil;
use App\Http\Controllers\Finance\FinanceController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// ============================================================
//  AUTH (publique)
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/',         [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ============================================================
//  HOME (redirection par rôle)
// ============================================================
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// ============================================================
//  ESPACE ÉTUDIANT
// ============================================================
Route::middleware(['auth', 'role:etudiant'])
    ->prefix('etudiant')
    ->name('etudiant.')
    ->group(function () {
        Route::get('/dashboard', [EtuDashboard::class, 'index'])->name('dashboard');

        Route::get('/notes', [EtuNote::class, 'index'])->name('notes');

        Route::get('/paiements',  [EtuPaiement::class, 'index'])->name('paiements');
        Route::post('/paiements', [EtuPaiement::class, 'store']);

        Route::get('/documents',           [EtuDocument::class, 'index'])->name('documents');
        Route::post('/documents',          [EtuDocument::class, 'store']);
        Route::delete('/documents/{doc}',  [EtuDocument::class, 'destroy'])->name('documents.destroy');

        Route::get('/emploi-annonces', [EtuEmploi::class, 'index'])->name('emploi');

        Route::get('/profil',          [EtuProfil::class, 'index'])->name('profil');
        Route::post('/profil',         [EtuProfil::class, 'update']);
        Route::post('/profil/password',[EtuProfil::class, 'updatePassword'])->name('profil.password');
    });

// ============================================================
//  ESPACE AGENT ADMINISTRATIF
// ============================================================
Route::middleware(['auth', 'role:agent_administratif,admin'])
    ->prefix('agent')
    ->name('agent.')
    ->group(function () {
        Route::get('/dashboard', [AgentAdminController::class, 'dashboard'])->name('dashboard');

        // Candidatures
        Route::get('/candidatures',                  [AgentAdminController::class, 'candidatures'])->name('candidatures');
        Route::get('/candidatures/{candidat}',       [AgentAdminController::class, 'showCandidature'])->name('candidatures.show');
        Route::post('/candidatures/{candidat}/valider', [AgentAdminController::class, 'validerCandidature'])->name('candidatures.valider');
        Route::post('/candidatures/{candidat}/rejeter', [AgentAdminController::class, 'rejeterCandidature'])->name('candidatures.rejeter');

        // Inscriptions
        Route::get('/inscriptions',                       [AgentAdminController::class, 'inscriptions'])->name('inscriptions');
        Route::post('/inscriptions/{inscription}/valider', [AgentAdminController::class, 'validerInscription'])->name('inscriptions.valider');

        // Documents étudiants à valider
        Route::get('/documents',                  [AgentAdminController::class, 'documents'])->name('documents');
        Route::post('/documents/{doc}/valider',   [AgentAdminController::class, 'validerDocument'])->name('documents.valider');
        Route::post('/documents/{doc}/rejeter',   [AgentAdminController::class, 'rejeterDocument'])->name('documents.rejeter');

        // Annonces
        Route::get('/annonces',           [AgentAdminController::class, 'annonces'])->name('annonces');
        Route::post('/annonces',          [AgentAdminController::class, 'storeAnnonce'])->name('annonces.store');
        Route::delete('/annonces/{ann}',  [AgentAdminController::class, 'destroyAnnonce'])->name('annonces.destroy');
    });

// ============================================================
//  ESPACE RESPONSABLE FINANCIER
// ============================================================
Route::middleware(['auth', 'role:responsable_financier,admin'])
    ->prefix('finance')
    ->name('finance.')
    ->group(function () {
        Route::get('/dashboard',  [FinanceController::class, 'dashboard'])->name('dashboard');
        Route::get('/paiements',  [FinanceController::class, 'paiements'])->name('paiements');
        Route::post('/paiements/{paiement}/valider', [FinanceController::class, 'validerPaiement'])->name('paiements.valider');
        Route::get('/paiements/{paiement}/recu',     [FinanceController::class, 'recu'])->name('paiements.recu');
        Route::get('/etudiants',     [FinanceController::class, 'etudiants'])->name('etudiants');
        Route::get('/irregularites', [FinanceController::class, 'irregularites'])->name('irregularites');
        Route::get('/rapport',       [FinanceController::class, 'rapport'])->name('rapport');
    });

// ============================================================
//  ESPACES À VENIR (Enseignant, Admin)
// ============================================================
Route::middleware(['auth', 'role:enseignant'])
    ->get('/enseignant/dashboard', fn () => view('placeholder', ['titre' => 'Espace Enseignant']))
    ->name('enseignant.dashboard');

Route::middleware(['auth', 'role:admin'])
    ->get('/admin/dashboard', fn () => view('placeholder', ['titre' => 'Espace Administrateur']))
    ->name('admin.dashboard');
