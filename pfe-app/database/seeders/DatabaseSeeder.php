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
        foreach ([
            'inscrire', 'intervenir', 'log_actions', 'reclamations',
            'notes', 'modules', 'semestres', 'annees_academiques',
            'filieres', 'etudiants', 'enseignants', 'departements', 'utilisateurs'
        ] as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ─── 1. UTILISATEURS ──────────────────────────────────────────────
        DB::table('utilisateurs')->insert([
            ['nom' => 'Alaoui',    'prenom' => 'Karim',    'email' => 'a.karim@ump.ac.ma',                  'mot_de_passe' => Hash::make('password'), 'role' => 'ADMIN',      'actif' => true,  'date_creation' => now()],
            ['nom' => 'Benali',    'prenom' => 'Youssef',  'email' => 'y.benali@ump.ac.ma',                 'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true,  'date_creation' => now()],
            ['nom' => 'Cherkaoui', 'prenom' => 'Fatima',   'email' => 'f.cherkaoui@ump.ac.ma',              'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true,  'date_creation' => now()],
            ['nom' => 'Idrissi',   'prenom' => 'Omar',     'email' => 'o.idrissi@ump.ac.ma',                'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true,  'date_creation' => now()],
            ['nom' => 'Bellatrach','prenom' => 'Mohammed', 'email' => 'bellatrach.mohammed.24@ump.ac.ma',   'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Elmir',     'prenom' => 'Rayane',   'email' => 'elmir.rayane.24@ump.ac.ma',          'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Chehlafi',  'prenom' => 'Ibrahim',  'email' => 'chehlafi.ibrahim.24@ump.ac.ma',      'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Lamrani',   'prenom' => 'Nadia',    'email' => 'lamrani.nadia.23@ump.ac.ma',         'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => false, 'date_creation' => now()],
        ]);
        // id_user: 1=Admin, 2=Benali, 3=Cherkaoui, 4=Idrissi, 5=Bellatrach, 6=Elmir, 7=Chehlafi, 8=Lamrani

        // ─── 2. DEPARTEMENTS ──────────────────────────────────────────────
        DB::table('departements')->insert([
            ['nom_departement' => 'Génie Informatique'],   // id 1
            ['nom_departement' => 'Sciences de Base'],     // id 2
            ['nom_departement' => 'Réseaux et Télécoms'],  // id 3
        ]);

        // ─── 3. ENSEIGNANTS ───────────────────────────────────────────────
        DB::table('enseignants')->insert([
            ['specialite' => 'Informatique',        'is_chef' => true,  'id_departement' => 1, 'id_user' => 2],  // id 1 = Benali
            ['specialite' => 'Mathématiques',       'is_chef' => false, 'id_departement' => 2, 'id_user' => 3],  // id 2 = Cherkaoui
            ['specialite' => 'Réseaux et Systèmes', 'is_chef' => false, 'id_departement' => 3, 'id_user' => 4],  // id 3 = Idrissi
        ]);

        // ─── 4. ETUDIANTS ─────────────────────────────────────────────────
        DB::table('etudiants')->insert([
            ['cne' => 'G110023001', 'id_user' => 5],  // id 1 = Bellatrach
            ['cne' => 'G110023002', 'id_user' => 6],  // id 2 = Elmir
            ['cne' => 'G110023003', 'id_user' => 7],  // id 3 = Chehlafi
            ['cne' => 'G110023004', 'id_user' => 8],  // id 4 = Lamrani
        ]);

        // ─── 5. FILIERES ──────────────────────────────────────────────────
        DB::table('filieres')->insert([
            ['nom_filiere' => 'Conception et Développement des Logiciels', 'description' => 'Formation en développement logiciel et architecture.', 'id_departement' => 1],  // id 1
            ['nom_filiere' => 'Réseaux Sécurité et Télécoms',              'description' => 'Formation en réseaux, sécurité et télécommunications.', 'id_departement' => 3],  // id 2
        ]);

        // ─── 6. ANNEES ACADEMIQUES ────────────────────────────────────────
        DB::table('annees_academiques')->insert([
            ['libelle' => '2023-2024', 'id_filiere' => 1],  // id 1
            ['libelle' => '2024-2025', 'id_filiere' => 1],  // id 2
            ['libelle' => '2024-2025', 'id_filiere' => 2],  // id 3
        ]);

        // ─── 7. SEMESTRES ─────────────────────────────────────────────────
        DB::table('semestres')->insert([
            ['numero' => 1, 'cloture' => true,  'id_annee' => 1],  // id 1 - S1 GL 2023-24 (clôturé)
            ['numero' => 2, 'cloture' => true,  'id_annee' => 1],  // id 2 - S2 GL 2023-24 (clôturé)
            ['numero' => 1, 'cloture' => false, 'id_annee' => 2],  // id 3 - S1 GL 2024-25 (actif)
            ['numero' => 1, 'cloture' => false, 'id_annee' => 3],  // id 4 - S1 RT 2024-25 (actif)
        ]);

        // ─── 8. MODULES ───────────────────────────────────────────────────
        DB::table('modules')->insert([
            ['code_module' => 'INF101', 'nom_module' => 'Algorithmique',              'id_semestre' => 1, 'id_enseignant' => 1],  // id 1
            ['code_module' => 'MAT101', 'nom_module' => 'Analyse Mathématique',       'id_semestre' => 1, 'id_enseignant' => 2],  // id 2
            ['code_module' => 'INF201', 'nom_module' => 'OOP C++',                    'id_semestre' => 2, 'id_enseignant' => 1],  // id 3
            ['code_module' => 'INF202', 'nom_module' => 'Base de Données MySQL',      'id_semestre' => 2, 'id_enseignant' => 1],  // id 4
            ['code_module' => 'INF301', 'nom_module' => 'Développement Web 1',        'id_semestre' => 3, 'id_enseignant' => 1],  // id 5
            ['code_module' => 'RES101', 'nom_module' => 'Réseaux Informatiques',      'id_semestre' => 4, 'id_enseignant' => 3],  // id 6
        ]);

        // ─── 9. INTERVENIR ────────────────────
        DB::table('intervenir')->insert([
            ['id_enseignant' => 2, 'id_module' => 1],  // Cherkaoui also on Algorithmique
            ['id_enseignant' => 3, 'id_module' => 6],  // Idrissi also on Réseaux
        ]);

        // ─── 10. INSCRIRE (enrollments) ───────────────────────────────────
        DB::table('inscrire')->insert([
            ['id_etudiant' => 1, 'id_semestre' => 1],  // Bellatrach - S1 GL 2023-24
            ['id_etudiant' => 1, 'id_semestre' => 2],  // Bellatrach - S2 GL 2023-24
            ['id_etudiant' => 2, 'id_semestre' => 1],  // Elmir - S1 GL 2023-24
            ['id_etudiant' => 2, 'id_semestre' => 2],  // Elmir - S2 GL 2023-24
            ['id_etudiant' => 3, 'id_semestre' => 3],  // Chehlafi - S1 GL 2024-25
            ['id_etudiant' => 4, 'id_semestre' => 4],  // Lamrani - S1 RT 2024-25
        ]);

        // ─── 11. NOTES ────────────────────────────────────────────────────
        DB::table('notes')->insert([
            // Bellatrach (id_etudiant 1)
            ['id_etudiant' => 1, 'id_module' => 1, 'note' => 14.50, 'rattrapage' => null],
            ['id_etudiant' => 1, 'id_module' => 2, 'note' => 12.00, 'rattrapage' => null],
            ['id_etudiant' => 1, 'id_module' => 3, 'note' => 16.00, 'rattrapage' => null],
            ['id_etudiant' => 1, 'id_module' => 4, 'note' =>  9.00, 'rattrapage' => 11.00],
            // Elmir (id_etudiant 2)
            ['id_etudiant' => 2, 'id_module' => 1, 'note' =>  8.00, 'rattrapage' => 10.50],
            ['id_etudiant' => 2, 'id_module' => 2, 'note' => 11.00, 'rattrapage' => null],
            ['id_etudiant' => 2, 'id_module' => 3, 'note' => 13.00, 'rattrapage' => null],
            ['id_etudiant' => 2, 'id_module' => 4, 'note' =>  7.50, 'rattrapage' =>  9.00],
        ]);
        // id_note: 1=Bellatrach/INF101, 2=Bellatrach/MAT101, 3=Bellatrach/INF201
        //          4=Bellatrach/INF202, 5=Elmir/INF101, 6=Elmir/MAT101 ...

        // ─── 12. RECLAMATIONS ─────────────────────────────────────────────
        DB::table('reclamations')->insert([
            [
                'message'          => "Erreur possible sur ma note de BDD.",
                'date_reclamation' => '2024-02-01 10:30:00',
                'id_note'          => 4,   // Bellatrach - INF202
            ],
            [
                'message'          => "Ma note CC Algorithmique semble incorrecte.",
                'date_reclamation' => '2024-01-25 14:00:00',
                'id_note'          => 5,   // Elmir - INF101
            ],
        ]);

        // ─── 13. LOG ACTIONS ──────────────────────────────────────────────
        DB::table('log_actions')->insert([
            ['action' => 'CREATE', 'table_concernee' => 'etudiants',    'id_enregistrement' => 1, 'id_user' => 1, 'date_action' => now()],
            ['action' => 'UPDATE', 'table_concernee' => 'notes',        'id_enregistrement' => 4, 'id_user' => 2, 'date_action' => now()],
            ['action' => 'UPDATE', 'table_concernee' => 'reclamations', 'id_enregistrement' => 1, 'id_user' => 2, 'date_action' => now()],
            ['action' => 'CREATE', 'table_concernee' => 'inscrire',     'id_enregistrement' => 5, 'id_user' => 1, 'date_action' => now()],
        ]);
    }
}