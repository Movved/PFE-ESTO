<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Counts ──────────────────────────────────────────────────────
        $totalEtudiants    = DB::table('ETUDIANT')->count();
        $etudiantsActifs   = DB::table('ETUDIANT')
                                ->join('Utilisateur', 'Utilisateur.id_user', '=', 'ETUDIANT.id_user')
                                ->where('Utilisateur.actif', true)
                                ->count();

        $totalEnseignants  = DB::table('ENSEIGNANT')->count();
        $totalDepartements = DB::table('DEPARTEMENT')->count();
        $totalModules      = DB::table('MODULE')->count();
        $totalFilieres     = DB::table('FILIERE')->count();

        $totalReclamations   = DB::table('RECLAMATION')->count();
        $pendingReclamations = DB::table('RECLAMATION')->whereNull('date_reclamation')->count();

        // ── Recent users (last 6 created) ───────────────────────────────
        $recentUsers = DB::table('Utilisateur')
                         ->orderByDesc('date_creation')
                         ->limit(6)
                         ->get();

        // ── Pending reclamations with student + module info ──────────────
        $reclamationsEnAttente = DB::table('RECLAMATION')
            ->join('NOTE',        'NOTE.id_note',         '=', 'RECLAMATION.id_note')
            ->join('ETUDIANT',    'ETUDIANT.id_etudiant', '=', 'NOTE.id_etudiant')
            ->join('Utilisateur', 'Utilisateur.id_user',  '=', 'ETUDIANT.id_user')
            ->join('MODULE',     'MODULE.id_module',    '=', 'NOTE.id_module')
            ->select(
                'RECLAMATION.id_reclamation',
                'RECLAMATION.message',
                'RECLAMATION.date_reclamation',
                'Utilisateur.nom',
                'Utilisateur.prenom',
                'MODULE.nom_module'
            )
            ->orderByDesc('RECLAMATION.date_reclamation')
            ->limit(5)
            ->get();

        // ── Filière student counts ───────────────────────────────────────
        $filiereStats = DB::table('FILIERE')
            ->leftJoin('ANNEE_ACADEMIQUE', 'ANNEE_ACADEMIQUE.id_filiere', '=', 'FILIERE.id_filiere')
            ->leftJoin('SEMESTRE',         'SEMESTRE.id_annee',           '=', 'ANNEE_ACADEMIQUE.id_annee')
            ->leftJoin('inscrire',         'inscrire.id_semestre',        '=', 'SEMESTRE.id_semestre')
            ->leftJoin('ETUDIANT',         'ETUDIANT.id_etudiant',        '=', 'inscrire.id_etudiant')
            ->select('FILIERE.nom_filiere', DB::raw('COUNT(DISTINCT ETUDIANT.id_etudiant) as nb_etudiants'))
            ->groupBy('FILIERE.id_filiere', 'FILIERE.nom_filiere')
            ->orderByDesc('nb_etudiants')
            ->get();

        // ── Recent logs (last 10) ────────────────────────────────────────
        $recentLogs = DB::table('LOG_ACTION')
            ->leftJoin('Utilisateur', 'Utilisateur.id_user', '=', 'LOG_ACTION.id_user')
            ->select(
                'LOG_ACTION.*',
                'Utilisateur.nom',
                'Utilisateur.prenom'
            )
            ->orderByDesc('LOG_ACTION.date_action')
            ->limit(10)
            ->get()
            ->map(function ($log) {
                $log->user = $log->nom ? (object)[
                    'prenom' => $log->prenom,
                    'nom'    => $log->nom,
                ] : null;
                return $log;
            });

        return view('admin.dashboard', compact(
            'totalEtudiants',
            'etudiantsActifs',
            'totalEnseignants',
            'totalDepartements',
            'totalModules',
            'totalFilieres',
            'totalReclamations',
            'pendingReclamations',
            'recentUsers',
            'reclamationsEnAttente',
            'filiereStats',
            'recentLogs'
        ));
    }
}