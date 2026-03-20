<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemestreController extends Controller
{
    public function index()
    {
        $semestres = DB::table('SEMESTRE as s')
            ->join('ANNEE_ACADEMIQUE as a', 'a.id_annee', '=', 's.id_annee')
            ->join('FILIERE as f', 'f.id_filiere', '=', 's.id_filiere')
            ->leftJoin('MODULE as m', 'm.id_semestre', '=', 's.id_semestre')
            ->leftJoin('inscrire as ins', 'ins.id_semestre', '=', 's.id_semestre')
            ->select(
                's.id_semestre',
                's.numero',
                's.cloture',
                'a.libelle as annee_libelle',
                'a.id_annee',
                'f.nom_filiere',
                'f.id_filiere',
                DB::raw('COUNT(DISTINCT m.id_module) as nb_modules'),
                DB::raw('COUNT(DISTINCT ins.id_etudiant) as nb_inscrits')
            )
            ->groupBy('s.id_semestre', 's.numero', 's.cloture', 'a.libelle', 'a.id_annee', 'f.nom_filiere', 'f.id_filiere')
            ->orderBy('f.nom_filiere')->orderBy('a.libelle')->orderBy('s.numero')
            ->get();

        return view('admin.semestres.index', compact('semestres'));
    }

    public function create()
    {
        $annees   = DB::table('ANNEE_ACADEMIQUE')->select('id_annee', 'libelle')->orderBy('libelle')->get();
        $filieres = DB::table('FILIERE')->select('id_filiere', 'nom_filiere')->orderBy('nom_filiere')->get();

        return view('admin.semestres.create', compact('annees', 'filieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero'     => 'required|integer|min:1|max:6',
            'id_annee'   => 'required|exists:ANNEE_ACADEMIQUE,id_annee',
            'id_filiere' => 'required|exists:FILIERE,id_filiere',
        ]);

        // Prevent duplicate semestre number within same annee + filiere
        $exists = DB::table('SEMESTRE')
            ->where('id_annee', $request->id_annee)
            ->where('id_filiere', $request->id_filiere)
            ->where('numero', $request->numero)
            ->exists();

        if ($exists) {
            return back()->withErrors(['numero' => 'Ce semestre existe déjà pour cette filière et cette année académique.'])->withInput();
        }

        $id = DB::table('SEMESTRE')->insertGetId([
            'numero'     => $request->numero,
            'cloture'    => false,
            'id_annee'   => $request->id_annee,
            'id_filiere' => $request->id_filiere,
        ]);

        DB::table('LOG_ACTION')->insert([
            'action'            => 'CREATE',
            'table_concernee'   => 'SEMESTRE',
            'id_enregistrement' => $id,
            'date_action'       => now(),
            'id_user'           => auth()->id(),
        ]);

        return redirect()->route('admin.semestres')->with('success', 'Semestre créé avec succès.');
    }

    public function edit($id)
    {
        $semestre = DB::table('SEMESTRE as s')
            ->join('ANNEE_ACADEMIQUE as a', 'a.id_annee', '=', 's.id_annee')
            ->join('FILIERE as f', 'f.id_filiere', '=', 's.id_filiere')
            ->select('s.*', 'a.libelle as annee_libelle', 'f.nom_filiere')
            ->where('s.id_semestre', $id)
            ->first();

        abort_if(!$semestre, 404);

        $annees   = DB::table('ANNEE_ACADEMIQUE')->select('id_annee', 'libelle')->orderBy('libelle')->get();
        $filieres = DB::table('FILIERE')->select('id_filiere', 'nom_filiere')->orderBy('nom_filiere')->get();

        return view('admin.semestres.edit', compact('semestre', 'annees', 'filieres'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero'     => 'required|integer|min:1|max:6',
            'id_annee'   => 'required|exists:ANNEE_ACADEMIQUE,id_annee',
            'id_filiere' => 'required|exists:FILIERE,id_filiere',
        ]);

        // Prevent duplicate, excluding current
        $exists = DB::table('SEMESTRE')
            ->where('id_annee', $request->id_annee)
            ->where('id_filiere', $request->id_filiere)
            ->where('numero', $request->numero)
            ->where('id_semestre', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['numero' => 'Ce semestre existe déjà pour cette filière et cette année académique.'])->withInput();
        }

        DB::table('SEMESTRE')->where('id_semestre', $id)->update([
            'numero'     => $request->numero,
            'cloture'    => $request->has('cloture'),
            'id_annee'   => $request->id_annee,
            'id_filiere' => $request->id_filiere,
        ]);

        DB::table('LOG_ACTION')->insert([
            'action'            => 'UPDATE',
            'table_concernee'   => 'SEMESTRE',
            'id_enregistrement' => $id,
            'date_action'       => now(),
            'id_user'           => auth()->id(),
        ]);

        return redirect()->route('admin.semestres')->with('success', 'Semestre mis à jour.');
    }

    public function destroy($id)
    {
        DB::table('SEMESTRE')->where('id_semestre', $id)->delete();

        DB::table('LOG_ACTION')->insert([
            'action'            => 'DELETE',
            'table_concernee'   => 'SEMESTRE',
            'id_enregistrement' => $id,
            'date_action'       => now(),
            'id_user'           => auth()->id(),
        ]);

        return redirect()->route('admin.semestres')->with('success', 'Semestre supprimé.');
    }
}