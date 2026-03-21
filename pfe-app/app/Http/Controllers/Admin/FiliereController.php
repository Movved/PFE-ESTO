<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FiliereController extends Controller
{
    public function index()
    {
        // SEMESTRE maintenant a id_filiere directement mb9atch annee_academique.id_filiere
        $filieres = DB::table('filiere as f')
            ->join('departement as d', 'd.id_departement', '=', 'f.id_departement')
            ->leftJoin('semestre as s', 's.id_filiere', '=', 'f.id_filiere')
            ->leftJoin('inscrire as i', 'i.id_semestre', '=', 's.id_semestre')
            ->select(
                'f.id_filiere', 'f.nom_filiere', 'f.description',
                'f.id_departement',
                'd.nom_departement',
                DB::raw('COUNT(DISTINCT i.id_etudiant) as nb_etudiants')
            )
            ->groupBy('f.id_filiere', 'f.nom_filiere', 'f.description', 'f.id_departement', 'd.nom_departement')
            ->orderBy('d.nom_departement')->orderBy('f.nom_filiere')
            ->get();

        $departements = DB::table('departement')->orderBy('nom_departement')->get();

        return view('admin.filieres', compact('filieres', 'departements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_filiere'    => 'required|string|max:100|unique:filiere,nom_filiere',
            'description'    => 'nullable|string',
            'id_departement' => 'required|exists:departement,id_departement',
        ]);

        $id = DB::table('filiere')->insertGetId([
            'nom_filiere'    => $request->nom_filiere,
            'description'    => $request->description,
            'id_departement' => $request->id_departement,
        ]);

        DB::table('log_action')->insert(['action' => 'CREATE', 'table_concernee' => 'filiere', 'id_enregistrement' => $id, 'date_action' => now(), 'id_user' => auth()->user()->id_user]);

        return redirect()->route('admin.filieres')->with('success', 'Filière créée avec succès.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_filiere'    => 'required|string|max:100|unique:filiere,nom_filiere,' . $id . ',id_filiere',
            'description'    => 'nullable|string',
            'id_departement' => 'required|exists:departement,id_departement',
        ]);

        DB::table('filiere')->where('id_filiere', $id)->update([
            'nom_filiere'    => $request->nom_filiere,
            'description'    => $request->description,
            'id_departement' => $request->id_departement,
        ]);

        DB::table('log_action')->insert(['action' => 'UPDATE', 'table_concernee' => 'filiere', 'id_enregistrement' => $id, 'date_action' => now(), 'id_user' => auth()->user()->id_user]);

        return redirect()->route('admin.filieres')->with('success', 'Filière mise à jour.');
    }

    public function destroy($id)
    {
        DB::table('filiere')->where('id_filiere', $id)->delete();
        DB::table('log_action')->insert(['action' => 'DELETE', 'table_concernee' => 'filiere', 'id_enregistrement' => $id, 'date_action' => now(), 'id_user' => auth()->user()->id_user]);
        return redirect()->route('admin.filieres')->with('success', 'Filière supprimée.');
    }
}