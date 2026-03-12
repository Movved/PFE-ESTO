<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EtudiantController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

require __DIR__ . '/auth.php';