<?php

use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// We keep this for now, but your Controller will likely send users to the specific ones below
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Your 3 Role-Specific Routes
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // Points to resources/views/admin/dashboard.blade.php
    })->name('admin.dashboard');

    Route::get('/enseignant/dashboard', [EnseignantController::class, 'dashboard'])->name('enseignant.dashboard');

    Route::get('/enseignant/modules', [EnseignantController::class, 'modules'])->name('enseignant.modules');
    Route::get('/enseignant/modules/{id}', [EnseignantController::class, 'showModule'])->name('enseignant.module.show');

    Route::get('/enseignant/notes', [EnseignantController::class, 'notes'])->name('enseignant.notes');
    Route::get('/enseignant/notes/{id}', [EnseignantController::class, 'notesForm'])->name('enseignant.notes.form');
    Route::post('/enseignant/notes/{id}', [EnseignantController::class, 'storeNotes'])->name('enseignant.notes.store');
    Route::get('/enseignant/notes/{id}/pv', [EnseignantController::class, 'pv'])->name('enseignant.notes.pv');

    Route::get('/enseignant/reclamations', [EnseignantController::class, 'reclamations'])->name('enseignant.reclamations');
    Route::patch('/enseignant/reclamations/{id}/traiter', [EnseignantController::class, 'traiterReclamation'])->name('enseignant.reclamations.traiter');

    Route::get('/etudiant/dashboard', function () {
        return view('etudiant.dashboard');
    })->name('etudiant.dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';