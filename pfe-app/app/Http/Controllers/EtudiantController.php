<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Reclamation;
use App\Models\Note;

class EtudiantController extends Controller
{
    // Tableau des notes
    public function notes()
    {
        $userId = Auth::id();

        $notes = DB::table('Note')
            ->join('Evaluation', 'Note.id_evaluation', '=', 'Evaluation.id_evaluation')
            ->join('Module',     'Evaluation.id_module', '=', 'Module.id_module')
            ->leftJoin('Reclamation', function ($join) use ($userId) {
                $join->on('Reclamation.id_note', '=', 'Note.id_note')
                     ->where('Reclamation.id_user', '=', $userId)
                     ->where('Reclamation.statut', '=', 'EN_ATTENTE');
            })
            ->where('Note.id_user', $userId)
            ->select(
                'Note.id_note',
                'Note.note',
                'Note.rattrapage',
                'Note.note_finale',
                'Evaluation.libelle',
                'Evaluation.type',
                'Module.nom_module',
                DB::raw('COUNT(Reclamation.id_reclamation) > 0 as has_reclamation')
            )
            ->groupBy(
                'Note.id_note', 'Note.note', 'Note.rattrapage', 'Note.note_finale',
                'Evaluation.libelle', 'Evaluation.type', 'Module.nom_module'
            )
            ->get();

        return view('etudiant.notes', compact('notes'));
    }

    // Fonction de reclamation button
    public function storeReclamation(Request $request)
    {
        $request->validate([
            'id_note' => ['required', 'integer'],
            'message' => ['required', 'string', 'max:1000'],
        ]);
    
        $userId = Auth::user()->id_user; 
    
        $note = \DB::table('note')
                   ->where('id_note', $request->id_note)
                   ->where('id_user', $userId)
                   ->first();
    
        if (!$note) {
            return back()->with('error', 'Note introuvable.');
        }
    
        $exists = \DB::table('eclamation')
                     ->where('id_note', $request->id_note)
                     ->where('id_user', $userId)
                     ->where('statut', 'EN_ATTENTE')
                     ->exists();
    
        if ($exists) {
            return back()->with('error', 'Vous avez déjà une réclamation en attente pour cette note.');
        }
    
        \DB::table('Reclamation')->insert([
            'id_note'          => $request->id_note,
            'id_user'          => $userId,
            'message'          => $request->message,
            'statut'           => 'EN_ATTENTE',
            'date_reclamation' => now(),
        ]);
    
        return back()->with('success', 'Réclamation envoyée avec succès.');
    }
}
