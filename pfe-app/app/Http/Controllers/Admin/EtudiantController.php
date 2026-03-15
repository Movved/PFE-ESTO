<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends Controller
{
    public function index()
    {
        $etudiants = DB::table('ETUDIANT')
            ->join('Utilisateur', 'Utilisateur.id_user', '=', 'ETUDIANT.id_user')
            ->select(
                'ETUDIANT.id_etudiant',
                'ETUDIANT.cne',
                'Utilisateur.id_user',
                'Utilisateur.nom',
                'Utilisateur.prenom',
                'Utilisateur.email',
                'Utilisateur.actif',
                'Utilisateur.date_creation'
            )
            ->orderByDesc('Utilisateur.date_creation')
            ->get();

        return view('admin.etudiants', compact('etudiants'));
    }

    public function create()
    {
        return view('admin.etudiants_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'          => 'required|string|max:40',
            'prenom'       => 'required|string|max:40',
            'email'        => 'required|email|unique:Utilisateur,email',
            'cne'          => 'required|string|max:20|unique:ETUDIANT,cne',
            'mot_de_passe' => 'required|string|min:6',
        ]);

        $id_user = DB::table('Utilisateur')->insertGetId([
            'nom'           => $request->nom,
            'prenom'        => $request->prenom,
            'email'         => $request->email,
            'mot_de_passe'  => Hash::make($request->mot_de_passe),
            'role'          => 'ETUDIANT',
            'actif'         => true,
            'date_creation' => now(),
        ]);

        DB::table('ETUDIANT')->insert([
            'cne'     => $request->cne,
            'id_user' => $id_user,
        ]);

        DB::table('LOG_ACTION')->insert([
            'action'            => 'CREATE',
            'table_concernee'   => 'ETUDIANT',
            'id_enregistrement' => $id_user,
            'date_action'       => now(),
            'id_user'           => auth()->id(),
        ]);

        return redirect()->route('admin.etudiants')->with('success', 'Étudiant créé avec succès.');
    }

    public function edit($id)
    {
        $etudiant = DB::table('ETUDIANT')
            ->join('Utilisateur', 'Utilisateur.id_user', '=', 'ETUDIANT.id_user')
            ->where('ETUDIANT.id_etudiant', $id)
            ->select('ETUDIANT.*', 'Utilisateur.*')
            ->first();

        abort_if(!$etudiant, 404);

        return view('admin.etudiants_edit', compact('etudiant'));
    }

    public function update(Request $request, $id)
    {
        $etudiant = DB::table('ETUDIANT')->where('id_etudiant', $id)->first();
        abort_if(!$etudiant, 404);

        $request->validate([
            'nom'    => 'required|string|max:40',
            'prenom' => 'required|string|max:40',
            'email'  => 'required|email|unique:Utilisateur,email,' . $etudiant->id_user . ',id_user',
            'cne'    => 'required|string|max:20|unique:ETUDIANT,cne,' . $id . ',id_etudiant',
        ]);

        DB::table('Utilisateur')->where('id_user', $etudiant->id_user)->update([
            'nom'    => $request->nom,
            'prenom' => $request->prenom,
            'email'  => $request->email,
            'actif'  => $request->has('actif'),
        ]);

        DB::table('ETUDIANT')->where('id_etudiant', $id)->update([
            'cne' => $request->cne,
        ]);

        DB::table('LOG_ACTION')->insert([
            'action'            => 'UPDATE',
            'table_concernee'   => 'ETUDIANT',
            'id_enregistrement' => $id,
            'date_action'       => now(),
            'id_user'           => auth()->id(),
        ]);

        return redirect()->route('admin.etudiants')->with('success', 'Étudiant mis à jour.');
    }

    public function destroy($id)
    {
        $etudiant = DB::table('ETUDIANT')->where('id_etudiant', $id)->first();
        abort_if(!$etudiant, 404);

        DB::table('Utilisateur')->where('id_user', $etudiant->id_user)->delete();

        DB::table('LOG_ACTION')->insert([
            'action'            => 'DELETE',
            'table_concernee'   => 'ETUDIANT',
            'id_enregistrement' => $id,
            'date_action'       => now(),
            'id_user'           => auth()->id(),
        ]);

        return redirect()->route('admin.etudiants')->with('success', 'Étudiant supprimé.');
    }
}