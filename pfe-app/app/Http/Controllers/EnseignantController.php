<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EnseignantController extends Controller
{
    /**
     * Resolve the enseignant record for the logged-in user.
     */
    private function getEnseignant()
    {
        return DB::table('enseignant')
            ->where('id_user', Auth::id())
            ->first();
    }

    /**
     * Dashboard — stats + recent reclamations + modules overview.
     */
    public function dashboard()
    {
        $enseignant = $this->getEnseignant();

        if (!$enseignant) {
            abort(403, 'Accès refusé.');
        }

        $id = $enseignant->id_enseignant;

        // Modules taught by this teacher
        $modules = DB::table('module')
            ->where('id_enseignant', $id)
            ->join('semestre', 'module.id_semestre', '=', 'semestre.id_semestre')
            ->select(
                'module.id_module',
                'module.nom_module',
                'module.code_module',
                'semestre.numero as semestre_numero',
                DB::raw('(SELECT COUNT(*) FROM note WHERE note.id_module = module.id_module) as nb_etudiants')
            )
            ->get();

        // Scalar stats
        $totalModules   = $modules->count();
        $totalEtudiants = DB::table('note')
            ->whereIn('id_module', $modules->pluck('id_module'))
            ->distinct('id_etudiant')
            ->count('id_etudiant');

        // Grade repartition across all modules
        $notes = DB::table('note')
            ->whereIn('id_module', $modules->pluck('id_module'))
            ->whereNotNull('note')
            ->pluck('note');

        $repartition = [
            'pass'  => $notes->filter(fn($n) => $n >= 12)->count(),
            'warn'  => $notes->filter(fn($n) => $n >= 10 && $n < 12)->count(),
            'fail'  => $notes->filter(fn($n) => $n < 10)->count(),
            'total' => $notes->count(),
        ];

        $moyenneGlobale = $notes->count() ? round($notes->avg(), 2) : null;

        // Reclamations for this teacher's modules (most recent first, limit 10)
        $reclamations = DB::table('reclamation')
            ->join('note',      'reclamation.id_note',      '=', 'note.id_note')
            ->join('module',    'note.id_module',            '=', 'module.id_module')
            ->join('etudiant',  'note.id_etudiant',          '=', 'etudiant.id_etudiant')
            ->join('utilisateur', 'etudiant.id_user',        '=', 'utilisateur.id_user')
            ->whereIn('module.id_module', $modules->pluck('id_module'))
            ->select(
                'reclamation.id_reclamation',
                'reclamation.message',
                'reclamation.date_reclamation',
                'note.note',
                'module.nom_module',
                'module.code_module',
                'utilisateur.prenom as prenom_etudiant',
                'utilisateur.nom    as nom_etudiant',
                'etudiant.cne       as cne_etudiant'
            )
            ->orderByDesc('reclamation.date_reclamation')
            ->limit(10)
            ->get();

        if (Schema::hasColumn('reclamation', 'traite')) {
            $recIds = $reclamations->pluck('id_reclamation');
            $traiteMap = DB::table('reclamation')->whereIn('id_reclamation', $recIds)->pluck('traite', 'id_reclamation');
            $reclamations->each(fn ($r) => $r->traite = $traiteMap->get($r->id_reclamation, false));
        } else {
            $reclamations->each(fn ($r) => $r->traite = false);
        }

        $pendingCount = $this->getPendingReclamationsCount($id);

        return view('enseignant.dashboard', compact(
            'modules',
            'totalModules',
            'totalEtudiants',
            'repartition',
            'moyenneGlobale',
            'reclamations',
            'pendingCount'
        ));
    }

    /**
     * Modules list page — all modules taught by the teacher.
     */
    public function modules()
    {
        $enseignant = $this->getEnseignant();
        if (!$enseignant) {
            abort(403, 'Accès refusé.');
        }

        $modules = DB::table('module')
            ->where('id_enseignant', $enseignant->id_enseignant)
            ->join('semestre', 'module.id_semestre', '=', 'semestre.id_semestre')
            ->join('annee_academique', 'semestre.id_annee', '=', 'annee_academique.id_annee')
            ->join('filiere', 'annee_academique.id_filiere', '=', 'filiere.id_filiere')
            ->select(
                'module.id_module',
                'module.nom_module',
                'module.code_module',
                'semestre.numero as semestre_numero',
                'annee_academique.libelle as annee_libelle',
                'filiere.nom_filiere',
                DB::raw('(SELECT COUNT(*) FROM note WHERE note.id_module = module.id_module) as nb_etudiants')
            )
            ->orderBy('filiere.nom_filiere')
            ->orderBy('annee_academique.libelle')
            ->orderBy('semestre.numero')
            ->get();

        $pendingCount = $this->getPendingReclamationsCount($enseignant->id_enseignant);

        return view('enseignant.modules', compact('modules', 'pendingCount'));
    }

    /**
     * Single module detail — info, stats, students with notes.
     */
    public function showModule($id)
    {
        $enseignant = $this->getEnseignant();
        if (!$enseignant) {
            abort(403, 'Accès refusé.');
        }

        $module = DB::table('module')
            ->where('module.id_module', $id)
            ->where('module.id_enseignant', $enseignant->id_enseignant)
            ->join('semestre', 'module.id_semestre', '=', 'semestre.id_semestre')
            ->join('annee_academique', 'semestre.id_annee', '=', 'annee_academique.id_annee')
            ->join('filiere', 'annee_academique.id_filiere', '=', 'filiere.id_filiere')
            ->select(
                'module.id_module',
                'module.nom_module',
                'module.code_module',
                'semestre.numero as semestre_numero',
                'semestre.cloture as semestre_cloture',
                'annee_academique.libelle as annee_libelle',
                'filiere.nom_filiere',
                'filiere.description as filiere_description'
            )
            ->first();

        if (!$module) {
            abort(404, 'Module introuvable.');
        }

        // Students with notes for this module
        $etudiants = DB::table('note')
            ->where('note.id_module', $id)
            ->join('etudiant', 'note.id_etudiant', '=', 'etudiant.id_etudiant')
            ->join('utilisateur', 'etudiant.id_user', '=', 'utilisateur.id_user')
            ->select(
                'etudiant.id_etudiant',
                'etudiant.cne',
                'utilisateur.prenom',
                'utilisateur.nom',
                'note.id_note',
                'note.note',
                'note.rattrapage'
            )
            ->orderBy('utilisateur.nom')
            ->orderBy('utilisateur.prenom')
            ->get();

        $notes = $etudiants->pluck('note')->filter(fn($n) => $n !== null);
        $repartition = [
            'pass'  => $notes->filter(fn($n) => $n >= 12)->count(),
            'warn'  => $notes->filter(fn($n) => $n >= 10 && $n < 12)->count(),
            'fail'  => $notes->filter(fn($n) => $n < 10)->count(),
            'total' => $notes->count(),
        ];
        $moyenne = $notes->count() ? round($notes->avg(), 2) : null;

        // Reclamations count for this module
        $reclamationsCount = DB::table('reclamation')
            ->join('note', 'reclamation.id_note', '=', 'note.id_note')
            ->where('note.id_module', $id)
            ->count();

        $pendingCount = $this->getPendingReclamationsCount($enseignant->id_enseignant);

        return view('enseignant.module-show', compact(
            'module', 'etudiants', 'repartition', 'moyenne', 'reclamationsCount', 'pendingCount'
        ));
    }

    /**
     * Count pending reclamations for teacher's modules.
     */
    private function getPendingReclamationsCount($id_enseignant)
    {
        $moduleIds = DB::table('module')->where('id_enseignant', $id_enseignant)->pluck('id_module');
        if ($moduleIds->isEmpty()) {
            return 0;
        }
        $q = DB::table('reclamation')
            ->join('note', 'reclamation.id_note', '=', 'note.id_note')
            ->whereIn('note.id_module', $moduleIds);
        if (Schema::hasColumn('reclamation', 'traite')) {
            $q->where('reclamation.traite', false);
        }
        return $q->count();
    }

    /**
     * Notes: list modules to choose for saisie.
     */
    public function notes()
    {
        $enseignant = $this->getEnseignant();
        if (!$enseignant) abort(403, 'Accès refusé.');

        $modules = DB::table('module')
            ->where('id_enseignant', $enseignant->id_enseignant)
            ->join('semestre', 'module.id_semestre', '=', 'semestre.id_semestre')
            ->join('annee_academique', 'semestre.id_annee', '=', 'annee_academique.id_annee')
            ->join('filiere', 'annee_academique.id_filiere', '=', 'filiere.id_filiere')
            ->select(
                'module.id_module',
                'module.nom_module',
                'module.code_module',
                'semestre.numero as semestre_numero',
                'annee_academique.libelle as annee_libelle',
                'filiere.nom_filiere',
                DB::raw('(SELECT COUNT(*) FROM note WHERE note.id_module = module.id_module) as nb_etudiants')
            )
            ->orderBy('filiere.nom_filiere')
            ->orderBy('semestre.numero')
            ->get();

        $pendingCount = $this->getPendingReclamationsCount($enseignant->id_enseignant);
        return view('enseignant.notes', compact('modules', 'pendingCount'));
    }

    /**
     * Saisie des notes: form for one module.
     */
    public function notesForm($id)
    {
        $enseignant = $this->getEnseignant();
        if (!$enseignant) abort(403, 'Accès refusé.');

        $module = DB::table('module')
            ->where('module.id_module', $id)
            ->where('module.id_enseignant', $enseignant->id_enseignant)
            ->join('semestre', 'module.id_semestre', '=', 'semestre.id_semestre')
            ->join('annee_academique', 'semestre.id_annee', '=', 'annee_academique.id_annee')
            ->join('filiere', 'annee_academique.id_filiere', '=', 'filiere.id_filiere')
            ->select(
                'module.id_module',
                'module.nom_module',
                'module.code_module',
                'semestre.numero as semestre_numero',
                'annee_academique.libelle as annee_libelle',
                'filiere.nom_filiere'
            )
            ->first();

        if (!$module) abort(404, 'Module introuvable.');

        $etudiants = DB::table('note')
            ->where('note.id_module', $id)
            ->join('etudiant', 'note.id_etudiant', '=', 'etudiant.id_etudiant')
            ->join('utilisateur', 'etudiant.id_user', '=', 'utilisateur.id_user')
            ->select(
                'etudiant.id_etudiant',
                'etudiant.cne',
                'utilisateur.prenom',
                'utilisateur.nom',
                'note.id_note',
                'note.note',
                'note.rattrapage'
            )
            ->orderBy('utilisateur.nom')
            ->orderBy('utilisateur.prenom')
            ->get();

        $pendingCount = $this->getPendingReclamationsCount($enseignant->id_enseignant);
        return view('enseignant.notes-form', compact('module', 'etudiants', 'pendingCount'));
    }

    /**
     * Save notes for a module.
     */
    public function storeNotes(Request $request, $id)
    {
        $enseignant = $this->getEnseignant();
        if (!$enseignant) abort(403, 'Accès refusé.');

        $ok = DB::table('module')
            ->where('id_module', $id)
            ->where('id_enseignant', $enseignant->id_enseignant)
            ->exists();
        if (!$ok) abort(404, 'Module introuvable.');

        foreach ($request->input('notes', []) as $id_note => $data) {
            $note       = isset($data['note'])       && $data['note']       !== '' ? (float) $data['note']       : null;
            $rattrapage = isset($data['rattrapage']) && $data['rattrapage'] !== '' ? (float) $data['rattrapage'] : null;
            DB::table('note')
                ->where('id_note', $id_note)
                ->where('id_module', $id)
                ->update(['note' => $note, 'rattrapage' => $rattrapage]);
        }

        return redirect()->route('enseignant.notes.form', $id)->with('success', 'Notes enregistrées.');
    }

    /**
     * PV (procès-verbal) — printable page; use browser Print → Save as PDF.
     */
    public function pv($id)
    {
        $enseignant = $this->getEnseignant();
        if (!$enseignant) abort(403, 'Accès refusé.');

        $module = DB::table('module')
            ->where('module.id_module', $id)
            ->where('module.id_enseignant', $enseignant->id_enseignant)
            ->join('semestre', 'module.id_semestre', '=', 'semestre.id_semestre')
            ->join('annee_academique', 'semestre.id_annee', '=', 'annee_academique.id_annee')
            ->join('filiere', 'annee_academique.id_filiere', '=', 'filiere.id_filiere')
            ->select(
                'module.id_module',
                'module.nom_module',
                'module.code_module',
                'semestre.numero as semestre_numero',
                'annee_academique.libelle as annee_libelle',
                'filiere.nom_filiere'
            )
            ->first();

        if (!$module) abort(404, 'Module introuvable.');

        $etudiants = DB::table('note')
            ->where('note.id_module', $id)
            ->join('etudiant', 'note.id_etudiant', '=', 'etudiant.id_etudiant')
            ->join('utilisateur', 'etudiant.id_user', '=', 'utilisateur.id_user')
            ->select('etudiant.cne', 'utilisateur.prenom', 'utilisateur.nom', 'note.note', 'note.rattrapage')
            ->orderBy('utilisateur.nom')
            ->orderBy('utilisateur.prenom')
            ->get();

        return view('enseignant.pv', compact('module', 'etudiants'));
    }

    /**
     * Full reclamations list page.
     */
    public function reclamations()
    {
        $enseignant = $this->getEnseignant();
        if (!$enseignant) abort(403, 'Accès refusé.');

        $moduleIds    = DB::table('module')->where('id_enseignant', $enseignant->id_enseignant)->pluck('id_module');
        $reclamations = collect();

        if ($moduleIds->isNotEmpty()) {
            $reclamations = DB::table('reclamation')
                ->join('note',        'reclamation.id_note',   '=', 'note.id_note')
                ->join('module',      'note.id_module',         '=', 'module.id_module')
                ->join('etudiant',    'note.id_etudiant',       '=', 'etudiant.id_etudiant')
                ->join('utilisateur', 'etudiant.id_user',       '=', 'utilisateur.id_user')
                ->whereIn('module.id_module', $moduleIds)
                ->select(
                    'reclamation.*',
                    'note.note',
                    'module.nom_module',
                    'module.code_module',
                    'utilisateur.prenom as prenom_etudiant',
                    'utilisateur.nom as nom_etudiant',
                    'etudiant.cne as cne_etudiant'
                )
                ->orderByDesc('reclamation.date_reclamation')
                ->get();
        }

        // Apply defaults for optional columns regardless of whether there are results
        if (!Schema::hasColumn('reclamation', 'traite')) {
            $reclamations->each(fn ($r) => $r->traite = false);
        }
        if (!Schema::hasColumn('reclamation', 'reponse')) {
            $reclamations->each(fn ($r) => $r->reponse = null);
        }

        $pendingCount = $this->getPendingReclamationsCount($enseignant->id_enseignant);
        return view('enseignant.reclamations', compact('reclamations', 'pendingCount'));
    }

    /**
     * Mark a reclamation as treated.
     */
    public function traiterReclamation(Request $request, $id)
    {
        $enseignant = $this->getEnseignant();
        if (!$enseignant) abort(403, 'Accès refusé.');

        $moduleIds = DB::table('module')->where('id_enseignant', $enseignant->id_enseignant)->pluck('id_module');
        $noteIds   = DB::table('note')->whereIn('id_module', $moduleIds)->pluck('id_note');

        $rec = DB::table('reclamation')
            ->where('id_reclamation', $id)
            ->whereIn('id_note', $noteIds)
            ->first();
        if (!$rec) abort(404, 'Réclamation introuvable.');

        $data = [];
        if (Schema::hasColumn('reclamation', 'traite')) {
            $data['traite'] = true;
        }
        if (Schema::hasColumn('reclamation', 'reponse')) {
            $data['reponse'] = $request->input('reponse');
        }
        if (!empty($data)) {
            DB::table('reclamation')->where('id_reclamation', $id)->update($data);
        }

        return back()->with('success', 'Réclamation marquée comme traitée.');
    }
}