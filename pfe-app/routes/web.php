<?php

use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\Admin\DashboardController   as AdminDashboard;
use App\Http\Controllers\Admin\EtudiantController    as AdminEtudiant;
use App\Http\Controllers\Admin\EnseignantController  as AdminEnseignant;
use App\Http\Controllers\Admin\NoteController        as AdminNote;
use App\Http\Controllers\Admin\ReclamationController as AdminReclamation;
use App\Http\Controllers\Admin\LogController         as AdminLog;
use App\Http\Controllers\Admin\FiliereController     as AdminFiliere;
use App\Http\Controllers\Admin\ModuleController      as AdminModule;
use App\Http\Controllers\Admin\SemestreController    as AdminSemestre;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChefController;

Route::get('/', function () {
    return response()
        ->view('welcome')
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
});

Route::middleware('auth')->group(function () {

    // ─── ADMIN ────────────────────────────────────────────────────────────────
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        // ... all your existing admin routes unchanged
    });

    // ─── ENSEIGNANT ───────────────────────────────────────────────────────────
    Route::middleware('enseignant')->group(function () {
        Route::get('/enseignant/dashboard',  [EnseignantController::class, 'dashboard'])->name('enseignant.dashboard');
        Route::get('/enseignant/modules',    [EnseignantController::class, 'modules'])->name('enseignant.modules');
        Route::get('/enseignant/modules/{id}', [EnseignantController::class, 'showModule'])->name('enseignant.module.show');
        Route::get('/enseignant/notes',      [EnseignantController::class, 'notes'])->name('enseignant.notes');
        Route::get('/enseignant/notes/{id}', [EnseignantController::class, 'notesForm'])->name('enseignant.notes.form');
        Route::post('/enseignant/notes/{id}',[EnseignantController::class, 'storeNotes'])->name('enseignant.notes.store');
        Route::get('/enseignant/notes/{id}/pv', [EnseignantController::class, 'pv'])->name('enseignant.notes.pv');
        Route::get('/enseignant/reclamations', [EnseignantController::class, 'reclamations'])->name('enseignant.reclamations');
        Route::patch('/enseignant/reclamations/{id}/traiter', [EnseignantController::class, 'traiterReclamation'])->name('enseignant.reclamations.traiter');
    });

    // ─── ETUDIANT ─────────────────────────────────────────────────────────────
    Route::middleware('etudiant')->group(function () {
        Route::get('/etudiant/dashboard',    [EtudiantController::class, 'dashboard'])->name('etudiant.dashboard');
        Route::get('/etudiant/notes',        [EtudiantController::class, 'notes'])->name('etudiant.notes');
        Route::get('/etudiant/cours',        [EtudiantController::class, 'cours'])->name('etudiant.cours');
        Route::post('/etudiant/reclamation', [EtudiantController::class, 'storeReclamation'])->name('etudiant.reclamation.store');
    });

    // ─── PROFILE ──────────────────────────────────────────────────────────────
    Route::get('/profile',          [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',        [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',       [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

});

// ─── CHEF ─────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'chef'])->group(function () {
    Route::get('/chef/dashboard', [ChefController::class, 'dashboard'])->name('chef.dashboard');
    Route::get('/chef/modules', [ChefController::class, 'modules'])->name('chef.modules');
    Route::post('/chef/modules', [ChefController::class, 'storeModule'])->name('chef.modules.store');
    Route::put('/chef/modules/{id}', [ChefController::class, 'updateModule'])->name('chef.modules.update');
    Route::delete('/chef/modules/{id}', [ChefController::class, 'deleteModule'])->name('chef.modules.delete');
    Route::get('/chef/filieres', [ChefController::class, 'filieres'])->name('chef.filieres');
    Route::post('/chef/filieres', [ChefController::class, 'storeFiliere'])->name('chef.filieres.store');
    Route::put('/chef/filieres/{id}', [ChefController::class, 'updateFiliere'])->name('chef.filieres.update');
    Route::delete('/chef/filieres/{id}', [ChefController::class, 'deleteFiliere'])->name('chef.filieres.delete');
    Route::get('/chef/etudiants', [ChefController::class, 'etudiants'])->name('chef.etudiants');
    Route::get('/chef/etudiants/{id}/notes', [ChefController::class, 'etudiantNotes'])->name('chef.etudiant.notes');
});

require __DIR__ . '/auth.php';