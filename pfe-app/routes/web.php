<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EtudiantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/notes', function () {
        return view('admin.notes');
    })->name('admin.notes');

    Route::get('/admin/cours', function () {
        return view('admin.cours');
    })->name('admin.cours');





    Route::get('/enseignant/dashboard', function () {
        return view('enseignant.dashboard');
    })->name('enseignant.dashboard');

    Route::get('/etudiant/dashboard', [EtudiantController::class, 'dashboard'])->name('etudiant.dashboard');
    Route::get('/etudiant/notes', [EtudiantController::class, 'notes'])->name('etudiant.notes');
    Route::get('/etudiant/cours', [EtudiantController::class, 'cours'])->name('etudiant.cours');
    Route::post('/etudiant/reclamation', [EtudiantController::class, 'storeReclamation'])->name('etudiant.reclamation.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

});

require __DIR__ . '/auth.php';