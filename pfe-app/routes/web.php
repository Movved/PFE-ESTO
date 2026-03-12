<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EtudiantController;
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
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/enseignant/dashboard', fn() => view('enseignant.dashboard'))->name('enseignant.dashboard');
    Route::get('/etudiant/dashboard', [EtudiantController::class, 'dashboard'])->name('etudiant.dashboard');
    Route::get('/etudiant/notes', [EtudiantController::class, 'notes'])->name('etudiant.notes');
    Route::get('/etudiant/cours', [EtudiantController::class, 'cours'])->name('etudiant.cours');
    Route::post('/etudiant/reclamation', [EtudiantController::class, 'storeReclamation'])->name('etudiant.reclamation.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Pour chef de departement

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

require __DIR__ . '/auth.php';