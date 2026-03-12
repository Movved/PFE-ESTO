<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChefController extends Controller
{
    /**
     * Get the chef's enseignant record and verify is_chef = 1
     */
    private function getChef()
    {
        $chef = DB::table('ENSEIGNANT')
            ->where('id_user', Auth::user()->id_user)
            ->where('is_chef', 1)
            ->first();

        if (!$chef) abort(403, 'Accès réservé au chef de département.');

        return $chef;
    }

    /**
     * Dashboard
     */
    public function dashboard()
    {
        $chef = $this->getChef();

        $departement = DB::table('DEPARTEMENT')
            ->where('id_departement', $chef->id_departement)
            ->first();

        // Total filieres
        $totalFilieres = DB::table('FILIERE')
            ->where('id_departement', $chef->id_departement)
            ->count();

        // Total modules
        $totalModules = DB::table('MODULE')
            ->join('SEMESTRE', 'MODULE.id_semestre', '=', 'SEMESTRE.id_semestre')
            ->join('ANNEE_ACADEMIQUE', 'SEMESTRE.id_annee', '=', 'ANNEE_ACADEMIQUE.id_annee')
            ->join('FILIERE', 'ANNEE_ACADEMIQUE.id_filiere', '=', 'FILIERE.id_filiere')
            ->where('FILIERE.id_departement', $chef->id_departement)
            ->count();

        // Total enseignants
        $totalEnseignants = DB::table('ENSEIGNANT')
            ->where('id_departement', $chef->id_departement)
            ->count();

        // Total etudiants
        $totalEtudiants = DB::table('inscrire')
            ->join('SEMESTRE', 'inscrire.id_semestre', '=', 'SEMESTRE.id_semestre')
            ->join('ANNEE_ACADEMIQUE', 'SEMESTRE.id_annee', '=', 'ANNEE_ACADEMIQUE.id_annee')
            ->join('FILIERE', 'ANNEE_ACADEMIQUE.id_filiere', '=', 'FILIERE.id_filiere')
            ->where('FILIERE.id_departement', $chef->id_departement)
            ->distinct('inscrire.id_etudiant')
            ->count('inscrire.id_etudiant');

        // Recent modules
        $recentModules = DB::table('MODULE')
            ->join('SEMESTRE', 'MODULE.id_semestre', '=', 'SEMESTRE.id_semestre')
            ->join('ANNEE_ACADEMIQUE', 'SEMESTRE.id_annee', '=', 'ANNEE_ACADEMIQUE.id_annee')
            ->join('FILIERE', 'ANNEE_ACADEMIQUE.id_filiere', '=', 'FILIERE.id_filiere')
            ->join('ENSEIGNANT', 'MODULE.id_enseignant', '=', 'ENSEIGNANT.id_enseignant')
            ->join('Utilisateur', 'ENSEIGNANT.id_user', '=', 'Utilisateur.id_user')
            ->where('FILIERE.id_departement', $chef->id_departement)
            ->select(
                'MODULE.id_module',
                'MODULE.code_module',
                'MODULE.nom_module',
                'FILIERE.nom_filiere',
                'SEMESTRE.numero as semestre_numero',
                'SEMESTRE.cloture',
                'Utilisateur.nom as prof_nom',
                'Utilisateur.prenom as prof_prenom'
            )
            ->take(5)
            ->get();

        // Filieres list
        $filieres = DB::table('FILIERE')
            ->where('id_departement', $chef->id_departement)
            ->get();

        return view('chef.dashboard', compact(
            'chef', 'departement', 'totalFilieres', 'totalModules',
            'totalEnseignants', 'totalEtudiants', 'recentModules', 'filieres'
        ));
    }

    /**
     * List all modules of the department
     */
    public function modules()
    {
        $chef = $this->getChef();

        $modules = DB::table('MODULE')
            ->join('SEMESTRE', 'MODULE.id_semestre', '=', 'SEMESTRE.id_semestre')
            ->join('ANNEE_ACADEMIQUE', 'SEMESTRE.id_annee', '=', 'ANNEE_ACADEMIQUE.id_annee')
            ->join('FILIERE', 'ANNEE_ACADEMIQUE.id_filiere', '=', 'FILIERE.id_filiere')
            ->join('ENSEIGNANT', 'MODULE.id_enseignant', '=', 'ENSEIGNANT.id_enseignant')
            ->join('Utilisateur', 'ENSEIGNANT.id_user', '=', 'Utilisateur.id_user')
            ->where('FILIERE.id_departement', $chef->id_departement)
            ->select(
                'MODULE.id_module',
                'MODULE.code_module',
                'MODULE.nom_module',
                'MODULE.id_semestre',
                'MODULE.id_enseignant',
                'FILIERE.nom_filiere',
                DB::raw('ANNEE_ACADEMIQUE.libelle as annee'),
                DB::raw('SEMESTRE.numero as semestre_numero'),
                'SEMESTRE.cloture',
                'Utilisateur.nom as prof_nom',
                'Utilisateur.prenom as prof_prenom'
            )
            ->orderBy('FILIERE.nom_filiere')
            ->orderBy('SEMESTRE.numero')
            ->get();

        // For add/edit form: semestres and enseignants of this department
        $semestres = DB::table('SEMESTRE')
        ->join('ANNEE_ACADEMIQUE', 'SEMESTRE.id_annee', '=', 'ANNEE_ACADEMIQUE.id_annee')
        ->join('FILIERE', 'ANNEE_ACADEMIQUE.id_filiere', '=', 'FILIERE.id_filiere')
        ->where('FILIERE.id_departement', $chef->id_departement)
        ->select(
            'SEMESTRE.id_semestre',
            DB::raw('SEMESTRE.numero as semestre_numero'),
            DB::raw('ANNEE_ACADEMIQUE.libelle as libelle'),
            DB::raw('FILIERE.nom_filiere as nom_filiere')
        )
        ->get();

        $enseignants = DB::table('ENSEIGNANT')
            ->join('Utilisateur', 'ENSEIGNANT.id_user', '=', 'Utilisateur.id_user')
            ->where('ENSEIGNANT.id_departement', $chef->id_departement)
            ->select('ENSEIGNANT.id_enseignant', 'Utilisateur.nom', 'Utilisateur.prenom')
            ->get();

        return view('chef.modules', compact('modules', 'semestres', 'enseignants', 'chef'));
    }

    /**
     * Store a new module
     */
    public function storeModule(Request $request)
    {
        $request->validate([
            'code_module' => ['required', 'string', 'max:20'],
            'nom_module'  => ['required', 'string', 'max:50'],
            'id_semestre' => ['required', 'integer'],
            'id_enseignant' => ['required', 'integer'],
        ]);

        DB::table('MODULE')->insert([
            'code_module'   => $request->code_module,
            'nom_module'    => $request->nom_module,
            'id_semestre'   => $request->id_semestre,
            'id_enseignant' => $request->id_enseignant,
        ]);

        return back()->with('success', 'Module ajouté avec succès.');
    }

    /**
     * Update a module
     */
    public function updateModule(Request $request, $id)
    {
        $chef = $this->getChef();

        $request->validate([
            'code_module'   => ['required', 'string', 'max:20'],
            'nom_module'    => ['required', 'string', 'max:50'],
            'id_semestre'   => ['required', 'integer'],
            'id_enseignant' => ['required', 'integer'],
        ]);

        // Verify module belongs to chef's department
        $module = DB::table('MODULE')
            ->join('SEMESTRE', 'MODULE.id_semestre', '=', 'SEMESTRE.id_semestre')
            ->join('ANNEE_ACADEMIQUE', 'SEMESTRE.id_annee', '=', 'ANNEE_ACADEMIQUE.id_annee')
            ->join('FILIERE', 'ANNEE_ACADEMIQUE.id_filiere', '=', 'FILIERE.id_filiere')
            ->where('MODULE.id_module', $id)
            ->where('FILIERE.id_departement', $chef->id_departement)
            ->first();

        if (!$module) abort(403);

        DB::table('MODULE')->where('id_module', $id)->update([
            'code_module'   => $request->code_module,
            'nom_module'    => $request->nom_module,
            'id_semestre'   => $request->id_semestre,
            'id_enseignant' => $request->id_enseignant,
        ]);

        return back()->with('success', 'Module modifié avec succès.');
    }

    /**
     * Delete a module
     */
    public function deleteModule($id)
    {
        $chef = $this->getChef();

        $module = DB::table('MODULE')
            ->join('SEMESTRE', 'MODULE.id_semestre', '=', 'SEMESTRE.id_semestre')
            ->join('ANNEE_ACADEMIQUE', 'SEMESTRE.id_annee', '=', 'ANNEE_ACADEMIQUE.id_annee')
            ->join('FILIERE', 'ANNEE_ACADEMIQUE.id_filiere', '=', 'FILIERE.id_filiere')
            ->where('MODULE.id_module', $id)
            ->where('FILIERE.id_departement', $chef->id_departement)
            ->first();

        if (!$module) abort(403);

        // Delete related records first
        $notes = DB::table('NOTE')->where('id_module', $id)->pluck('id_note');
        DB::table('RECLAMATION')->whereIn('id_note', $notes)->delete();
        DB::table('NOTE')->where('id_module', $id)->delete();
        DB::table('intervenir')->where('id_module', $id)->delete();
        DB::table('MODULE')->where('id_module', $id)->delete();

        return back()->with('success', 'Module supprimé avec succès.');
    }

    /**
     * List all filieres of the department
     */
    public function filieres()
    {
        $chef = $this->getChef();

        $filieres = DB::table('FILIERE')
            ->where('id_departement', $chef->id_departement)
            ->get();

        $departement = DB::table('DEPARTEMENT')
            ->where('id_departement', $chef->id_departement)
            ->first();

        return view('chef.filieres', compact('filieres', 'departement', 'chef'));
    }

    /**
     * Store a new filiere
     */
    public function storeFiliere(Request $request)
    {
        $chef = $this->getChef();

        $request->validate([
            'nom_filiere' => ['required', 'string', 'max:50', 'unique:FILIERE,nom_filiere'],
            'description' => ['required', 'string'],
        ]);

        DB::table('FILIERE')->insert([
            'nom_filiere'    => $request->nom_filiere,
            'description'    => $request->description,
            'id_departement' => $chef->id_departement,
        ]);

        return back()->with('success', 'Filière ajoutée avec succès.');
    }

    /**
     * Update a filiere
     */
    public function updateFiliere(Request $request, $id)
    {
        $chef = $this->getChef();

        $request->validate([
            'nom_filiere' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
        ]);

        DB::table('FILIERE')
            ->where('id_filiere', $id)
            ->where('id_departement', $chef->id_departement)
            ->update([
                'nom_filiere' => $request->nom_filiere,
                'description' => $request->description,
            ]);

        return back()->with('success', 'Filière modifiée avec succès.');
    }

    /**
     * Delete a filiere
     */
    public function deleteFiliere($id)
    {
        $chef = $this->getChef();

        $filiere = DB::table('FILIERE')
            ->where('id_filiere', $id)
            ->where('id_departement', $chef->id_departement)
            ->first();

        if (!$filiere) abort(403);

        DB::table('FILIERE')->where('id_filiere', $id)->delete();

        return back()->with('success', 'Filière supprimée avec succès.');
    }

    /**
     * List all students of the department
     */
    public function etudiants()
    {
        $chef = $this->getChef();

        $etudiants = DB::table('ETUDIANT')
            ->join('Utilisateur', 'ETUDIANT.id_user', '=', 'Utilisateur.id_user')
            ->join('inscrire', 'ETUDIANT.id_etudiant', '=', 'inscrire.id_etudiant')
            ->join('SEMESTRE', 'inscrire.id_semestre', '=', 'SEMESTRE.id_semestre')
            ->join('ANNEE_ACADEMIQUE', 'SEMESTRE.id_annee', '=', 'ANNEE_ACADEMIQUE.id_annee')
            ->join('FILIERE', 'ANNEE_ACADEMIQUE.id_filiere', '=', 'FILIERE.id_filiere')
            ->where('FILIERE.id_departement', $chef->id_departement)
            ->select(
                'ETUDIANT.id_etudiant',
                'ETUDIANT.cne',
                'Utilisateur.nom',
                'Utilisateur.prenom',
                'Utilisateur.email',
                'FILIERE.nom_filiere',
                'ANNEE_ACADEMIQUE.libelle as annee',
                DB::raw('COUNT(DISTINCT inscrire.id_semestre) as nb_semestres')
            )
            ->groupBy(
                'ETUDIANT.id_etudiant', 'ETUDIANT.cne',
                'Utilisateur.nom', 'Utilisateur.prenom', 'Utilisateur.email',
                'FILIERE.nom_filiere', 'ANNEE_ACADEMIQUE.libelle'
            )
            ->get();

        return view('chef.etudiants', compact('etudiants', 'chef'));
    }

    /**
     * View notes of a specific student
     */
    public function etudiantNotes($id)
    {
        $chef = $this->getChef();

        $etudiant = DB::table('ETUDIANT')
            ->join('Utilisateur', 'ETUDIANT.id_user', '=', 'Utilisateur.id_user')
            ->where('ETUDIANT.id_etudiant', $id)
            ->select('ETUDIANT.*', 'Utilisateur.nom', 'Utilisateur.prenom', 'Utilisateur.email')
            ->first();

        if (!$etudiant) abort(404);

        $notes = DB::table('NOTE')
            ->join('MODULE', 'NOTE.id_module', '=', 'MODULE.id_module')
            ->join('SEMESTRE', 'MODULE.id_semestre', '=', 'SEMESTRE.id_semestre')
            ->join('ANNEE_ACADEMIQUE', 'SEMESTRE.id_annee', '=', 'ANNEE_ACADEMIQUE.id_annee')
            ->join('FILIERE', 'ANNEE_ACADEMIQUE.id_filiere', '=', 'FILIERE.id_filiere')
            ->where('NOTE.id_etudiant', $id)
            ->where('FILIERE.id_departement', $chef->id_departement)
            ->select(
                'NOTE.id_note',
                'NOTE.note',
                'NOTE.rattrapage',
                'MODULE.code_module',
                'MODULE.nom_module',
                'SEMESTRE.numero as semestre_numero',
                'FILIERE.nom_filiere'
            )
            ->get();

        return view('chef.etudiant-notes', compact('etudiant', 'notes', 'chef'));
    }
}