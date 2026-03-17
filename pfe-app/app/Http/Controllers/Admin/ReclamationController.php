<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReclamationController extends Controller
{
    public function index()
    {
        $reclamations = DB::table('RECLAMATION')
            ->join('NOTE',        'NOTE.id_note',         '=', 'RECLAMATION.id_note')
            ->join('ETUDIANT',    'ETUDIANT.id_etudiant', '=', 'NOTE.id_etudiant')
            ->join('Utilisateur', 'Utilisateur.id_user',  '=', 'ETUDIANT.id_user')
            ->join('MODULE',     'MODULE.id_module',    '=', 'NOTE.id_module')
            ->select(
                'RECLAMATION.id_reclamation',
                'RECLAMATION.message',
                'RECLAMATION.date_reclamation',
                'Utilisateur.nom',
                'Utilisateur.prenom',
                'ETUDIANT.cne',
                'MODULE.nom_module',
                'MODULE.code_module',
                'NOTE.note',
                'NOTE.rattrapage'
            )
            ->orderByDesc('RECLAMATION.date_reclamation')
            ->get();

        return view('admin.reclamations', compact('reclamations'));
    }

    public function show($id)
    {
        $reclamation = DB::table('RECLAMATION')
            ->join('NOTE',        'NOTE.id_note',         '=', 'RECLAMATION.id_note')
            ->join('ETUDIANT',    'ETUDIANT.id_etudiant', '=', 'NOTE.id_etudiant')
            ->join('Utilisateur', 'Utilisateur.id_user',  '=', 'ETUDIANT.id_user')
            ->join('MODULE',     'MODULE.id_module',    '=', 'NOTE.id_module')
            ->where('RECLAMATION.id_reclamation', $id)
            ->select(
                'RECLAMATION.*',
                'Utilisateur.nom',
                'Utilisateur.prenom',
                'ETUDIANT.cne',
                'MODULE.nom_module',
                'MODULE.code_module',
                'NOTE.id_note',
                'NOTE.note',
                'NOTE.rattrapage'
            )
            ->first();

        abort_if(!$reclamation, 404);

        return view('admin.reclamations_show', compact('reclamation'));
    }

    public function destroy($id)
    {
        DB::table('RECLAMATION')->where('id_reclamation', $id)->delete();

        DB::table('LOG_ACTION')->insert([
            'action'            => 'DELETE',
            'table_concernee'   => 'RECLAMATION',
            'id_enregistrement' => $id,
            'date_action'       => now(),
            'id_user'           => auth()->id(),
        ]);

        return redirect()->route('admin.reclamations')->with('success', 'Réclamation supprimée.');
    }
}