<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReclamationController extends Controller
{
    public function index()
    {
        $reclamations = DB::table('reclamation as r')
            ->join('note as n',        'n.id_note',       '=', 'r.id_note')
            ->join('etudiant as et',   'et.id_etudiant',  '=', 'n.id_etudiant')
            ->join('utilisateur as u', 'u.id_user',       '=', 'et.id_user')
            ->join('module as m',      'm.id_module',     '=', 'n.id_module')
            ->select(
                'r.id_reclamation', 'r.message', 'r.date_reclamation', 'r.statut',
                'r.id_note',
                'n.note', 'n.rattrapage',
                'u.nom', 'u.prenom',
                'et.cne',
                'm.nom_module', 'm.code_module'
            )
            ->orderBy('r.date_reclamation', 'desc')
            ->get();

        return view('admin.reclamations', compact('reclamations'));
    }

    public function show($id)
    {
        $reclamation = DB::table('reclamation as r')
            ->join('note as n',        'n.id_note',       '=', 'r.id_note')
            ->join('etudiant as et',   'et.id_etudiant',  '=', 'n.id_etudiant')
            ->join('utilisateur as u', 'u.id_user',       '=', 'et.id_user')
            ->join('module as m',      'm.id_module',     '=', 'n.id_module')
            ->select(
                'r.id_reclamation', 'r.message', 'r.date_reclamation', 'r.statut',
                'r.id_note',
                'n.note', 'n.rattrapage',
                'u.nom', 'u.prenom',
                'et.cne',
                'm.nom_module', 'm.code_module'
            )
            ->where('r.id_reclamation', $id)
            ->first();

        abort_if(!$reclamation, 404);

        return view('admin.reclamations_show', compact('reclamation'));
    }

    public function updateStatut(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,traitee,rejetee',
        ]);

        DB::table('reclamation')->where('id_reclamation', $id)->update([
            'statut' => $request->statut,
        ]);

        DB::table('log_action')->insert([
            'action'            => 'UPDATE',
            'table_concernee'   => 'reclamation',
            'id_enregistrement' => $id,
            'date_action'       => now(),
            'id_user'           => auth()->user()->id_user,
        ]);

        return redirect()->route('admin.reclamations.show', $id)->with('success', 'Statut mis à jour.');
    }

    public function destroy($id)
    {
        DB::table('reclamation')->where('id_reclamation', $id)->delete();
        DB::table('log_action')->insert(['action' => 'DELETE', 'table_concernee' => 'reclamation', 'id_enregistrement' => $id, 'date_action' => now(), 'id_user' => auth()->user()->id_user]);
        return redirect()->route('admin.reclamations')->with('success', 'Réclamation supprimée.');
    }
}