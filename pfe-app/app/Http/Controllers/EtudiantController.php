<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EtudiantController extends Controller
{
    private function getEtudiant()
    {
        return DB::table('ETUDIANT')
            ->where('id_user', Auth::user()->id_user)
            ->first();
    }

    /**
     * Dashboard étudiant
     */
    public function dashboard()
    {
        $etudiant = $this->getEtudiant();

        $notes             = collect();
        $recentNotes       = collect();
        $reclamations      = collect();
        $totalModules      = 0;
        $notesCount        = 0;
        $moyenne           = 0;
        $reclamationsCount = 0;
        $pendingCount      = 0;

        if ($etudiant) {
            $notes = DB::table('NOTE')
                ->join('MODULE', 'NOTE.id_module', '=', 'MODULE.id_module')
                ->leftJoin('RECLAMATION', 'RECLAMATION.id_note', '=', 'NOTE.id_note')
                ->where('NOTE.id_etudiant', $etudiant->id_etudiant)
                ->select(
                    'NOTE.id_note',
                    'NOTE.note',
                    'NOTE.rattrapage',
                    'MODULE.code_module',
                    'MODULE.nom_module',
                    DB::raw('COUNT(RECLAMATION.id_reclamation) > 0 AS has_reclamation')
                )
                ->groupBy(
                    'NOTE.id_note', 'NOTE.note', 'NOTE.rattrapage',
                    'MODULE.code_module', 'MODULE.nom_module'
                )
                ->get();

            $totalModules = $notes->count();
            $notesCount   = $notes->whereNotNull('note')->count();
            $moyenne      = $notesCount > 0
                ? $notes->whereNotNull('note')->avg('note')
                : 0;

            $recentNotes = $notes->whereNotNull('note')->take(4)->values();

            $reclamations = DB::table('RECLAMATION')
                ->join('NOTE', 'RECLAMATION.id_note', '=', 'NOTE.id_note')
                ->join('MODULE', 'NOTE.id_module', '=', 'MODULE.id_module')
                ->where('NOTE.id_etudiant', $etudiant->id_etudiant)
                ->select(
                    'RECLAMATION.id_reclamation',
                    'RECLAMATION.message',
                    'RECLAMATION.date_reclamation',
                    'MODULE.nom_module'
                )
                ->orderByDesc('RECLAMATION.date_reclamation')
                ->get();

            $reclamationsCount = $reclamations->count();
            $pendingCount      = $reclamationsCount;
        }

        return view('etudiant.dashboard', compact(
            'etudiant', 'notes', 'recentNotes', 'reclamations',
            'totalModules', 'notesCount', 'moyenne',
            'reclamationsCount', 'pendingCount'
        ));
    }

    /**
     * Tableau des notes
     */
    public function notes()
    {
        $etudiant = $this->getEtudiant();

        if (!$etudiant) {
            abort(403, 'Accès refusé : utilisateur non étudiant.');
        }

        $notes = DB::table('NOTE')
            ->join('MODULE', 'NOTE.id_module', '=', 'MODULE.id_module')
            ->leftJoin('RECLAMATION', 'RECLAMATION.id_note', '=', 'NOTE.id_note')
            ->where('NOTE.id_etudiant', $etudiant->id_etudiant)
            ->select(
                'NOTE.id_note',
                'NOTE.note',
                'NOTE.rattrapage',
                'MODULE.code_module',
                'MODULE.nom_module',
                DB::raw('COUNT(RECLAMATION.id_reclamation) > 0 AS has_reclamation')
            )
            ->groupBy(
                'NOTE.id_note', 'NOTE.note', 'NOTE.rattrapage',
                'MODULE.code_module', 'MODULE.nom_module'
            )
            ->get();

        return view('etudiant.notes', compact('notes'));
    }

    /**
     * Soumettre une réclamation
     */
    public function storeReclamation(Request $request)
    {
        $request->validate([
            'id_note' => ['required', 'integer'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $etudiant = $this->getEtudiant();

        if (!$etudiant) {
            return back()->with('error', 'Accès refusé : utilisateur non étudiant.');
        }

        $note = DB::table('NOTE')
            ->where('id_note', $request->id_note)
            ->where('id_etudiant', $etudiant->id_etudiant)
            ->first();

        if (!$note) {
            return back()->with('error', 'Note introuvable ou accès non autorisé.');
        }

        $exists = DB::table('RECLAMATION')
            ->where('id_note', $request->id_note)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Une réclamation existe déjà pour cette note.');
        }

        DB::table('RECLAMATION')->insert([
            'id_note'          => $request->id_note,
            'message'          => $request->message,
            'date_reclamation' => now(),
        ]);

        return back()->with('success', 'Réclamation envoyée avec succès.');
        
    }
    /**
     * Mes cours pagee
     */
    public function cours()
{
    $etudiant = $this->getEtudiant();

    if (!$etudiant) {
        abort(403, 'Accès refusé : utilisateur non étudiant.');
    }

    $cours = DB::table('inscrire')
        ->join('SEMESTRE', 'inscrire.id_semestre', '=', 'SEMESTRE.id_semestre')
        ->join('ANNEE_ACADEMIQUE', 'SEMESTRE.id_annee', '=', 'ANNEE_ACADEMIQUE.id_annee')
        ->join('FILIERE', 'ANNEE_ACADEMIQUE.id_filiere', '=', 'FILIERE.id_filiere')
        ->join('MODULE', 'MODULE.id_semestre', '=', 'SEMESTRE.id_semestre')
        ->join('ENSEIGNANT', 'MODULE.id_enseignant', '=', 'ENSEIGNANT.id_enseignant')
        ->join('Utilisateur', 'ENSEIGNANT.id_user', '=', 'Utilisateur.id_user')
        ->where('inscrire.id_etudiant', $etudiant->id_etudiant)
        ->select(
            'MODULE.id_module',
            'MODULE.code_module',
            'MODULE.nom_module',
            'SEMESTRE.numero as semestre_numero',
            'SEMESTRE.cloture',
            'ANNEE_ACADEMIQUE.libelle as annee',
            'FILIERE.nom_filiere',
            'Utilisateur.nom as prof_nom',
            'Utilisateur.prenom as prof_prenom',
            'ENSEIGNANT.specialite'
        )
        ->orderBy('SEMESTRE.numero')
        ->get()
        ->groupBy('semestre_numero');

    return view('etudiant.cours', compact('cours'));
}
}