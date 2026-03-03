<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── CLEAN SLATE ──────────────────────────────────────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('log_action')->truncate();
        DB::table('reclamation')->truncate();
        DB::table('note')->truncate();
        DB::table('evaluation')->truncate();
        DB::table('inscription')->truncate();
        DB::table('etudiant')->truncate();
        DB::table('enseignement')->truncate();
        DB::table('module')->truncate();
        DB::table('semestre')->truncate();
        DB::table('annee_academique')->truncate();
        DB::table('filiere')->truncate();
        DB::table('enseignant')->truncate();
        DB::table('utilisateur')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ─── 1. UTILISATEURS ──────────────────────────────────────────────
        DB::table('utilisateur')->insert([
            // Admin
            ['nom' => 'Alaoui',    'prenom' => 'Karim',   'username' => 'admin',        'mot_de_passe' => Hash::make('password'), 'role' => 'ADMIN',      'actif' => true,  'date_creation' => now()],
            // Enseignants
            ['nom' => 'Benali',    'prenom' => 'Youssef', 'username' => 'ybenali',      'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true,  'date_creation' => now()],
            ['nom' => 'Cherkaoui', 'prenom' => 'Fatima',  'username' => 'fcherkaoui',   'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true,  'date_creation' => now()],
            ['nom' => 'Idrissi',   'prenom' => 'Omar',    'username' => 'oidrissi',     'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true,  'date_creation' => now()],
            // Etudiants
            ['nom' => 'Moussaoui', 'prenom' => 'Amine',   'username' => 'amoussaoui',   'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Tazi',      'prenom' => 'Sara',    'username' => 'stazi',        'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Hajji',     'prenom' => 'Mehdi',   'username' => 'mhajji',       'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Lamrani',   'prenom' => 'Nadia',   'username' => 'nlamrani',     'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => false, 'date_creation' => now()],
        ]);

        // ─── 2. ENSEIGNANTS ───────────────────────────────────────────────
        // id_user: 2 = Benali (chef), 3 = Cherkaoui, 4 = Idrissi
        DB::table('enseignant')->insert([
            ['id_user' => 2, 'specialite' => 'Informatique',         'departement' => 'Génie Informatique', 'is_chef' => true],
            ['id_user' => 3, 'specialite' => 'Mathématiques',        'departement' => 'Sciences de Base',   'is_chef' => false],
            ['id_user' => 4, 'specialite' => 'Réseaux et Systèmes',  'departement' => 'Génie Informatique', 'is_chef' => false],
        ]);

        // ─── 3. FILIERES ──────────────────────────────────────────────────
        DB::table('filiere')->insert([
            ['nom_filiere' => 'Génie Logiciel',         'description' => 'Formation en développement logiciel et architecture.', 'responsable_id' => 2],
            ['nom_filiere' => 'Réseaux et Télécoms',    'description' => 'Formation en réseaux, sécurité et télécommunications.', 'responsable_id' => 4],
        ]);

        // ─── 4. ANNEES ACADEMIQUES ────────────────────────────────────────
        DB::table('annee_academique')->insert([
            ['libelle' => '2023-2024', 'id_filiere' => 1],
            ['libelle' => '2024-2025', 'id_filiere' => 1],
            ['libelle' => '2024-2025', 'id_filiere' => 2],  // same label, different filière
        ]);

        // ─── 5. SEMESTRES ─────────────────────────────────────────────────
        DB::table('semestre')->insert([
            ['numero' => 1, 'cloture' => true,  'id_annee' => 1],  // S1 2023-24 GL (closed)
            ['numero' => 2, 'cloture' => true,  'id_annee' => 1],  // S2 2023-24 GL (closed)
            ['numero' => 1, 'cloture' => false, 'id_annee' => 2],  // S1 2024-25 GL (active)
            ['numero' => 1, 'cloture' => false, 'id_annee' => 3],  // S1 2024-25 RT (active)
        ]);

        // ─── 6. MODULES ───────────────────────────────────────────────────
        DB::table('module')->insert([
            // Semestre 1 - GL 2023-24
            ['code_module' => 'INF101', 'nom_module' => 'Algorithmique',           'id_semestre' => 1],
            ['code_module' => 'MAT101', 'nom_module' => 'Analyse Mathématique',    'id_semestre' => 1],
            // Semestre 2 - GL 2023-24
            ['code_module' => 'INF201', 'nom_module' => 'Programmation Orientée Objet', 'id_semestre' => 2],
            ['code_module' => 'INF202', 'nom_module' => 'Base de Données',         'id_semestre' => 2],
            // Semestre 1 - GL 2024-25
            ['code_module' => 'INF301', 'nom_module' => 'Développement Web',       'id_semestre' => 3],
            // Semestre 1 - RT 2024-25
            ['code_module' => 'RES101', 'nom_module' => 'Réseaux Informatiques',   'id_semestre' => 4],
        ]);

        // ─── 7. ENSEIGNEMENTS ─────────────────────────────────────────────
        DB::table('enseignement')->insert([
            ['id_user' => 2, 'id_module' => 1],  // Benali → Algorithmique
            ['id_user' => 3, 'id_module' => 2],  // Cherkaoui → Analyse Math
            ['id_user' => 2, 'id_module' => 3],  // Benali → POO
            ['id_user' => 2, 'id_module' => 4],  // Benali → Base de Données
            ['id_user' => 2, 'id_module' => 5],  // Benali → Dev Web
            ['id_user' => 4, 'id_module' => 6],  // Idrissi → Réseaux
        ]);

        // ─── 8. ETUDIANTS ─────────────────────────────────────────────────
        // id_user: 5 = Moussaoui, 6 = Tazi, 7 = Hajji, 8 = Lamrani
        DB::table('etudiant')->insert([
            ['id_user' => 5, 'cne' => 'G110023001', 'id_filiere' => 1, 'annee_actuelle' => 2],
            ['id_user' => 6, 'cne' => 'G110023002', 'id_filiere' => 1, 'annee_actuelle' => 2],
            ['id_user' => 7, 'cne' => 'G110023003', 'id_filiere' => 1, 'annee_actuelle' => 1],
            ['id_user' => 8, 'cne' => 'G110023004', 'id_filiere' => 2, 'annee_actuelle' => 1],
        ]);

        // ─── 9. INSCRIPTIONS ──────────────────────────────────────────────
        DB::table('inscription')->insert([
            // Moussaoui & Tazi enrolled in both semesters of GL 2023-24
            ['id_user' => 5, 'id_semestre' => 1, 'date_inscription' => '2023-09-10 08:00:00'],
            ['id_user' => 5, 'id_semestre' => 2, 'date_inscription' => '2024-02-05 08:00:00'],
            ['id_user' => 6, 'id_semestre' => 1, 'date_inscription' => '2023-09-10 08:00:00'],
            ['id_user' => 6, 'id_semestre' => 2, 'date_inscription' => '2024-02-05 08:00:00'],
            // Hajji enrolled in GL 2024-25 S1
            ['id_user' => 7, 'id_semestre' => 3, 'date_inscription' => '2024-09-12 08:00:00'],
            // Lamrani enrolled in RT 2024-25 S1
            ['id_user' => 8, 'id_semestre' => 4, 'date_inscription' => '2024-09-12 08:00:00'],
        ]);

        // ─── 10. EVALUATIONS ──────────────────────────────────────────────
        DB::table('evaluation')->insert([
            // Algorithmique (module 1)
            ['libelle' => 'CC1 Algorithmique',   'type' => 'CC',   'date_evaluation' => '2023-10-15', 'id_module' => 1],
            ['libelle' => 'Examen Algorithmique', 'type' => 'EXAM', 'date_evaluation' => '2024-01-20', 'id_module' => 1],
            // Analyse Math (module 2)
            ['libelle' => 'CC1 Analyse',          'type' => 'CC',   'date_evaluation' => '2023-10-20', 'id_module' => 2],
            ['libelle' => 'Examen Analyse',        'type' => 'EXAM', 'date_evaluation' => '2024-01-22', 'id_module' => 2],
            // POO (module 3)
            ['libelle' => 'TP POO',               'type' => 'TP',   'date_evaluation' => '2024-03-10', 'id_module' => 3],
            ['libelle' => 'Examen POO',            'type' => 'EXAM', 'date_evaluation' => '2024-06-15', 'id_module' => 3],
            // Base de Données (module 4)
            ['libelle' => 'CC1 BDD',              'type' => 'CC',   'date_evaluation' => '2024-03-18', 'id_module' => 4],
            ['libelle' => 'Examen BDD',            'type' => 'EXAM', 'date_evaluation' => '2024-06-18', 'id_module' => 4],
        ]);

        // ─── 11. NOTES ────────────────────────────────────────────────────
        DB::table('note')->insert([
            // Moussaoui (id 5)
            ['id_user' => 5, 'id_evaluation' => 1, 'note' => 14.50, 'rattrapage' => null, 'note_finale' => 14.50],
            ['id_user' => 5, 'id_evaluation' => 2, 'note' => 12.00, 'rattrapage' => null, 'note_finale' => 12.00],
            ['id_user' => 5, 'id_evaluation' => 3, 'note' => 16.00, 'rattrapage' => null, 'note_finale' => 16.00],
            ['id_user' => 5, 'id_evaluation' => 4, 'note' => 09.00, 'rattrapage' => 11.00, 'note_finale' => 11.00],
            ['id_user' => 5, 'id_evaluation' => 5, 'note' => 15.00, 'rattrapage' => null, 'note_finale' => 15.00],
            ['id_user' => 5, 'id_evaluation' => 6, 'note' => 13.50, 'rattrapage' => null, 'note_finale' => 13.50],
            // Tazi (id 6)
            ['id_user' => 6, 'id_evaluation' => 1, 'note' => 08.00, 'rattrapage' => 10.50, 'note_finale' => 10.50],
            ['id_user' => 6, 'id_evaluation' => 2, 'note' => 11.00, 'rattrapage' => null,  'note_finale' => 11.00],
            ['id_user' => 6, 'id_evaluation' => 3, 'note' => 13.00, 'rattrapage' => null,  'note_finale' => 13.00],
            ['id_user' => 6, 'id_evaluation' => 4, 'note' => 07.50, 'rattrapage' => 09.00, 'note_finale' => 09.00],
            ['id_user' => 6, 'id_evaluation' => 7, 'note' => 12.00, 'rattrapage' => null,  'note_finale' => 12.00],
            ['id_user' => 6, 'id_evaluation' => 8, 'note' => 10.00, 'rattrapage' => null,  'note_finale' => 10.00],
        ]);

        // ─── 12. RECLAMATIONS ─────────────────────────────────────────────
        DB::table('reclamation')->insert([
            [
                'message'          => "Je pense qu'il y a une erreur dans ma note d'examen d'analyse.",
                'date_reclamation' => '2024-02-01 10:30:00',
                'statut'           => 'TRAITEE',
                'id_note'          => 4,   // Moussaoui note Analyse EXAM
                'id_user'          => 5,
            ],
            [
                'message'          => "Ma note de CC Algorithmique semble incorrecte.",
                'date_reclamation' => '2024-01-25 14:00:00',
                'statut'           => 'EN_ATTENTE',
                'id_note'          => 7,   // Tazi note CC Algo
                'id_user'          => 6,
            ],
        ]);

        // ─── 13. LOG ACTIONS ──────────────────────────────────────────────
        DB::table('log_action')->insert([
            ['action' => 'CREATE', 'table_concernee' => 'utilisateurs',     'id_enregistrement' => 5, 'id_user' => 1, 'date_action' => now()],
            ['action' => 'UPDATE', 'table_concernee' => 'notes',            'id_enregistrement' => 4, 'id_user' => 2, 'date_action' => now()],
            ['action' => 'UPDATE', 'table_concernee' => 'reclamations',     'id_enregistrement' => 1, 'id_user' => 2, 'date_action' => now()],
            ['action' => 'CREATE', 'table_concernee' => 'inscriptions',     'id_enregistrement' => 6, 'id_user' => 1, 'date_action' => now()],
        ]);
    }
}