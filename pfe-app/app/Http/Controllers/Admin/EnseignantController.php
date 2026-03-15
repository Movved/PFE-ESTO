<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EnseignantController extends Controller
{
    public function index()
    {
        $enseignants = DB::table('ENSEIGNANT')
            ->join('Utilisateur',  'Utilisateur.id_user',        '=', 'ENSEIGNANT.id_user')
            ->join('DEPARTEMENT',  'DEPARTEMENT.id_departement', '=', 'ENSEIGNANT.id_departement')
            ->select(
                'ENSEIGNANT.id_enseignant',
                'ENSEIGNANT.specialite',
                'ENSEIGNANT.is_chef',
                'Utilisateur.id_user',
                'Utilisateur.nom',
                'Utilisateur.prenom',
                'Utilisateur.email',
                'Utilisateur.actif',
                'DEPARTEMENT.nom_departement'
            )
            ->orderBy('Utilisateur.nom')
            ->get();

        return view('admin.enseignants', compact('enseignants'));
    }

    public function create()
    {
        $departements = DB::table('DEPARTEMENT')->orderBy('nom_departement')->get();
        return view('admin.enseignants_create', compact('departements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'            => 'required|string|max:40',
            'prenom'         => 'required|string|max:40',
            'email'          => 'required|email|unique:Utilisateur,email',
            'specialite'     => 'required|string|max:50',
            'id_departement' => 'required|exists:DEPARTEMENT,id_departement',
            'mot_de_passe'   => 'required|string|min:6',
        ]);

        $id_user = DB::table('Utilisateur')->insertGetId([
            'nom'           => $request->nom,
            'prenom'        => $request->prenom,
            'email'         => $request->email,
            'mot_de_passe'  => Hash::make($request->mot_de_passe),
            'role'          => 'ENSEIGNANT',
            'actif'         => true,
            'date_creation' => now(),
        ]);

        DB::table('ENSEIGNANT')->insert([
            'specialite'     => $request->specialite,
            'is_chef'        => $request->has('is_chef'),
            'id_departement' => $request->id_departement,
            'id_user'        => $id_user,
        ]);

        DB::table('LOG_ACTION')->insert([
            'action'            => 'CREATE',
            'table_concernee'   => 'ENSEIGNANT',
            'id_enregistrement' => $id_user,
            'date_action'       => now(),
            'id_user'           => auth()->id(),
        ]);

        return redirect()->route('admin.enseignants')->with('success', 'Enseignant créé avec succès.');
    }

    public function edit($id)
    {
        $enseignant = DB::table('ENSEIGNANT')
            ->join('Utilisateur',  'Utilisateur.id_user',        '=', 'ENSEIGNANT.id_user')
            ->join('DEPARTEMENT',  'DEPARTEMENT.id_departement', '=', 'ENSEIGNANT.id_departement')
            ->where('ENSEIGNANT.id_enseignant', $id)
            ->select('ENSEIGNANT.*', 'Utilisateur.*', 'DEPARTEMENT.nom_departement')
            ->first();

        abort_if(!$enseignant, 404);

        $departements = DB::table('DEPARTEMENT')->orderBy('nom_departement')->get();

        return view('admin.enseignants_edit', compact('enseignant', 'departements'));
    }

    public function update(Request $request, $id)
    {
        $enseignant = DB::table('ENSEIGNANT')->where('id_enseignant', $id)->first();
        abort_if(!$enseignant, 404);

        $request->validate([
            'nom'            => 'required|string|max:40',
            'prenom'         => 'required|string|max:40',
            'email'          => 'required|email|unique:Utilisateur,email,' . $enseignant->id_user . ',id_user',
            'specialite'     => 'required|string|max:50',
            'id_departement' => 'required|exists:DEPARTEMENT,id_departement',
        ]);

        DB::table('Utilisateur')->where('id_user', $enseignant->id_user)->update([
            'nom'    => $request->nom,
            'prenom' => $request->prenom,
            'email'  => $request->email,
            'actif'  => $request->has('actif'),
        ]);

        DB::table('ENSEIGNANT')->where('id_enseignant', $id)->update([
            'specialite'     => $request->specialite,
            'is_chef'        => $request->has('is_chef'),
            'id_departement' => $request->id_departement,
        ]);

        DB::table('LOG_ACTION')->insert([
            'action'            => 'UPDATE',
            'table_concernee'   => 'ENSEIGNANT',
            'id_enregistrement' => $id,
            'date_action'       => now(),
            'id_user'           => auth()->id(),
        ]);

        return redirect()->route('admin.enseignants')->with('success', 'Enseignant mis à jour.');
    }

    public function destroy($id)
    {
        $enseignant = DB::table('ENSEIGNANT')->where('id_enseignant', $id)->first();
        abort_if(!$enseignant, 404);

        DB::table('Utilisateur')->where('id_user', $enseignant->id_user)->delete();

        DB::table('LOG_ACTION')->insert([
            'action'            => 'DELETE',
            'table_concernee'   => 'ENSEIGNANT',
            'id_enregistrement' => $id,
            'date_action'       => now(),
            'id_user'           => auth()->id(),
        ]);

        return redirect()->route('admin.enseignants')->with('success', 'Enseignant supprimé.');
    }
}