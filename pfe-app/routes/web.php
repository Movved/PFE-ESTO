<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Enseignant\DashboardController as EnseignantDashboardController;
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

    // Teacher Routes
    Route::get('/enseignant/dashboard', [EnseignantDashboardController::class, 'index'])->name('enseignant.dashboard');
    Route::get('/enseignant/filieres', [EnseignantDashboardController::class, 'filieres'])->name('enseignant.filieres');
    Route::get('/enseignant/filiere/{id}', [EnseignantDashboardController::class, 'showFiliere'])->name('enseignant.filiere.show');
    Route::get('/enseignant/filiere/{filiere_id}/student/{student_id}', [EnseignantDashboardController::class, 'showStudent'])->name('enseignant.student.show');
    Route::post('/enseignant/student/update-grade', [EnseignantDashboardController::class, 'updateGrade'])->name('enseignant.student.update-grade');
    Route::post('/enseignant/student/update-grades', [EnseignantDashboardController::class, 'updateGrades'])->name('enseignant.student.update-grades');

    Route::get('/etudiant/dashboard', function () {
        return view('etudiant.dashboard');
    })->name('etudiant.dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';