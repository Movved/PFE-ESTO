<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('module as m')
            ->join('semestre as s',         's.id_semestre', '=', 'm.id_semestre')
            ->join('annee_academique as a',  'a.id_annee',    '=', 's.id_annee')
            ->join('filiere as f',           'f.id_filiere',  '=', 'a.id_filiere')
            ->leftJoin('enseignant as e',    'e.id_enseignant', '=', 'm.id_enseignant')
            ->leftJoin('utilisateur as u',   'u.id_user',     '=', 'e.id_user')
            ->select(
                'm.id_module', 'm.code_module', 'm.nom_module',
                'm.id_semestre', 'm.id_enseignant',
                's.numero as semestre_numero', 's.cloture',
                'a.libelle as annee_libelle',
                'f.nom_filiere',
                'u.nom as prof_nom', 'u.prenom as prof_prenom'
            );

        if ($request->filled('filiere')) {
            $query->where('f.id_filiere', $request->filiere);
        }
        if ($request->filled('search')) {
            $query->where(fn($q) => $q->where('m.nom_module', 'like', '%'.$request->search.'%')
                                      ->orWhere('m.code_module', 'like', '%'.$request->search.'%'));
        }

        $modules  = $query->orderBy('f.nom_filiere')->orderBy('s.numero')->orderBy('m.nom_module')->get();
        $filieres = DB::table('filiere')->orderBy('nom_filiere')->get();

        $semestres = DB::table('semestre as s')
            ->join('annee_academique as a', 'a.id_annee',   '=', 's.id_annee')
            ->join('filiere as f',          'f.id_filiere', '=', 'a.id_filiere')
            ->select('s.id_semestre', 's.numero', 'a.libelle', 'f.nom_filiere')
            ->orderBy('f.nom_filiere')->orderBy('a.libelle')->orderBy('s.numero')
            ->get();

        $enseignants = DB::table('enseignant as e')
            ->join('utilisateur as u', 'u.id_user', '=', 'e.id_user')
            ->where('u.actif', true)
            ->select('e.id_enseignant', 'u.nom', 'u.prenom', 'e.specialite')
            ->orderBy('u.nom')->get();

        return view('admin.modules', compact('modules', 'filieres', 'semestres', 'enseignants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code_module'   => 'required|string|max:20|unique:module,code_module',
            'nom_module'    => 'required|string|max:100',
            'id_semestre'   => 'required|exists:semestre,id_semestre',
            'id_enseignant' => 'nullable|exists:enseignant,id_enseignant',
        ]);

        $id = DB::table('module')->insertGetId([
            'code_module'   => $request->code_module,
            'nom_module'    => $request->nom_module,
            'id_semestre'   => $request->id_semestre,
            'id_enseignant' => $request->id_enseignant ?: null,
        ]);

        DB::table('log_action')->insert(['action' => 'CREATE', 'table_concernee' => 'module', 'id_enregistrement' => $id, 'date_action' => now(), 'id_user' => auth()->user()->id_user]);

        return redirect()->route('admin.modules')->with('success', 'Module créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code_module'   => 'required|string|max:20|unique:module,code_module,'.$id.',id_module',
            'nom_module'    => 'required|string|max:100',
            'id_semestre'   => 'required|exists:semestre,id_semestre',
            'id_enseignant' => 'nullable|exists:enseignant,id_enseignant',
        ]);

        DB::table('module')->where('id_module', $id)->update([
            'code_module'   => $request->code_module,
            'nom_module'    => $request->nom_module,
            'id_semestre'   => $request->id_semestre,
            'id_enseignant' => $request->id_enseignant ?: null,
        ]);

        DB::table('log_action')->insert(['action' => 'UPDATE', 'table_concernee' => 'module', 'id_enregistrement' => $id, 'date_action' => now(), 'id_user' => auth()->user()->id_user]);

        return redirect()->route('admin.modules')->with('success', 'Module mis à jour.');
    }

    public function destroy($id)
    {
        $notes = DB::table('note')->where('id_module', $id)->pluck('id_note');
        DB::table('reclamation')->whereIn('id_note', $notes)->delete();
        DB::table('note')->where('id_module', $id)->delete();
        DB::table('module')->where('id_module', $id)->delete();
        DB::table('log_action')->insert(['action' => 'DELETE', 'table_concernee' => 'module', 'id_enregistrement' => $id, 'date_action' => now(), 'id_user' => auth()->user()->id_user]);
        return redirect()->route('admin.modules')->with('success', 'Module supprimé.');
    }
}