<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FiliereController extends Controller
{
    public function index()
    {
        $filieres = DB::table('FILIERE as f')
            ->leftJoin('SEMESTRE as s', 's.id_filiere', '=', 'f.id_filiere')
            ->leftJoin('inscrire as i', 'i.id_semestre', '=', 's.id_semestre')
            ->leftJoin('ETUDIANT as et', 'et.id_etudiant', '=', 'i.id_etudiant')
            ->select(
                'f.id_filiere',
                'f.nom_filiere',
                'f.description',
                DB::raw('COUNT(DISTINCT et.id_etudiant) as nb_etudiants')
            )
            ->groupBy('f.id_filiere', 'f.nom_filiere', 'f.description')
            ->orderBy('f.nom_filiere')
            ->get();

        return view('admin.filieres.index', compact('filieres'));
    }

    public function create()
    {
        return view('admin.filieres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_filiere' => 'required|string|max:255|unique:FILIERE,nom_filiere',
            'description' => 'nullable|string',
        ]);

        $id = DB::table('FILIERE')->insertGetId([
            'nom_filiere' => $request->nom_filiere,
            'description' => $request->description,
        ]);

        DB::table('LOG_ACTION')->insert([
            'action'            => 'CREATE',
            'table_concernee'   => 'FILIERE',
            'id_enregistrement' => $id,
            'date_action'       => now(),
            'id_user'           => auth()->id(),
        ]);

        return redirect()->route('admin.filieres')->with('success', 'Filière créée avec succès.');
    }

    public function edit($id)
    {
        $filiere = DB::table('FILIERE')->where('id_filiere', $id)->first();
        abort_if(!$filiere, 404);

        return view('admin.filieres.edit', compact('filiere'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_filiere' => 'required|string|max:255|unique:FILIERE,nom_filiere,' . $id . ',id_filiere',
            'description' => 'nullable|string',
        ]);

        DB::table('FILIERE')->where('id_filiere', $id)->update([
            'nom_filiere' => $request->nom_filiere,
            'description' => $request->description,
        ]);

        DB::table('LOG_ACTION')->insert([
            'action'            => 'UPDATE',
            'table_concernee'   => 'FILIERE',
            'id_enregistrement' => $id,
            'date_action'       => now(),
            'id_user'           => auth()->id(),
        ]);

        return redirect()->route('admin.filieres')->with('success', 'Filière mise à jour.');
    }

    public function destroy($id)
    {
        DB::table('FILIERE')->where('id_filiere', $id)->delete();

        DB::table('LOG_ACTION')->insert([
            'action'            => 'DELETE',
            'table_concernee'   => 'FILIERE',
            'id_enregistrement' => $id,
            'date_action'       => now(),
            'id_user'           => auth()->id(),
        ]);

        return redirect()->route('admin.filieres')->with('success', 'Filière supprimée.');
    }
}   