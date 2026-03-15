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
            ->leftJoin('ENSEIGNANT as e', 'e.id_enseignant', '=', 'f.responsable_id')
            ->leftJoin('Utilisateur as u', 'u.id_user', '=', 'e.id_user')
            ->leftJoin('ETUDIANT as et', 'et.id_filiere', '=', 'f.id_filiere')
            ->select(
                'f.id_filiere',
                'f.nom_filiere',
                'f.description',
                DB::raw("CONCAT(u.prenom, ' ', u.nom) as responsable"),
                DB::raw('COUNT(DISTINCT et.id_etudiant) as nb_etudiants')
            )
            ->groupBy('f.id_filiere', 'f.nom_filiere', 'f.description', 'u.prenom', 'u.nom')
            ->orderBy('f.nom_filiere')
            ->get();

        return view('admin.filieres.index', compact('filieres'));
    }

    public function create()
    {
        $enseignants = DB::table('ENSEIGNANT as e')
            ->join('Utilisateur as u', 'u.id_user', '=', 'e.id_user')
            ->where('u.actif', true)
            ->select('e.id_enseignant', 'u.nom', 'u.prenom', 'e.specialite')
            ->orderBy('u.nom')
            ->get();

        return view('admin.filieres.create', compact('enseignants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_filiere'    => 'required|string|max:100|unique:FILIERE,nom_filiere',
            'description'    => 'nullable|string',
            'responsable_id' => 'required|exists:ENSEIGNANT,id_enseignant',
        ]);

        $id = DB::table('FILIERE')->insertGetId([
            'nom_filiere'    => $request->nom_filiere,
            'description'    => $request->description,
            'responsable_id' => $request->responsable_id,
        ]);

        DB::table('LOG_ACTION')->insert([
            'action'           => 'CREATE',
            'table_concernee'  => 'FILIERE',
            'id_enregistrement'=> $id,
            'date_action'      => now(),
            'id_user'          => auth()->id(),
        ]);

        return redirect()->route('admin.filieres')->with('success', 'Filière créée avec succès.');
    }

    public function edit($id)
    {
        $filiere = DB::table('FILIERE')->where('id_filiere', $id)->first();
        abort_if(!$filiere, 404);

        $enseignants = DB::table('ENSEIGNANT as e')
            ->join('Utilisateur as u', 'u.id_user', '=', 'e.id_user')
            ->where('u.actif', true)
            ->select('e.id_enseignant', 'u.nom', 'u.prenom', 'e.specialite')
            ->orderBy('u.nom')
            ->get();

        return view('admin.filieres.edit', compact('filiere', 'enseignants'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_filiere'    => 'required|string|max:100|unique:FILIERE,nom_filiere,' . $id . ',id_filiere',
            'description'    => 'nullable|string',
            'responsable_id' => 'required|exists:ENSEIGNANT,id_enseignant',
        ]);

        DB::table('FILIERE')->where('id_filiere', $id)->update([
            'nom_filiere'    => $request->nom_filiere,
            'description'    => $request->description,
            'responsable_id' => $request->responsable_id,
        ]);

        DB::table('LOG_ACTION')->insert([
            'action'           => 'UPDATE',
            'table_concernee'  => 'FILIERE',
            'id_enregistrement'=> $id,
            'date_action'      => now(),
            'id_user'          => auth()->id(),
        ]);

        return redirect()->route('admin.filieres')->with('success', 'Filière mise à jour.');
    }

    public function destroy($id)
    {
        DB::table('FILIERE')->where('id_filiere', $id)->delete();

        DB::table('LOG_ACTION')->insert([
            'action'           => 'DELETE',
            'table_concernee'  => 'FILIERE',
            'id_enregistrement'=> $id,
            'date_action'      => now(),
            'id_user'          => auth()->id(),
        ]);

        return redirect()->route('admin.filieres')->with('success', 'Filière supprimée.');
    }
}
