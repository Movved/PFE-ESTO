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
        Route::get('/enseignant/dashboard', [EnseignantController::class, 'dashboard'])->name('enseignant.dashboard');

        Route::get('/enseignant/modules', [EnseignantController::class, 'modules'])->name('enseignant.modules');
        Route::get('/enseignant/modules/{id}', [EnseignantController::class, 'showModule'])->name('enseignant.module.show');

        Route::get('/enseignant/notes', [EnseignantController::class, 'notes'])->name('enseignant.notes');
        Route::get('/enseignant/notes/{id}', [EnseignantController::class, 'notesForm'])->name('enseignant.notes.form');
        Route::post('/enseignant/notes/{id}', [EnseignantController::class, 'storeNotes'])->name('enseignant.notes.store');
        Route::get('/enseignant/notes/{id}/pv', [EnseignantController::class, 'pv'])->name('enseignant.notes.pv');

        Route::get('/enseignant/reclamations', [EnseignantController::class, 'reclamations'])->name('enseignant.reclamations');
        Route::patch('/enseignant/reclamations/{id}/traiter', [EnseignantController::class, 'traiterReclamation'])->name('enseignant.reclamations.traiter');

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

});