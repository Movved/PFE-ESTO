<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EtudiantController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    Route::get('/enseignant/dashboard', function () {
        return view('enseignant.dashboard');
    })->name('enseignant.dashboard');

    Route::get('/etudiant/dashboard', function () {
        $etudiant = DB::table('ETUDIANT')
            ->where('id_user', Auth::id())
            ->first();

        $notes = collect();

        if ($etudiant) {
            $notes = DB::table('NOTE')
                ->join('MODULE_', 'NOTE.id_module', '=', 'MODULE_.id_module')
                ->leftJoin('RECLAMATION', 'RECLAMATION.id_note', '=', 'NOTE.id_note')
                ->where('NOTE.id_etudiant', $etudiant->id_etudiant)
                ->select(
                    'NOTE.id_note',
                    'NOTE.note',
                    'NOTE.rattrapage',
                    'MODULE_.code_module',
                    'MODULE_.nom_module',
                    DB::raw('COUNT(RECLAMATION.id_reclamation) > 0 AS has_reclamation')
                )
                ->groupBy(
                    'NOTE.id_note',
                    'NOTE.note',
                    'NOTE.rattrapage',
                    'MODULE_.code_module',
                    'MODULE_.nom_module'
                )
                ->get();
        }

        return view('etudiant.dashboard', compact('notes'));
    })->name('etudiant.dashboard');

    Route::get('/etudiant/notes', [EtudiantController::class, 'notes'])->name('etudiant.notes');
    Route::post('/etudiant/reclamation', [EtudiantController::class, 'storeReclamation'])->name('etudiant.reclamation.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';