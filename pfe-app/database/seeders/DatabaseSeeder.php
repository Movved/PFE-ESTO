<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── CLEAN SLATE (ORDERED) ─────────────────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ([
            'inscrire',
            'intervenir',
            'log_action',
            'reclamation',
            'note',
            'module',
            'semestre',
            'filiere_annee', 
            'annee_academique',
            'filiere',
            'etudiant',
            'enseignant',
            'departement',
            'utilisateur'
        ] as $table) {
            DB::table($table)->delete(); 
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ─── 1. UTILISATEURS ──────────────────────────────────
        DB::table('utilisateur')->insert([
            ['nom'=>'Alaoui','prenom'=>'Karim','email'=>'a.karim@ump.ac.ma','mot_de_passe'=>Hash::make('password'),'role'=>'ADMIN','actif'=>true,'date_creation'=>now()],
            ['nom'=>'Benali','prenom'=>'Youssef','email'=>'y.benali@ump.ac.ma','mot_de_passe'=>Hash::make('password'),'role'=>'ENSEIGNANT','actif'=>true,'date_creation'=>now()],
            ['nom'=>'Cherkaoui','prenom'=>'Fatima','email'=>'f.cherkaoui@ump.ac.ma','mot_de_passe'=>Hash::make('password'),'role'=>'ENSEIGNANT','actif'=>true,'date_creation'=>now()],
            ['nom'=>'Idrissi','prenom'=>'Omar','email'=>'o.idrissi@ump.ac.ma','mot_de_passe'=>Hash::make('password'),'role'=>'ENSEIGNANT','actif'=>true,'date_creation'=>now()],
            ['nom'=>'Bellatrach','prenom'=>'Mohammed','email'=>'bellatrach.mohammed.24@ump.ac.ma','mot_de_passe'=>Hash::make('password'),'role'=>'ETUDIANT','actif'=>true,'date_creation'=>now()],
            ['nom'=>'Elmir','prenom'=>'Rayane','email'=>'elmir.rayane.24@ump.ac.ma','mot_de_passe'=>Hash::make('password'),'role'=>'ETUDIANT','actif'=>true,'date_creation'=>now()],
            ['nom'=>'Chehlafi','prenom'=>'Ibrahim','email'=>'chehlafi.ibrahim.24@ump.ac.ma','mot_de_passe'=>Hash::make('password'),'role'=>'ETUDIANT','actif'=>true,'date_creation'=>now()],
            ['nom'=>'Lamrani','prenom'=>'Nadia','email'=>'lamrani.nadia.23@ump.ac.ma','mot_de_passe'=>Hash::make('password'),'role'=>'ETUDIANT','actif'=>false,'date_creation'=>now()],
        ]);

        // ─── 2. DEPARTEMENT ───────────────────────────────────
        DB::table('departement')->insert([
            ['nom_departement'=>'Génie Informatique'],
            ['nom_departement'=>'Sciences de Base'],
            ['nom_departement'=>'Réseaux et Télécoms'],
        ]);

        // ─── 3. ENSEIGNANT ────────────────────────────────────
        DB::table('enseignant')->insert([
            ['specialite'=>'Informatique','is_chef'=>true,'id_departement'=>1,'id_user'=>2],
            ['specialite'=>'Mathématiques','is_chef'=>false,'id_departement'=>2,'id_user'=>3],
            ['specialite'=>'Réseaux et Systèmes','is_chef'=>false,'id_departement'=>3,'id_user'=>4],
        ]);

        // ─── 4. ETUDIANT ──────────────────────────────────────
        DB::table('etudiant')->insert([
            ['cne'=>'G110023001','id_user'=>5],
            ['cne'=>'G110023002','id_user'=>6],
            ['cne'=>'G110023003','id_user'=>7],
            ['cne'=>'G110023004','id_user'=>8],
        ]);

        // ─── 5. FILIERE ───────────────────────────────────────
        DB::table('filiere')->insert([
            ['nom_filiere'=>'Conception et Développement des Logiciels','description'=>'Formation en développement logiciel et architecture.','id_departement'=>1],
            ['nom_filiere'=>'Réseaux Sécurité et Télécoms','description'=>'Formation en réseaux, sécurité et télécommunications.','id_departement'=>3],
        ]);

        // ─── 6. ANNEE ACADEMIQUE ──────────────────────────────
        DB::table('annee_academique')->insert([
            ['libelle'=>'2023-2024'],
            ['libelle'=>'2024-2025'],
        ]);

        // ─── 7. FILIERE_ANNEE (NEW) ───────────────────────────
        DB::table('filiere_annee')->insert([
            ['id_filiere'=>1,'id_annee'=>1],
            ['id_filiere'=>1,'id_annee'=>2],
            ['id_filiere'=>2,'id_annee'=>2],
        ]);

        // ─── 8. SEMESTRE (WITH FILIERE) ───────────────────────
        DB::table('semestre')->insert([
            ['numero'=>1,'cloture'=>true,'id_annee'=>1,'id_filiere'=>1],
            ['numero'=>2,'cloture'=>true,'id_annee'=>1,'id_filiere'=>1],
            ['numero'=>1,'cloture'=>false,'id_annee'=>2,'id_filiere'=>1],
            ['numero'=>1,'cloture'=>false,'id_annee'=>2,'id_filiere'=>2],
        ]);

        // ─── 9. MODULE ────────────────────────────────────────
        DB::table('module')->insert([
            ['code_module'=>'INF101','nom_module'=>'Algorithmique','id_semestre'=>1,'id_enseignant'=>1],
            ['code_module'=>'MAT101','nom_module'=>'Analyse Mathématique','id_semestre'=>1,'id_enseignant'=>2],
            ['code_module'=>'INF201','nom_module'=>'OOP C++','id_semestre'=>2,'id_enseignant'=>1],
            ['code_module'=>'INF202','nom_module'=>'Base de Données MySQL','id_semestre'=>2,'id_enseignant'=>1],
            ['code_module'=>'INF301','nom_module'=>'Développement Web 1','id_semestre'=>3,'id_enseignant'=>1],
            ['code_module'=>'RES101','nom_module'=>'Réseaux Informatiques','id_semestre'=>4,'id_enseignant'=>3],
        ]);

        // ─── 10. INTERVENIR ───────────────────────────────────
        DB::table('intervenir')->insert([
            ['id_enseignant'=>2,'id_module'=>1],
            ['id_enseignant'=>3,'id_module'=>6],
        ]);

        // ─── 11. INSCRIRE ─────────────────────────────────────
        DB::table('inscrire')->insert([
            ['id_etudiant'=>1,'id_semestre'=>1],
            ['id_etudiant'=>1,'id_semestre'=>2],
            ['id_etudiant'=>2,'id_semestre'=>1],
            ['id_etudiant'=>2,'id_semestre'=>2],
            ['id_etudiant'=>3,'id_semestre'=>3],
            ['id_etudiant'=>4,'id_semestre'=>4],
        ]);

        // ─── 12. NOTE ─────────────────────────────────────────
        DB::table('note')->insert([
            ['id_etudiant'=>1,'id_module'=>1,'note'=>14.50,'rattrapage'=>null],
            ['id_etudiant'=>1,'id_module'=>2,'note'=>12.00,'rattrapage'=>null],
            ['id_etudiant'=>1,'id_module'=>3,'note'=>16.00,'rattrapage'=>null],
            ['id_etudiant'=>1,'id_module'=>4,'note'=>9.00, 'rattrapage'=>11.00],
            ['id_etudiant'=>2,'id_module'=>1,'note'=>8.00, 'rattrapage'=>10.50],
            ['id_etudiant'=>2,'id_module'=>2,'note'=>11.00,'rattrapage'=>null],
            ['id_etudiant'=>2,'id_module'=>3,'note'=>13.00,'rattrapage'=>null],
            ['id_etudiant'=>2,'id_module'=>4,'note'=>7.50, 'rattrapage'=>9.00],
        ]);

        // ─── 13. RECLAMATION (WITH STATUT) ────────────────────
        DB::table('reclamation')->insert([
            ['message'=>"Erreur possible sur ma note de BDD.",'date_reclamation'=>'2024-02-01 10:30:00','statut'=>'en_attente','id_note'=>4],
            ['message'=>"Ma note CC Algorithmique semble incorrecte.",'date_reclamation'=>'2024-01-25 14:00:00','statut'=>'en_attente','id_note'=>5],
        ]);

        // ─── 14. LOG ACTION ───────────────────────────────────
        DB::table('log_action')->insert([
            ['action'=>'CREATE','table_concernee'=>'etudiants','id_enregistrement'=>1,'id_user'=>1,'date_action'=>now()],
            ['action'=>'UPDATE','table_concernee'=>'notes','id_enregistrement'=>4,'id_user'=>2,'date_action'=>now()],
            ['action'=>'UPDATE','table_concernee'=>'reclamations','id_enregistrement'=>1,'id_user'=>2,'date_action'=>now()],
            ['action'=>'CREATE','table_concernee'=>'inscrire','id_enregistrement'=>5,'id_user'=>1,'date_action'=>now()],
        ]);
    }
}