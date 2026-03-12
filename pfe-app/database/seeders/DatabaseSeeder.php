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
        DB::table('LOG_ACTION')->truncate();
        DB::table('RECLAMATION')->truncate();
        DB::table('NOTE')->truncate();
        DB::table('intervenir')->truncate();
        DB::table('inscrire')->truncate();
        DB::table('MODULE')->truncate();
        DB::table('SEMESTRE')->truncate();
        DB::table('ANNEE_ACADEMIQUE')->truncate();
        DB::table('FILIERE')->truncate();
        DB::table('ETUDIANT')->truncate();
        DB::table('ENSEIGNANT')->truncate();
        DB::table('DEPARTEMENT')->truncate();
        DB::table('Utilisateur')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ─── 1. UTILISATEURS ──────────────────────────────────────────────
        DB::table('Utilisateur')->insert([
            // id_user: 1 — Admin
            ['nom' => 'Alaoui',     'prenom' => 'Karim',    'email' => 'a.karim@ump.ac.ma',                  'mot_de_passe' => Hash::make('password'), 'role' => 'ADMIN',      'actif' => true,  'date_creation' => now()],
            // id_user: 2 — Enseignant chef
            ['nom' => 'Benali',     'prenom' => 'Youssef',  'email' => 'y.benali@ump.ac.ma',                 'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true,  'date_creation' => now()],
            // id_user: 3 — Enseignant
            ['nom' => 'Cherkaoui', 'prenom' => 'Fatima',   'email' => 'f.cherkaoui@ump.ac.ma',              'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true,  'date_creation' => now()],
            // id_user: 4 — Enseignant
            ['nom' => 'Idrissi',   'prenom' => 'Omar',     'email' => 'o.idrissi@ump.ac.ma',                'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true,  'date_creation' => now()],
            // id_user: 5 — Etudiant
            ['nom' => 'Bellatrach', 'prenom' => 'Mohammed', 'email' => 'bellatrach.mohammed.24@ump.ac.ma',  'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user: 6 — Etudiant
            ['nom' => 'Elmir',      'prenom' => 'Rayane',   'email' => 'elmir.rayane.24@ump.ac.ma',         'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user: 7 — Etudiant
            ['nom' => 'Chehlafi',   'prenom' => 'Ibrahim',  'email' => 'chehlafi.ibrahim.24@ump.ac.ma',     'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user: 8 — Etudiant (inactif)
            ['nom' => 'Lamrani',   'prenom' => 'Nadia',    'email' => 'lamrani.nadia.23@ump.ac.ma',        'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => false, 'date_creation' => now()],
        ]);

        // ─── 2. DEPARTEMENTS ──────────────────────────────────────────────
        DB::table('DEPARTEMENT')->insert([
            ['nom_departement' => 'Génie Informatique'],   // id_departement: 1
            ['nom_departement' => 'Sciences de Base'],     // id_departement: 2
        ]);

        // ─── 3. ENSEIGNANTS ───────────────────────────────────────────────
        DB::table('ENSEIGNANT')->insert([
            // id_enseignant: 1 — Benali (chef GI)
            ['id_user' => 2, 'specialite' => 'Informatique',        'is_chef' => true,  'id_departement' => 1],
            // id_enseignant: 2 — Cherkaoui
            ['id_user' => 3, 'specialite' => 'Mathématiques',       'is_chef' => false, 'id_departement' => 2],
            // id_enseignant: 3 — Idrissi
            ['id_user' => 4, 'specialite' => 'Réseaux et Systèmes', 'is_chef' => false, 'id_departement' => 1],
        ]);

        // ─── 4. FILIERES ──────────────────────────────────────────────────
        DB::table('FILIERE')->insert([
            // id_filiere: 1
            ['nom_filiere' => 'Génie Logiciel',            'description' => 'Formation en développement logiciel et architecture.', 'id_departement' => 1],
            // id_filiere: 2
            ['nom_filiere' => 'Réseaux et Télécoms',       'description' => 'Formation en réseaux, sécurité et télécommunications.', 'id_departement' => 1],
        ]);

        // ─── 5. ANNEES ACADEMIQUES ────────────────────────────────────────
        DB::table('ANNEE_ACADEMIQUE')->insert([
            ['libelle' => '2023-2024', 'id_filiere' => 1],  // id_annee: 1 — GL
            ['libelle' => '2024-2025', 'id_filiere' => 1],  // id_annee: 2 — GL
            ['libelle' => '2024-2025', 'id_filiere' => 2],  // id_annee: 3 — RT
        ]);

        // ─── 6. SEMESTRES ─────────────────────────────────────────────────
        DB::table('SEMESTRE')->insert([
            ['numero' => 1, 'cloture' => true,  'id_annee' => 1],  // id_semestre: 1 — S1 GL 2023-24 (clôturé)
            ['numero' => 2, 'cloture' => true,  'id_annee' => 1],  // id_semestre: 2 — S2 GL 2023-24 (clôturé)
            ['numero' => 1, 'cloture' => false, 'id_annee' => 2],  // id_semestre: 3 — S1 GL 2024-25 (actif)
            ['numero' => 1, 'cloture' => false, 'id_annee' => 3],  // id_semestre: 4 — S1 RT 2024-25 (actif)
        ]);

        // ─── 7. MODULES ───────────────────────────────────────────────────
        DB::table('MODULE')->insert([
            // S1 GL 2023-24
            ['code_module' => 'INF101', 'nom_module' => 'Algorithmique',         'id_semestre' => 1, 'id_enseignant' => 1],  // id_module: 1
            ['code_module' => 'MAT101', 'nom_module' => 'Analyse Mathématique',  'id_semestre' => 1, 'id_enseignant' => 2],  // id_module: 2
            // S2 GL 2023-24
            ['code_module' => 'INF201', 'nom_module' => 'OOP C++',              'id_semestre' => 2, 'id_enseignant' => 1],  // id_module: 3
            ['code_module' => 'INF202', 'nom_module' => 'Base de Données',      'id_semestre' => 2, 'id_enseignant' => 1],  // id_module: 4
            // S1 GL 2024-25
            ['code_module' => 'INF301', 'nom_module' => 'Développement Web',    'id_semestre' => 3, 'id_enseignant' => 1],  // id_module: 5
            // S1 RT 2024-25
            ['code_module' => 'RES101', 'nom_module' => 'Réseaux Informatiques','id_semestre' => 4, 'id_enseignant' => 3],  // id_module: 6
        ]);

        // ─── 8. INTERVENIR ────────────────────────────────────────────────
        DB::table('intervenir')->insert([
            ['id_enseignant' => 1, 'id_module' => 1],
            ['id_enseignant' => 2, 'id_module' => 2],
            ['id_enseignant' => 1, 'id_module' => 3],
            ['id_enseignant' => 1, 'id_module' => 4],
            ['id_enseignant' => 1, 'id_module' => 5],
            ['id_enseignant' => 3, 'id_module' => 6],
        ]);

        // ─── 9. ETUDIANTS ─────────────────────────────────────────────────
        DB::table('ETUDIANT')->insert([
            ['id_user' => 5, 'cne' => 'G110023001'],  // id_etudiant: 1 — Bellatrach
            ['id_user' => 6, 'cne' => 'G110023002'],  // id_etudiant: 2 — Elmir
            ['id_user' => 7, 'cne' => 'G110023003'],  // id_etudiant: 3 — Chehlafi
            ['id_user' => 8, 'cne' => 'G110023004'],  // id_etudiant: 4 — Lamrani
        ]);

        // ─── 10. INSCRIRE ─────────────────────────────────────────────────
        DB::table('inscrire')->insert([
            // Bellatrach — GL S1+S2 2023-24 + S1 2024-25
            ['id_etudiant' => 1, 'id_semestre' => 1],
            ['id_etudiant' => 1, 'id_semestre' => 2],
            ['id_etudiant' => 1, 'id_semestre' => 3],
            // Elmir — GL S1+S2 2023-24
            ['id_etudiant' => 2, 'id_semestre' => 1],
            ['id_etudiant' => 2, 'id_semestre' => 2],
            // Chehlafi — GL S1 2024-25
            ['id_etudiant' => 3, 'id_semestre' => 3],
            // Lamrani — RT S1 2024-25
            ['id_etudiant' => 4, 'id_semestre' => 4],
        ]);

        // ─── 11. NOTES ────────────────────────────────────────────────────
        DB::table('NOTE')->insert([
            // Bellatrach (id_etudiant: 1)
            ['id_etudiant' => 1, 'id_module' => 1, 'note' => 14.50, 'rattrapage' => null],
            ['id_etudiant' => 1, 'id_module' => 2, 'note' => 16.00, 'rattrapage' => null],
            ['id_etudiant' => 1, 'id_module' => 3, 'note' => 13.50, 'rattrapage' => null],
            ['id_etudiant' => 1, 'id_module' => 4, 'note' => 09.00, 'rattrapage' => 11.00],
            ['id_etudiant' => 1, 'id_module' => 5, 'note' => 15.00, 'rattrapage' => null],
            // Elmir (id_etudiant: 2)
            ['id_etudiant' => 2, 'id_module' => 1, 'note' => 08.00, 'rattrapage' => 10.50],
            ['id_etudiant' => 2, 'id_module' => 2, 'note' => 12.00, 'rattrapage' => null],
            ['id_etudiant' => 2, 'id_module' => 3, 'note' => 07.50, 'rattrapage' => 09.00],
            ['id_etudiant' => 2, 'id_module' => 4, 'note' => 11.00, 'rattrapage' => null],
            // Chehlafi (id_etudiant: 3)
            ['id_etudiant' => 3, 'id_module' => 5, 'note' => 17.00, 'rattrapage' => null],
            // Lamrani (id_etudiant: 4)
            ['id_etudiant' => 4, 'id_module' => 6, 'note' => 13.00, 'rattrapage' => null],
        ]);

        // ─── 12. RECLAMATIONS ─────────────────────────────────────────────
        DB::table('RECLAMATION')->insert([
            [
                'message'          => "Je pense qu'il y a une erreur dans ma note de Base de Données.",
                'date_reclamation' => '2024-02-01 10:30:00',
                'id_note'          => 4,  // Bellatrach BDD
            ],
            [
                'message'          => "Ma note d'algorithmique semble incorrecte.",
                'date_reclamation' => '2024-01-25 14:00:00',
                'id_note'          => 6,  // Elmir Algorithmique
            ],
        ]);

        // ─── 13. LOG ACTIONS ──────────────────────────────────────────────
        DB::table('LOG_ACTION')->insert([
            ['action' => 'CREATE', 'table_concernee' => 'Utilisateur', 'id_enregistrement' => 5, 'id_user' => 1, 'date_action' => now()],
            ['action' => 'UPDATE', 'table_concernee' => 'NOTE',        'id_enregistrement' => 4, 'id_user' => 2, 'date_action' => now()],
        ]);
    }
}