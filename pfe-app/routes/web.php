<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        #Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // Placeholders — swap the closure for a real controller when ready
        Route::get('/notes',        fn() => view('admin.notes'))->name('notes.index');
        Route::get('/etudiants',    fn() => view('admin.etudiants.index'))->name('etudiants.index');
        Route::get('/etudiants/create', fn() => view('admin.etudiants.create'))->name('etudiants.create');
        Route::get('/enseignants',  fn() => view('admin.enseignants.index'))->name('enseignants.index');
        Route::get('/enseignants/create', fn() => view('admin.enseignants.create'))->name('enseignants.create');
        Route::get('/filieres',     fn() => view('admin.filieres.index'))->name('filieres.index');
        Route::get('/filieres/create', fn() => view('admin.filieres.create'))->name('filieres.create');
        Route::get('/modules',      fn() => view('admin.modules.index'))->name('modules.index');
        Route::get('/modules/create', fn() => view('admin.modules.create'))->name('modules.create');
        Route::get('/semestres',    fn() => view('admin.semestres.index'))->name('semestres.index');
        Route::get('/reclamations', fn() => view('admin.reclamations.index'))->name('reclamations.index');
        Route::get('/reclamations/{id}', fn($id) => view('admin.reclamations.show', ['id' => $id]))->name('reclamations.show');
        Route::get('/logs',         fn() => view('admin.logs.index'))->name('logs.index');

    });


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