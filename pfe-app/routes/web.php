<?php
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\EtudiantController;  // ← add this
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    
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
            $userId = Auth::user()->id_user;
            $notes = \DB::table('Note')
                ->join('Evaluation', 'Note.id_evaluation', '=', 'Evaluation.id_evaluation')
                ->join('Module',     'Evaluation.id_module', '=', 'Module.id_module')
                ->leftJoin('Reclamation', function ($join) use ($userId) {
                    $join->on('Reclamation.id_note', '=', 'Note.id_note')
                         ->where('Reclamation.id_user', '=', $userId)
                         ->where('Reclamation.statut', '=', 'EN_ATTENTE');
                })
                ->where('Note.id_user', $userId)
                ->select(
                    'Note.id_note', 'Note.note', 'Note.rattrapage', 'Note.note_finale',
                    'Evaluation.libelle', 'Evaluation.type', 'Module.nom_module',
                    \DB::raw('COUNT(Reclamation.id_reclamation) > 0 as has_reclamation')
                )
                ->groupBy(
                    'Note.id_note', 'Note.note', 'Note.rattrapage', 'Note.note_finale',
                    'Evaluation.libelle', 'Evaluation.type', 'Module.nom_module'
                )
                ->get();
            return view('etudiant.dashboard', compact('notes'));
        })->name('etudiant.dashboard');
    
        Route::post('/etudiant/reclamation', [EtudiantController::class, 'storeReclamation'])->name('etudiant.reclamation.store');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

require __DIR__.'/auth.php';