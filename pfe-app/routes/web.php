<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // Etudiants
        Route::get('/etudiants',           [AdminEtudiant::class, 'index'])->name('etudiants');
        Route::get('/etudiants/create',    [AdminEtudiant::class, 'create'])->name('etudiants.create');
        Route::post('/etudiants',          [AdminEtudiant::class, 'store'])->name('etudiants.store');
        Route::get('/etudiants/{id}/edit', [AdminEtudiant::class, 'edit'])->name('etudiants.edit');
        Route::put('/etudiants/{id}',      [AdminEtudiant::class, 'update'])->name('etudiants.update');
        Route::delete('/etudiants/{id}',   [AdminEtudiant::class, 'destroy'])->name('etudiants.destroy');

        // Enseignants
        Route::get('/enseignants',           [AdminEnseignant::class, 'index'])->name('enseignants');
        Route::get('/enseignants/create',    [AdminEnseignant::class, 'create'])->name('enseignants.create');
        Route::post('/enseignants',          [AdminEnseignant::class, 'store'])->name('enseignants.store');
        Route::get('/enseignants/{id}/edit', [AdminEnseignant::class, 'edit'])->name('enseignants.edit');
        Route::put('/enseignants/{id}',      [AdminEnseignant::class, 'update'])->name('enseignants.update');
        Route::delete('/enseignants/{id}',   [AdminEnseignant::class, 'destroy'])->name('enseignants.destroy');

        // Filières
        Route::get('/filieres',           [AdminFiliere::class, 'index'])->name('filieres');
        Route::get('/filieres/create',    [AdminFiliere::class, 'create'])->name('filieres.create');
        Route::post('/filieres',          [AdminFiliere::class, 'store'])->name('filieres.store');
        Route::get('/filieres/{id}/edit', [AdminFiliere::class, 'edit'])->name('filieres.edit');
        Route::put('/filieres/{id}',      [AdminFiliere::class, 'update'])->name('filieres.update');
        Route::delete('/filieres/{id}',   [AdminFiliere::class, 'destroy'])->name('filieres.destroy');

        // Modules
        Route::get('/modules',           [AdminModule::class, 'index'])->name('modules');
        Route::get('/modules/create',    [AdminModule::class, 'create'])->name('modules.create');
        Route::post('/modules',          [AdminModule::class, 'store'])->name('modules.store');
        Route::get('/modules/{id}/edit', [AdminModule::class, 'edit'])->name('modules.edit');
        Route::put('/modules/{id}',      [AdminModule::class, 'update'])->name('modules.update');
        Route::delete('/modules/{id}',   [AdminModule::class, 'destroy'])->name('modules.destroy');

        // Semestres
        Route::get('/semestres',           [AdminSemestre::class, 'index'])->name('semestres');
        Route::get('/semestres/create',    [AdminSemestre::class, 'create'])->name('semestres.create');
        Route::post('/semestres',          [AdminSemestre::class, 'store'])->name('semestres.store');
        Route::get('/semestres/{id}/edit', [AdminSemestre::class, 'edit'])->name('semestres.edit');
        Route::put('/semestres/{id}',      [AdminSemestre::class, 'update'])->name('semestres.update');
        Route::delete('/semestres/{id}',   [AdminSemestre::class, 'destroy'])->name('semestres.destroy');

        // Notes
        Route::get('/notes',           [AdminNote::class, 'index'])->name('notes');
        Route::get('/notes/{id}/edit', [AdminNote::class, 'edit'])->name('notes.edit');
        Route::put('/notes/{id}',      [AdminNote::class, 'update'])->name('notes.update');

        // Reclamations
        Route::get('/reclamations',         [AdminReclamation::class, 'index'])->name('reclamations');
        Route::get('/reclamations/{id}',    [AdminReclamation::class, 'show'])->name('reclamations.show');
        Route::delete('/reclamations/{id}', [AdminReclamation::class, 'destroy'])->name('reclamations.destroy');

        // Logs
        Route::get('/logs', [AdminLog::class, 'index'])->name('logs');

    });

    Route::get('/enseignant/dashboard', function () {
        return view('enseignant.dashboard');
    })->name('enseignant.dashboard');

    Route::get('/etudiant/dashboard',    [EtudiantController::class, 'dashboard'])->name('etudiant.dashboard');
    Route::get('/etudiant/notes',        [EtudiantController::class, 'notes'])->name('etudiant.notes');
    Route::get('/etudiant/cours',        [EtudiantController::class, 'cours'])->name('etudiant.cours');
    Route::post('/etudiant/reclamation', [EtudiantController::class, 'storeReclamation'])->name('etudiant.reclamation.store');

    Route::get('/profile',          [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',        [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',       [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

});

require __DIR__ . '/auth.php';