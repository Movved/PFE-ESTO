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
        // IDs : 1=Admin, 2=Benali, 3=Cherkaoui, 4=Idrissi, 5=Mansouri
        // IDs étudiants : 6..17
        DB::table('utilisateur')->insert([
            // Admin
            ['nom' => 'Alaoui',    'prenom' => 'Karim',    'email' => 'A.karim@ump.ac.ma',              'mot_de_passe' => Hash::make('password'), 'role' => 'ADMIN',      'actif' => true,  'date_creation' => now()],
            // Enseignants
            ['nom' => 'Benali',    'prenom' => 'Youssef',  'email' => 'y.benali@ump.ac.ma',             'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true,  'date_creation' => now()],
            ['nom' => 'Cherkaoui', 'prenom' => 'Fatima',   'email' => 'f.cherkaoui@ump.ac.ma',          'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true,  'date_creation' => now()],
            ['nom' => 'Idrissi',   'prenom' => 'Omar',     'email' => 'o.idrissi@ump.ac.ma',            'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true,  'date_creation' => now()],
            ['nom' => 'Mansouri',  'prenom' => 'Samira',   'email' => 's.mansouri@ump.ac.ma',           'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true,  'date_creation' => now()],
            // Étudiants filière GL (id_filiere=1)
            ['nom' => 'Bellatrach','prenom' => 'Mohammed', 'email' => 'bellatrach.mohammed.24@ump.ac.ma','mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Elmir',     'prenom' => 'Rayane',   'email' => 'elmir.rayane.24@ump.ac.ma',      'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Chehlafi',  'prenom' => 'Ibrahim',  'email' => 'chehlafi.ibrahim.24@ump.ac.ma',  'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Lamrani',   'prenom' => 'Nadia',    'email' => 'lamrani.nadia.23@ump.ac.ma',     'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => false, 'date_creation' => now()],
            ['nom' => 'Hamdouni',  'prenom' => 'Anas',     'email' => 'hamdouni.anas.24@ump.ac.ma',     'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Zouheir',   'prenom' => 'Salma',    'email' => 'zouheir.salma.24@ump.ac.ma',     'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Benkirane', 'prenom' => 'Hamza',    'email' => 'benkirane.hamza.23@ump.ac.ma',   'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Tazi',      'prenom' => 'Imane',    'email' => 'tazi.imane.23@ump.ac.ma',        'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // Étudiants filière RT (id_filiere=2)
            ['nom' => 'Ouali',     'prenom' => 'Kaoutar',  'email' => 'ouali.kaoutar.24@ump.ac.ma',     'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Sebti',     'prenom' => 'Yassine',  'email' => 'sebti.yassine.24@ump.ac.ma',     'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Bouchaib',  'prenom' => 'Meriem',   'email' => 'bouchaib.meriem.24@ump.ac.ma',   'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Lahlou',    'prenom' => 'Soufiane', 'email' => 'lahlou.soufiane.24@ump.ac.ma',   'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => false, 'date_creation' => now()],
            // Étudiants filière IASD (id_filiere=3)
            ['nom' => 'Bensouda',  'prenom' => 'Chaima',   'email' => 'bensouda.chaima.24@ump.ac.ma',   'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Filali',    'prenom' => 'Adam',     'email' => 'filali.adam.24@ump.ac.ma',       'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            ['nom' => 'Rahmani',   'prenom' => 'Houda',    'email' => 'rahmani.houda.24@ump.ac.ma',     'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
        ]);

        // ─── 2. ENSEIGNANTS ───────────────────────────────────────────────
        // 2=Benali (chef GL), 3=Cherkaoui, 4=Idrissi (chef RT), 5=Mansouri (chef IASD)
        DB::table('enseignant')->insert([
            ['id_user' => 2, 'specialite' => 'Informatique',           'departement' => 'Génie Informatique', 'is_chef' => true],
            ['id_user' => 3, 'specialite' => 'Mathématiques',          'departement' => 'Sciences de Base',   'is_chef' => false],
            ['id_user' => 4, 'specialite' => 'Réseaux et Systèmes',    'departement' => 'Génie Informatique', 'is_chef' => true],
            ['id_user' => 5, 'specialite' => 'Intelligence Artificielle','departement' => 'Génie Informatique','is_chef' => true],
        ]);

        // ─── 3. FILIERES ──────────────────────────────────────────────────
        DB::table('filiere')->insert([
            ['nom_filiere' => 'Conception et Développement des Logiciels', 'description' => 'Formation en développement logiciel et architecture.',              'responsable_id' => 2],
            ['nom_filiere' => 'Réseaux Sécurité et Télécoms',              'description' => 'Formation en réseaux, sécurité et télécommunications.',             'responsable_id' => 4],
            ['nom_filiere' => 'Intelligence Artificielle et Science des Données', 'description' => 'Formation en IA, machine learning et data science.',         'responsable_id' => 5],
        ]);

        // ─── 4. ANNEES ACADEMIQUES ────────────────────────────────────────
        DB::table('annee_academique')->insert([
            ['libelle' => '2023-2024', 'id_filiere' => 1],   // id=1 GL 23-24
            ['libelle' => '2024-2025', 'id_filiere' => 1],   // id=2 GL 24-25
            ['libelle' => '2023-2024', 'id_filiere' => 2],   // id=3 RT 23-24
            ['libelle' => '2024-2025', 'id_filiere' => 2],   // id=4 RT 24-25
            ['libelle' => '2024-2025', 'id_filiere' => 3],   // id=5 IASD 24-25
        ]);

        // ─── 5. SEMESTRES ─────────────────────────────────────────────────
        DB::table('semestre')->insert([
            // GL 2023-24
            ['numero' => 1, 'cloture' => true,  'id_annee' => 1],  // id=1  S1 GL 23-24 (clôturé)
            ['numero' => 2, 'cloture' => true,  'id_annee' => 1],  // id=2  S2 GL 23-24 (clôturé)
            // GL 2024-25
            ['numero' => 1, 'cloture' => true,  'id_annee' => 2],  // id=3  S1 GL 24-25 (clôturé)
            ['numero' => 2, 'cloture' => false, 'id_annee' => 2],  // id=4  S2 GL 24-25 (actif)
            // RT 2023-24
            ['numero' => 1, 'cloture' => true,  'id_annee' => 3],  // id=5  S1 RT 23-24 (clôturé)
            ['numero' => 2, 'cloture' => true,  'id_annee' => 3],  // id=6  S2 RT 23-24 (clôturé)
            // RT 2024-25
            ['numero' => 1, 'cloture' => true,  'id_annee' => 4],  // id=7  S1 RT 24-25 (clôturé)
            ['numero' => 2, 'cloture' => false, 'id_annee' => 4],  // id=8  S2 RT 24-25 (actif)
            // IASD 2024-25
            ['numero' => 1, 'cloture' => true,  'id_annee' => 5],  // id=9  S1 IASD 24-25 (clôturé)
            ['numero' => 2, 'cloture' => false, 'id_annee' => 5],  // id=10 S2 IASD 24-25 (actif)
        ]);

        // ─── 6. MODULES ───────────────────────────────────────────────────
        // Règle : 1 module par filière par prof (mais un prof peut intervenir dans plusieurs filières)
        DB::table('module')->insert([
            // ── GL 2023-24 S1 (semestre 1)
            ['code_module' => 'GL-INF101', 'nom_module' => 'Algorithmique',           'id_semestre' => 1],  // id=1  Benali
            ['code_module' => 'GL-MAT101', 'nom_module' => 'Analyse Mathématique',    'id_semestre' => 1],  // id=2  Cherkaoui
            // ── GL 2023-24 S2 (semestre 2)
            ['code_module' => 'GL-INF201', 'nom_module' => 'Programmation Orientée Objet C++', 'id_semestre' => 2],  // id=3  Benali
            ['code_module' => 'GL-INF202', 'nom_module' => 'Base de Données MySQL',   'id_semestre' => 2],  // id=4  Benali
            ['code_module' => 'GL-MAT201', 'nom_module' => 'Probabilités & Statistiques', 'id_semestre' => 2],  // id=5  Cherkaoui
            // ── GL 2024-25 S1 (semestre 3)
            ['code_module' => 'GL-INF301', 'nom_module' => 'Développement Web 1',     'id_semestre' => 3],  // id=6  Benali
            ['code_module' => 'GL-MAT301', 'nom_module' => 'Algèbre Linéaire',        'id_semestre' => 3],  // id=7  Cherkaoui
            // ── GL 2024-25 S2 (semestre 4)
            ['code_module' => 'GL-INF401', 'nom_module' => 'Développement Web 2',     'id_semestre' => 4],  // id=8  Benali
            ['code_module' => 'GL-INF402', 'nom_module' => 'DevOps & CI/CD',          'id_semestre' => 4],  // id=9  Idrissi (multi-filière)
            // ── RT 2023-24 S1 (semestre 5)
            ['code_module' => 'RT-RES101', 'nom_module' => 'Réseaux Informatiques',   'id_semestre' => 5],  // id=10 Idrissi
            ['code_module' => 'RT-MAT101', 'nom_module' => 'Mathématiques Discrètes', 'id_semestre' => 5],  // id=11 Cherkaoui (multi-filière)
            // ── RT 2023-24 S2 (semestre 6)
            ['code_module' => 'RT-RES201', 'nom_module' => 'Sécurité des Réseaux',    'id_semestre' => 6],  // id=12 Idrissi
            ['code_module' => 'RT-SYS201', 'nom_module' => 'Systèmes d\'Exploitation','id_semestre' => 6],  // id=13 Benali (multi-filière)
            // ── RT 2024-25 S1 (semestre 7)
            ['code_module' => 'RT-RES301', 'nom_module' => 'Architecture Réseaux',    'id_semestre' => 7],  // id=14 Idrissi
            ['code_module' => 'RT-SEC301', 'nom_module' => 'Cybersécurité Avancée',   'id_semestre' => 7],  // id=15 Mansouri (multi-filière)
            // ── RT 2024-25 S2 (semestre 8)
            ['code_module' => 'RT-RES401', 'nom_module' => 'Cloud Computing',         'id_semestre' => 8],  // id=16 Idrissi
            // ── IASD 2024-25 S1 (semestre 9)
            ['code_module' => 'IA-INF101', 'nom_module' => 'Introduction au Machine Learning', 'id_semestre' => 9],  // id=17 Mansouri
            ['code_module' => 'IA-MAT101', 'nom_module' => 'Statistiques pour l\'IA', 'id_semestre' => 9],  // id=18 Cherkaoui (multi-filière)
            // ── IASD 2024-25 S2 (semestre 10)
            ['code_module' => 'IA-INF201', 'nom_module' => 'Deep Learning',           'id_semestre' => 10], // id=19 Mansouri
            ['code_module' => 'IA-INF202', 'nom_module' => 'Big Data & Spark',        'id_semestre' => 10], // id=20 Benali (multi-filière)
        ]);

        // ─── 7. ENSEIGNEMENTS ─────────────────────────────────────────────
        // Un prof peut enseigner dans plusieurs filières, mais 1 seul module par filière
        DB::table('enseignement')->insert([
            // Benali (id=2) : GL principal + apparitions en RT et IASD
            ['id_user' => 2, 'id_module' => 1],   // Algorithmique GL S1 23-24
            ['id_user' => 2, 'id_module' => 3],   // POO GL S2 23-24
            ['id_user' => 2, 'id_module' => 4],   // BDD GL S2 23-24
            ['id_user' => 2, 'id_module' => 6],   // Dev Web 1 GL S1 24-25
            ['id_user' => 2, 'id_module' => 8],   // Dev Web 2 GL S2 24-25
            ['id_user' => 2, 'id_module' => 13],  // Systèmes d'Exploitation RT S2 23-24 ← multi-filière
            ['id_user' => 2, 'id_module' => 20],  // Big Data IASD S2 24-25 ← multi-filière

            // Cherkaoui (id=3) : Maths dans GL + RT + IASD
            ['id_user' => 3, 'id_module' => 2],   // Analyse Maths GL S1 23-24
            ['id_user' => 3, 'id_module' => 5],   // Probas & Stats GL S2 23-24
            ['id_user' => 3, 'id_module' => 7],   // Algèbre Linéaire GL S1 24-25
            ['id_user' => 3, 'id_module' => 11],  // Maths Discrètes RT S1 23-24 ← multi-filière
            ['id_user' => 3, 'id_module' => 18],  // Stats pour l'IA IASD S1 24-25 ← multi-filière

            // Idrissi (id=4) : Réseaux RT principal + DevOps en GL
            ['id_user' => 4, 'id_module' => 10],  // Réseaux Informatiques RT S1 23-24
            ['id_user' => 4, 'id_module' => 12],  // Sécurité Réseaux RT S2 23-24
            ['id_user' => 4, 'id_module' => 14],  // Architecture Réseaux RT S1 24-25
            ['id_user' => 4, 'id_module' => 16],  // Cloud Computing RT S2 24-25
            ['id_user' => 4, 'id_module' => 9],   // DevOps GL S2 24-25 ← multi-filière

            // Mansouri (id=5) : IA principal + Cybersécurité en RT
            ['id_user' => 5, 'id_module' => 17],  // Intro ML IASD S1 24-25
            ['id_user' => 5, 'id_module' => 19],  // Deep Learning IASD S2 24-25
            ['id_user' => 5, 'id_module' => 15],  // Cybersécurité RT S1 24-25 ← multi-filière
        ]);

        // ─── 8. ETUDIANTS ─────────────────────────────────────────────────
        // id_user 6..13 → GL | 14..17 → RT | 18..20 → IASD
        DB::table('etudiant')->insert([
            // GL students
            ['id_user' => 6,  'cne' => 'G110024001', 'id_filiere' => 1, 'annee_actuelle' => 2],
            ['id_user' => 7,  'cne' => 'G110024002', 'id_filiere' => 1, 'annee_actuelle' => 2],
            ['id_user' => 8,  'cne' => 'G110024003', 'id_filiere' => 1, 'annee_actuelle' => 2],
            ['id_user' => 9,  'cne' => 'G110023004', 'id_filiere' => 1, 'annee_actuelle' => 2],
            ['id_user' => 10, 'cne' => 'G110024005', 'id_filiere' => 1, 'annee_actuelle' => 1],
            ['id_user' => 11, 'cne' => 'G110024006', 'id_filiere' => 1, 'annee_actuelle' => 1],
            ['id_user' => 12, 'cne' => 'G110023007', 'id_filiere' => 1, 'annee_actuelle' => 2],
            ['id_user' => 13, 'cne' => 'G110023008', 'id_filiere' => 1, 'annee_actuelle' => 2],
            // RT students
            ['id_user' => 14, 'cne' => 'R110024001', 'id_filiere' => 2, 'annee_actuelle' => 1],
            ['id_user' => 15, 'cne' => 'R110024002', 'id_filiere' => 2, 'annee_actuelle' => 1],
            ['id_user' => 16, 'cne' => 'R110024003', 'id_filiere' => 2, 'annee_actuelle' => 1],
            ['id_user' => 17, 'cne' => 'R110024004', 'id_filiere' => 2, 'annee_actuelle' => 1],
            // IASD students
            ['id_user' => 18, 'cne' => 'I110024001', 'id_filiere' => 3, 'annee_actuelle' => 1],
            ['id_user' => 19, 'cne' => 'I110024002', 'id_filiere' => 3, 'annee_actuelle' => 1],
            ['id_user' => 20, 'cne' => 'I110024003', 'id_filiere' => 3, 'annee_actuelle' => 1],
        ]);

        // ─── 9. INSCRIPTIONS ──────────────────────────────────────────────
        DB::table('inscription')->insert([
            // GL 2023-24 S1+S2 : Bellatrach(6), Elmir(7), Chehlafi(8), Lamrani(9), Benkirane(12), Tazi(13)
            ['id_user' => 6,  'id_semestre' => 1, 'date_inscription' => '2023-09-10 08:00:00'],
            ['id_user' => 6,  'id_semestre' => 2, 'date_inscription' => '2024-02-05 08:00:00'],
            ['id_user' => 7,  'id_semestre' => 1, 'date_inscription' => '2023-09-10 08:00:00'],
            ['id_user' => 7,  'id_semestre' => 2, 'date_inscription' => '2024-02-05 08:00:00'],
            ['id_user' => 8,  'id_semestre' => 1, 'date_inscription' => '2023-09-10 08:00:00'],
            ['id_user' => 8,  'id_semestre' => 2, 'date_inscription' => '2024-02-05 08:00:00'],
            ['id_user' => 9,  'id_semestre' => 1, 'date_inscription' => '2023-09-10 08:00:00'],
            ['id_user' => 9,  'id_semestre' => 2, 'date_inscription' => '2024-02-05 08:00:00'],
            ['id_user' => 12, 'id_semestre' => 1, 'date_inscription' => '2023-09-10 08:00:00'],
            ['id_user' => 12, 'id_semestre' => 2, 'date_inscription' => '2024-02-05 08:00:00'],
            ['id_user' => 13, 'id_semestre' => 1, 'date_inscription' => '2023-09-10 08:00:00'],
            ['id_user' => 13, 'id_semestre' => 2, 'date_inscription' => '2024-02-05 08:00:00'],
            // GL 2024-25 S1+S2 : tous les GL (y compris nouveaux : Hamdouni(10), Zouheir(11))
            ['id_user' => 6,  'id_semestre' => 3, 'date_inscription' => '2024-09-10 08:00:00'],
            ['id_user' => 6,  'id_semestre' => 4, 'date_inscription' => '2025-02-05 08:00:00'],
            ['id_user' => 7,  'id_semestre' => 3, 'date_inscription' => '2024-09-10 08:00:00'],
            ['id_user' => 7,  'id_semestre' => 4, 'date_inscription' => '2025-02-05 08:00:00'],
            ['id_user' => 8,  'id_semestre' => 3, 'date_inscription' => '2024-09-10 08:00:00'],
            ['id_user' => 10, 'id_semestre' => 3, 'date_inscription' => '2024-09-12 08:00:00'],
            ['id_user' => 10, 'id_semestre' => 4, 'date_inscription' => '2025-02-10 08:00:00'],
            ['id_user' => 11, 'id_semestre' => 3, 'date_inscription' => '2024-09-12 08:00:00'],
            ['id_user' => 11, 'id_semestre' => 4, 'date_inscription' => '2025-02-10 08:00:00'],
            ['id_user' => 12, 'id_semestre' => 3, 'date_inscription' => '2024-09-10 08:00:00'],
            ['id_user' => 13, 'id_semestre' => 3, 'date_inscription' => '2024-09-10 08:00:00'],
            // RT 2023-24 S1+S2 : Ouali(14), Sebti(15) (anciens)
            ['id_user' => 14, 'id_semestre' => 5, 'date_inscription' => '2023-09-11 08:00:00'],
            ['id_user' => 14, 'id_semestre' => 6, 'date_inscription' => '2024-02-06 08:00:00'],
            ['id_user' => 15, 'id_semestre' => 5, 'date_inscription' => '2023-09-11 08:00:00'],
            ['id_user' => 15, 'id_semestre' => 6, 'date_inscription' => '2024-02-06 08:00:00'],
            // RT 2024-25 S1+S2 : tous les RT
            ['id_user' => 14, 'id_semestre' => 7, 'date_inscription' => '2024-09-11 08:00:00'],
            ['id_user' => 14, 'id_semestre' => 8, 'date_inscription' => '2025-02-06 08:00:00'],
            ['id_user' => 15, 'id_semestre' => 7, 'date_inscription' => '2024-09-11 08:00:00'],
            ['id_user' => 15, 'id_semestre' => 8, 'date_inscription' => '2025-02-06 08:00:00'],
            ['id_user' => 16, 'id_semestre' => 7, 'date_inscription' => '2024-09-12 08:00:00'],
            ['id_user' => 16, 'id_semestre' => 8, 'date_inscription' => '2025-02-10 08:00:00'],
            ['id_user' => 17, 'id_semestre' => 7, 'date_inscription' => '2024-09-12 08:00:00'],
            // Lahlou(17) inactif → pas inscrit S2
            // IASD 2024-25 S1+S2
            ['id_user' => 18, 'id_semestre' => 9,  'date_inscription' => '2024-09-13 08:00:00'],
            ['id_user' => 18, 'id_semestre' => 10, 'date_inscription' => '2025-02-11 08:00:00'],
            ['id_user' => 19, 'id_semestre' => 9,  'date_inscription' => '2024-09-13 08:00:00'],
            ['id_user' => 19, 'id_semestre' => 10, 'date_inscription' => '2025-02-11 08:00:00'],
            ['id_user' => 20, 'id_semestre' => 9,  'date_inscription' => '2024-09-13 08:00:00'],
            ['id_user' => 20, 'id_semestre' => 10, 'date_inscription' => '2025-02-11 08:00:00'],
        ]);

        // ─── 10. EVALUATIONS ──────────────────────────────────────────────
        DB::table('evaluation')->insert([
            // Module 1 – Algorithmique GL S1 23-24
            ['libelle' => 'CC1 Algorithmique',           'type' => 'CC',   'date_evaluation' => '2023-10-15', 'id_module' => 1],  // id=1
            ['libelle' => 'Examen Algorithmique',         'type' => 'EXAM', 'date_evaluation' => '2024-01-20', 'id_module' => 1],  // id=2
            // Module 2 – Analyse Math GL S1 23-24
            ['libelle' => 'CC1 Analyse',                  'type' => 'CC',   'date_evaluation' => '2023-10-20', 'id_module' => 2],  // id=3
            ['libelle' => 'Examen Analyse',                'type' => 'EXAM', 'date_evaluation' => '2024-01-22', 'id_module' => 2],  // id=4
            // Module 3 – POO GL S2 23-24
            ['libelle' => 'TP1 POO',                      'type' => 'TP',   'date_evaluation' => '2024-03-10', 'id_module' => 3],  // id=5
            ['libelle' => 'Examen POO',                    'type' => 'EXAM', 'date_evaluation' => '2024-06-15', 'id_module' => 3],  // id=6
            // Module 4 – BDD GL S2 23-24
            ['libelle' => 'CC1 BDD',                      'type' => 'CC',   'date_evaluation' => '2024-03-18', 'id_module' => 4],  // id=7
            ['libelle' => 'Examen BDD',                    'type' => 'EXAM', 'date_evaluation' => '2024-06-18', 'id_module' => 4],  // id=8
            // Module 5 – Probas GL S2 23-24
            ['libelle' => 'CC1 Probas',                   'type' => 'CC',   'date_evaluation' => '2024-03-25', 'id_module' => 5],  // id=9
            ['libelle' => 'Examen Probas',                 'type' => 'EXAM', 'date_evaluation' => '2024-06-20', 'id_module' => 5],  // id=10
            // Module 6 – Dev Web 1 GL S1 24-25
            ['libelle' => 'CC1 Dev Web 1',                'type' => 'CC',   'date_evaluation' => '2024-10-18', 'id_module' => 6],  // id=11
            ['libelle' => 'Examen Dev Web 1',              'type' => 'EXAM', 'date_evaluation' => '2025-01-18', 'id_module' => 6],  // id=12
            // Module 10 – Réseaux Informatiques RT S1 23-24
            ['libelle' => 'CC1 Réseaux',                  'type' => 'CC',   'date_evaluation' => '2023-10-22', 'id_module' => 10], // id=13
            ['libelle' => 'Examen Réseaux',                'type' => 'EXAM', 'date_evaluation' => '2024-01-24', 'id_module' => 10], // id=14
            // Module 12 – Sécurité Réseaux RT S2 23-24
            ['libelle' => 'CC1 Sécurité',                 'type' => 'CC',   'date_evaluation' => '2024-03-20', 'id_module' => 12], // id=15
            ['libelle' => 'Examen Sécurité',               'type' => 'EXAM', 'date_evaluation' => '2024-06-22', 'id_module' => 12], // id=16
            // Module 17 – Intro ML IASD S1 24-25
            ['libelle' => 'CC1 Machine Learning',         'type' => 'CC',   'date_evaluation' => '2024-10-25', 'id_module' => 17], // id=17
            ['libelle' => 'Examen Machine Learning',       'type' => 'EXAM', 'date_evaluation' => '2025-01-22', 'id_module' => 17], // id=18
            // Module 18 – Stats IA IASD S1 24-25
            ['libelle' => 'CC1 Stats IA',                 'type' => 'CC',   'date_evaluation' => '2024-11-01', 'id_module' => 18], // id=19
            ['libelle' => 'Examen Stats IA',               'type' => 'EXAM', 'date_evaluation' => '2025-01-25', 'id_module' => 18], // id=20
        ]);

        // ─── 11. NOTES ────────────────────────────────────────────────────
        // GL 2023-24 S1 : modules 1 & 2 → étudiants 6,7,8,9,12,13
        // GL 2023-24 S2 : modules 3,4,5 → étudiants 6,7,8,9,12,13
        // GL 2024-25 S1 : module 6 → étudiants 6,7,8,10,11,12,13
        // RT 2023-24 S1 : module 10 → étudiants 14,15
        // RT 2023-24 S2 : module 12 → étudiants 14,15
        // IASD 2024-25 S1 : modules 17,18 → étudiants 18,19,20
        DB::table('note')->insert([
            // ── Bellatrach (6) – Algorithmique & Analyse S1 23-24
            ['id_user' => 6,  'id_evaluation' => 1,  'note' => 14.50, 'rattrapage' => null,  'note_finale' => 14.50],
            ['id_user' => 6,  'id_evaluation' => 2,  'note' => 12.00, 'rattrapage' => null,  'note_finale' => 12.00],
            ['id_user' => 6,  'id_evaluation' => 3,  'note' => 16.00, 'rattrapage' => null,  'note_finale' => 16.00],
            ['id_user' => 6,  'id_evaluation' => 4,  'note' => 09.00, 'rattrapage' => 11.00, 'note_finale' => 11.00],
            // ── Bellatrach (6) – POO, BDD, Probas S2 23-24
            ['id_user' => 6,  'id_evaluation' => 5,  'note' => 15.00, 'rattrapage' => null,  'note_finale' => 15.00],
            ['id_user' => 6,  'id_evaluation' => 6,  'note' => 13.50, 'rattrapage' => null,  'note_finale' => 13.50],
            ['id_user' => 6,  'id_evaluation' => 7,  'note' => 11.00, 'rattrapage' => null,  'note_finale' => 11.00],
            ['id_user' => 6,  'id_evaluation' => 8,  'note' => 14.00, 'rattrapage' => null,  'note_finale' => 14.00],
            ['id_user' => 6,  'id_evaluation' => 9,  'note' => 10.00, 'rattrapage' => null,  'note_finale' => 10.00],
            ['id_user' => 6,  'id_evaluation' => 10, 'note' => 12.50, 'rattrapage' => null,  'note_finale' => 12.50],
            // ── Bellatrach (6) – Dev Web 1 S1 24-25
            ['id_user' => 6,  'id_evaluation' => 11, 'note' => 17.00, 'rattrapage' => null,  'note_finale' => 17.00],
            ['id_user' => 6,  'id_evaluation' => 12, 'note' => 16.00, 'rattrapage' => null,  'note_finale' => 16.00],

            // ── Elmir (7) – S1 23-24
            ['id_user' => 7,  'id_evaluation' => 1,  'note' => 08.00, 'rattrapage' => 10.50, 'note_finale' => 10.50],
            ['id_user' => 7,  'id_evaluation' => 2,  'note' => 11.00, 'rattrapage' => null,  'note_finale' => 11.00],
            ['id_user' => 7,  'id_evaluation' => 3,  'note' => 13.00, 'rattrapage' => null,  'note_finale' => 13.00],
            ['id_user' => 7,  'id_evaluation' => 4,  'note' => 07.50, 'rattrapage' => 09.00, 'note_finale' => 09.00],
            // ── Elmir (7) – S2 23-24
            ['id_user' => 7,  'id_evaluation' => 5,  'note' => 10.00, 'rattrapage' => null,  'note_finale' => 10.00],
            ['id_user' => 7,  'id_evaluation' => 6,  'note' => 09.50, 'rattrapage' => 11.00, 'note_finale' => 11.00],
            ['id_user' => 7,  'id_evaluation' => 7,  'note' => 12.00, 'rattrapage' => null,  'note_finale' => 12.00],
            ['id_user' => 7,  'id_evaluation' => 8,  'note' => 10.00, 'rattrapage' => null,  'note_finale' => 10.00],
            ['id_user' => 7,  'id_evaluation' => 9,  'note' => 06.00, 'rattrapage' => 08.50, 'note_finale' => 08.50],
            ['id_user' => 7,  'id_evaluation' => 10, 'note' => 11.00, 'rattrapage' => null,  'note_finale' => 11.00],
            // ── Elmir (7) – Dev Web 1 S1 24-25
            ['id_user' => 7,  'id_evaluation' => 11, 'note' => 13.00, 'rattrapage' => null,  'note_finale' => 13.00],
            ['id_user' => 7,  'id_evaluation' => 12, 'note' => 14.00, 'rattrapage' => null,  'note_finale' => 14.00],

            // ── Chehlafi (8) – S1 23-24
            ['id_user' => 8,  'id_evaluation' => 1,  'note' => 18.00, 'rattrapage' => null,  'note_finale' => 18.00],
            ['id_user' => 8,  'id_evaluation' => 2,  'note' => 17.50, 'rattrapage' => null,  'note_finale' => 17.50],
            ['id_user' => 8,  'id_evaluation' => 3,  'note' => 19.00, 'rattrapage' => null,  'note_finale' => 19.00],
            ['id_user' => 8,  'id_evaluation' => 4,  'note' => 16.50, 'rattrapage' => null,  'note_finale' => 16.50],
            // ── Chehlafi (8) – S2 23-24
            ['id_user' => 8,  'id_evaluation' => 5,  'note' => 18.50, 'rattrapage' => null,  'note_finale' => 18.50],
            ['id_user' => 8,  'id_evaluation' => 6,  'note' => 17.00, 'rattrapage' => null,  'note_finale' => 17.00],
            ['id_user' => 8,  'id_evaluation' => 7,  'note' => 15.00, 'rattrapage' => null,  'note_finale' => 15.00],
            ['id_user' => 8,  'id_evaluation' => 8,  'note' => 16.00, 'rattrapage' => null,  'note_finale' => 16.00],
            // ── Chehlafi (8) – Dev Web 1 S1 24-25
            ['id_user' => 8,  'id_evaluation' => 11, 'note' => 19.00, 'rattrapage' => null,  'note_finale' => 19.00],
            ['id_user' => 8,  'id_evaluation' => 12, 'note' => 18.00, 'rattrapage' => null,  'note_finale' => 18.00],

            // ── Lamrani (9) inactive – S1 & S2 23-24 (notes quand même archivées)
            ['id_user' => 9,  'id_evaluation' => 1,  'note' => 05.00, 'rattrapage' => 07.00, 'note_finale' => 07.00],
            ['id_user' => 9,  'id_evaluation' => 2,  'note' => 06.50, 'rattrapage' => null,  'note_finale' => 06.50],
            ['id_user' => 9,  'id_evaluation' => 3,  'note' => 08.00, 'rattrapage' => null,  'note_finale' => 08.00],
            ['id_user' => 9,  'id_evaluation' => 4,  'note' => 05.50, 'rattrapage' => 06.00, 'note_finale' => 06.00],

            // ── Hamdouni (10) – Dev Web 1 S1 24-25
            ['id_user' => 10, 'id_evaluation' => 11, 'note' => 15.50, 'rattrapage' => null,  'note_finale' => 15.50],
            ['id_user' => 10, 'id_evaluation' => 12, 'note' => 14.00, 'rattrapage' => null,  'note_finale' => 14.00],

            // ── Zouheir (11) – Dev Web 1 S1 24-25
            ['id_user' => 11, 'id_evaluation' => 11, 'note' => 09.00, 'rattrapage' => 11.50, 'note_finale' => 11.50],
            ['id_user' => 11, 'id_evaluation' => 12, 'note' => 12.00, 'rattrapage' => null,  'note_finale' => 12.00],

            // ── Benkirane (12) – S1 23-24
            ['id_user' => 12, 'id_evaluation' => 1,  'note' => 11.00, 'rattrapage' => null,  'note_finale' => 11.00],
            ['id_user' => 12, 'id_evaluation' => 2,  'note' => 10.50, 'rattrapage' => null,  'note_finale' => 10.50],
            ['id_user' => 12, 'id_evaluation' => 3,  'note' => 12.00, 'rattrapage' => null,  'note_finale' => 12.00],
            ['id_user' => 12, 'id_evaluation' => 4,  'note' => 09.50, 'rattrapage' => null,  'note_finale' => 09.50],
            // ── Benkirane (12) – Dev Web 1 S1 24-25
            ['id_user' => 12, 'id_evaluation' => 11, 'note' => 13.00, 'rattrapage' => null,  'note_finale' => 13.00],
            ['id_user' => 12, 'id_evaluation' => 12, 'note' => 11.00, 'rattrapage' => null,  'note_finale' => 11.00],

            // ── Tazi Imane (13) – S1 23-24
            ['id_user' => 13, 'id_evaluation' => 1,  'note' => 13.00, 'rattrapage' => null,  'note_finale' => 13.00],
            ['id_user' => 13, 'id_evaluation' => 2,  'note' => 14.00, 'rattrapage' => null,  'note_finale' => 14.00],
            ['id_user' => 13, 'id_evaluation' => 3,  'note' => 15.00, 'rattrapage' => null,  'note_finale' => 15.00],
            ['id_user' => 13, 'id_evaluation' => 4,  'note' => 13.50, 'rattrapage' => null,  'note_finale' => 13.50],
            // ── Tazi Imane (13) – Dev Web 1 S1 24-25
            ['id_user' => 13, 'id_evaluation' => 11, 'note' => 16.00, 'rattrapage' => null,  'note_finale' => 16.00],
            ['id_user' => 13, 'id_evaluation' => 12, 'note' => 15.50, 'rattrapage' => null,  'note_finale' => 15.50],

            // ── Ouali (14) – RT S1 23-24
            ['id_user' => 14, 'id_evaluation' => 13, 'note' => 14.00, 'rattrapage' => null,  'note_finale' => 14.00],
            ['id_user' => 14, 'id_evaluation' => 14, 'note' => 13.50, 'rattrapage' => null,  'note_finale' => 13.50],
            // ── Ouali (14) – RT S2 23-24
            ['id_user' => 14, 'id_evaluation' => 15, 'note' => 15.00, 'rattrapage' => null,  'note_finale' => 15.00],
            ['id_user' => 14, 'id_evaluation' => 16, 'note' => 12.00, 'rattrapage' => null,  'note_finale' => 12.00],

            // ── Sebti (15) – RT S1 23-24
            ['id_user' => 15, 'id_evaluation' => 13, 'note' => 07.00, 'rattrapage' => 10.00, 'note_finale' => 10.00],
            ['id_user' => 15, 'id_evaluation' => 14, 'note' => 09.50, 'rattrapage' => null,  'note_finale' => 09.50],
            // ── Sebti (15) – RT S2 23-24
            ['id_user' => 15, 'id_evaluation' => 15, 'note' => 11.00, 'rattrapage' => null,  'note_finale' => 11.00],
            ['id_user' => 15, 'id_evaluation' => 16, 'note' => 08.50, 'rattrapage' => 10.50, 'note_finale' => 10.50],

            // ── Bensouda (18) – IASD S1 24-25
            ['id_user' => 18, 'id_evaluation' => 17, 'note' => 16.00, 'rattrapage' => null,  'note_finale' => 16.00],
            ['id_user' => 18, 'id_evaluation' => 18, 'note' => 15.00, 'rattrapage' => null,  'note_finale' => 15.00],
            ['id_user' => 18, 'id_evaluation' => 19, 'note' => 17.50, 'rattrapage' => null,  'note_finale' => 17.50],
            ['id_user' => 18, 'id_evaluation' => 20, 'note' => 14.00, 'rattrapage' => null,  'note_finale' => 14.00],

            // ── Filali (19) – IASD S1 24-25
            ['id_user' => 19, 'id_evaluation' => 17, 'note' => 11.00, 'rattrapage' => null,  'note_finale' => 11.00],
            ['id_user' => 19, 'id_evaluation' => 18, 'note' => 09.00, 'rattrapage' => 12.00, 'note_finale' => 12.00],
            ['id_user' => 19, 'id_evaluation' => 19, 'note' => 13.00, 'rattrapage' => null,  'note_finale' => 13.00],
            ['id_user' => 19, 'id_evaluation' => 20, 'note' => 10.50, 'rattrapage' => null,  'note_finale' => 10.50],

            // ── Rahmani (20) – IASD S1 24-25
            ['id_user' => 20, 'id_evaluation' => 17, 'note' => 14.50, 'rattrapage' => null,  'note_finale' => 14.50],
            ['id_user' => 20, 'id_evaluation' => 18, 'note' => 13.00, 'rattrapage' => null,  'note_finale' => 13.00],
            ['id_user' => 20, 'id_evaluation' => 19, 'note' => 12.00, 'rattrapage' => null,  'note_finale' => 12.00],
            ['id_user' => 20, 'id_evaluation' => 20, 'note' => 11.50, 'rattrapage' => null,  'note_finale' => 11.50],
        ]);

        // ─── 12. RECLAMATIONS ─────────────────────────────────────────────
        DB::table('reclamation')->insert([
            [
                'message'          => "Je pense qu'il y a une erreur dans ma note d'examen d'Analyse.",
                'date_reclamation' => '2024-02-01 10:30:00',
                'statut'           => 'TRAITEE',
                'id_note'          => 4,   // Bellatrach – Analyse EXAM
                'id_user'          => 6,
            ],
            [
                'message'          => "Ma note de CC Algorithmique semble incorrecte, j'avais bien répondu à la Q3.",
                'date_reclamation' => '2024-01-25 14:00:00',
                'statut'           => 'EN_ATTENTE',
                'id_note'          => 13,  // Elmir – CC1 Algo
                'id_user'          => 7,
            ],
            [
                'message'          => "Erreur de saisie sur ma note de Sécurité Réseaux, j'avais 12 et non 8.5.",
                'date_reclamation' => '2024-07-05 09:15:00',
                'statut'           => 'EN_COURS',
                'id_note'          => 63,  // Sebti – Examen Sécurité
                'id_user'          => 15,
            ],
            [
                'message'          => "Ma note d'examen ML ne reflète pas mon travail, demande de révision.",
                'date_reclamation' => '2025-02-01 11:00:00',
                'statut'           => 'EN_ATTENTE',
                'id_note'          => 66,  // Filali – Examen ML
                'id_user'          => 19,
            ],
        ]);

        // ─── 13. LOG ACTIONS ──────────────────────────────────────────────
        DB::table('log_action')->insert([
            ['action' => 'CREATE', 'table_concernee' => 'utilisateurs',  'id_enregistrement' => 6,  'id_user' => 1, 'date_action' => now()->subDays(60)],
            ['action' => 'CREATE', 'table_concernee' => 'utilisateurs',  'id_enregistrement' => 18, 'id_user' => 1, 'date_action' => now()->subDays(55)],
            ['action' => 'UPDATE', 'table_concernee' => 'notes',         'id_enregistrement' => 4,  'id_user' => 3, 'date_action' => now()->subDays(30)],
            ['action' => 'UPDATE', 'table_concernee' => 'reclamations',  'id_enregistrement' => 1,  'id_user' => 2, 'date_action' => now()->subDays(28)],
            ['action' => 'CREATE', 'table_concernee' => 'inscriptions',  'id_enregistrement' => 36, 'id_user' => 1, 'date_action' => now()->subDays(14)],
            ['action' => 'UPDATE', 'table_concernee' => 'semestre',      'id_enregistrement' => 1,  'id_user' => 2, 'date_action' => now()->subDays(10)],
            ['action' => 'UPDATE', 'table_concernee' => 'semestre',      'id_enregistrement' => 2,  'id_user' => 2, 'date_action' => now()->subDays(10)],
            ['action' => 'UPDATE', 'table_concernee' => 'notes',         'id_enregistrement' => 63, 'id_user' => 4, 'date_action' => now()->subDays(5)],
            ['action' => 'CREATE', 'table_concernee' => 'reclamations',  'id_enregistrement' => 4,  'id_user' => 19,'date_action' => now()->subDays(2)],
            ['action' => 'UPDATE', 'table_concernee' => 'utilisateurs',  'id_enregistrement' => 17, 'id_user' => 1, 'date_action' => now()->subDay()],
        ]);
    }
}