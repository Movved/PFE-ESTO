<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('MODULE_ as m')
            ->join('SEMESTRE as s', 's.id_semestre', '=', 'm.id_semestre')
            ->join('ANNEE_ACADEMIQUE as a', 'a.id_annee', '=', 's.id_annee')
            ->join('FILIERE as f', 'f.id_filiere', '=', 'a.id_filiere')
            ->leftJoin('intervenir as i', 'i.id_module', '=', 'm.id_module')
            ->leftJoin('ENSEIGNANT as e', 'e.id_enseignant', '=', 'i.id_enseignant')
            ->leftJoin('Utilisateur as u', 'u.id_user', '=', 'e.id_user')
            ->select(
                'm.id_module',
                'm.code_module',
                'm.nom_module',
                's.numero as semestre_numero',
                'a.libelle as annee_libelle',
                'f.nom_filiere',
                DB::raw("CONCAT(u.prenom, ' ', u.nom) as enseignant")
            );

        if ($request->filled('filiere')) {
            $query->where('f.id_filiere', $request->filiere);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('m.nom_module', 'like', '%' . $request->search . '%')
                  ->orWhere('m.code_module', 'like', '%' . $request->search . '%');
            });
        }

        $modules  = $query->orderBy('f.nom_filiere')->orderBy('s.numero')->orderBy('m.nom_module')->get();
        $filieres = DB::table('FILIERE')->orderBy('nom_filiere')->get();

        return view('admin.modules.index', compact('modules', 'filieres'));
    }

    public function create()
    {
        $semestres = DB::table('SEMESTRE as s')
            ->join('ANNEE_ACADEMIQUE as a', 'a.id_annee', '=', 's.id_annee')
            ->join('FILIERE as f', 'f.id_filiere', '=', 'a.id_filiere')
            ->select('s.id_semestre', 's.numero', 'a.libelle', 'f.nom_filiere')
            ->orderBy('f.nom_filiere')->orderBy('a.libelle')->orderBy('s.numero')
            ->get();

        $enseignants = DB::table('ENSEIGNANT as e')
            ->join('Utilisateur as u', 'u.id_user', '=', 'e.id_user')
            ->where('u.actif', true)
            ->select('e.id_enseignant', 'u.nom', 'u.prenom', 'e.specialite')
            ->orderBy('u.nom')
            ->get();

        return view('admin.modules.create', compact('semestres', 'enseignants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code_module'    => 'required|string|max:20|unique:MODULE_,code_module',
            'nom_module'     => 'required|string|max:100',
            'id_semestre'    => 'required|exists:SEMESTRE,id_semestre',
            'id_enseignant'  => 'nullable|exists:ENSEIGNANT,id_enseignant',
        ]);

        $id = DB::table('MODULE_')->insertGetId([
            'code_module' => $request->code_module,
            'nom_module'  => $request->nom_module,
            'id_semestre' => $request->id_semestre,
        ]);

        if ($request->filled('id_enseignant')) {
            DB::table('intervenir')->insert([
                'id_enseignant' => $request->id_enseignant,
                'id_module'     => $id,
            ]);
        }

        DB::table('LOG_ACTION')->insert([
            'action'           => 'CREATE',
            'table_concernee'  => 'MODULE_',
            'id_enregistrement'=> $id,
            'date_action'      => now(),
            'id_user'          => auth()->id(),
        ]);

        return redirect()->route('admin.modules')->with('success', 'Module créé avec succès.');
    }

    public function edit($id)
    {
        $module = DB::table('MODULE_ as m')
            ->join('SEMESTRE as s', 's.id_semestre', '=', 'm.id_semestre')
            ->leftJoin('intervenir as i', 'i.id_module', '=', 'm.id_module')
            ->select('m.*', 's.numero as semestre_numero', 'i.id_enseignant')
            ->where('m.id_module', $id)
            ->first();

        abort_if(!$module, 404);

        $semestres = DB::table('SEMESTRE as s')
            ->join('ANNEE_ACADEMIQUE as a', 'a.id_annee', '=', 's.id_annee')
            ->join('FILIERE as f', 'f.id_filiere', '=', 'a.id_filiere')
            ->select('s.id_semestre', 's.numero', 'a.libelle', 'f.nom_filiere')
            ->orderBy('f.nom_filiere')->orderBy('a.libelle')->orderBy('s.numero')
            ->get();

        $enseignants = DB::table('ENSEIGNANT as e')
            ->join('Utilisateur as u', 'u.id_user', '=', 'e.id_user')
            ->where('u.actif', true)
            ->select('e.id_enseignant', 'u.nom', 'u.prenom', 'e.specialite')
            ->orderBy('u.nom')
            ->get();

        return view('admin.modules.edit', compact('module', 'semestres', 'enseignants'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code_module'   => 'required|string|max:20|unique:MODULE_,code_module,' . $id . ',id_module',
            'nom_module'    => 'required|string|max:100',
            'id_semestre'   => 'required|exists:SEMESTRE,id_semestre',
            'id_enseignant' => 'nullable|exists:ENSEIGNANT,id_enseignant',
        ]);

        DB::table('MODULE_')->where('id_module', $id)->update([
            'code_module' => $request->code_module,
            'nom_module'  => $request->nom_module,
            'id_semestre' => $request->id_semestre,
        ]);

        // Update intervenir pivot
        DB::table('intervenir')->where('id_module', $id)->delete();
        if ($request->filled('id_enseignant')) {
            DB::table('intervenir')->insert([
                'id_enseignant' => $request->id_enseignant,
                'id_module'     => $id,
            ]);
        }

        DB::table('LOG_ACTION')->insert([
            'action'           => 'UPDATE',
            'table_concernee'  => 'MODULE_',
            'id_enregistrement'=> $id,
            'date_action'      => now(),
            'id_user'          => auth()->id(),
        ]);

        return redirect()->route('admin.modules')->with('success', 'Module mis à jour.');
    }

    public function destroy($id)
    {
        DB::table('MODULE_')->where('id_module', $id)->delete();

        DB::table('LOG_ACTION')->insert([
            'action'           => 'DELETE',
            'table_concernee'  => 'MODULE_',
            'id_enregistrement'=> $id,
            'date_action'      => now(),
            'id_user'          => auth()->id(),
        ]);

        return redirect()->route('admin.modules')->with('success', 'Module supprimé.');
    }
}
