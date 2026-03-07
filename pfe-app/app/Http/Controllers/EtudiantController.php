<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EtudiantController extends Controller
{
    private function getEtudiantId(): ?int
    {
        $user = Auth::user();
    
        if (!$user) return null;
    
        $etudiant = DB::table('ETUDIANT')
            ->where('id_user', $user->id_user)
            ->first();
    
        return $etudiant?->id_etudiant;
    }

    public function notes()
    {
        $idEtudiant = $this->getEtudiantId();

        if (!$idEtudiant) {
            abort(403, 'Accès refusé : utilisateur non étudiant.');
        }

        $notes = DB::table('NOTE')
            ->join('MODULE_', 'NOTE.id_module', '=', 'MODULE_.id_module')
            ->leftJoin('RECLAMATION', 'RECLAMATION.id_note', '=', 'NOTE.id_note')
            ->where('NOTE.id_etudiant', $idEtudiant)
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

        return view('etudiant.notes', compact('notes'));
    }
    public function storeReclamation(Request $request)
    {
        $request->validate([
            'id_note' => ['required', 'integer'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $idEtudiant = $this->getEtudiantId();

        if (!$idEtudiant) {
            return back()->with('error', 'Accès refusé : utilisateur non étudiant.');
        }

        $note = DB::table('NOTE')
            ->where('id_note', $request->id_note)
            ->where('id_etudiant', $idEtudiant)
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
}