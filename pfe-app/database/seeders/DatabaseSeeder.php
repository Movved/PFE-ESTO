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
        // Disable FK checks so we can truncate tables with relationships safely
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ([
            'inscrire', 'intervenir', 'log_action', 'reclamation',
            'note', 'module', 'semestre', 'annee_academique',
            'filiere', 'etudiant', 'enseignant', 'departement', 'utilisateur'
        ] as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ═══════════════════════════════════════════════════════════════════
        // 1. UTILISATEURS
        // ═══════════════════════════════════════════════════════════════════
        DB::table('utilisateur')->insert([

            // ── ADMIN ──────────────────────────────────────────────────────
            ['nom' => 'Alaoui',      'prenom' => 'Karim',       'email' => 'a.karim@ump.ac.ma',                    'mot_de_passe' => Hash::make('password'), 'role' => 'ADMIN',      'actif' => true, 'date_creation' => now()],
            // id_user 1 = Admin Alaoui

            // ── ENSEIGNANTS — Département 1 : Génie Informatique (10 profs) ──
            ['nom' => 'Serghini',    'prenom' => 'Abdelhafid',  'email' => 'a.serghini@ump.ac.ma',                 'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 2 — Chef du département Génie Informatique
            ['nom' => 'Berrahal',    'prenom' => 'Mohammed',    'email' => 'm.berrahal@ump.ac.ma',                 'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 3
            ['nom' => 'Khriss',      'prenom' => 'Abdelaadim',  'email' => 'a.khriss@ump.ac.ma',                   'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 4
            ['nom' => 'Brahim',      'prenom' => 'Sara',        'email' => 's.brahim@ump.ac.ma',                   'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 5
            ['nom' => 'Elbeqqal',    'prenom' => 'Mohamed',     'email' => 'm.elbeqqal@ump.ac.ma',                 'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 6
            ['nom' => 'Mokhtari',    'prenom' => 'Anas',        'email' => 'a.mokhtari@ump.ac.ma',                 'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 7
            ['nom' => 'Idrissi',     'prenom' => 'Youssef',     'email' => 'y.idrissi@ump.ac.ma',                  'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 8
            ['nom' => 'Amine',       'prenom' => 'Khalid',      'email' => 'k.amine@ump.ac.ma',                    'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 9
            ['nom' => 'Benali',      'prenom' => 'Soufiane',    'email' => 's.benali@ump.ac.ma',                   'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 10
            ['nom' => 'Zaki',        'prenom' => 'Hamid',       'email' => 'h.zaki@ump.ac.ma',                     'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 11

            // ── ENSEIGNANTS — Département 2 : Management (10 profs) ───────
            ['nom' => 'Eljay',       'prenom' => 'Fadoua',      'email' => 'f.eljay@ump.ac.ma',                    'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 12 — Chef du département Management
            ['nom' => 'Missaoui',    'prenom' => 'Khadija',     'email' => 'k.missaoui@ump.ac.ma',                 'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 13
            ['nom' => 'Oulahyane',   'prenom' => 'Ayoub',       'email' => 'a.oulahyane@ump.ac.ma',                'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 14
            ['nom' => 'Boussalam',   'prenom' => 'Issam',       'email' => 'i.boussalam@ump.ac.ma',                'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 15
            ['nom' => 'Arfaoui',     'prenom' => 'Wafae',       'email' => 'w.arfaoui@ump.ac.ma',                  'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 16
            ['nom' => 'Elhila',      'prenom' => 'Rachid',      'email' => 'r.elhila@ump.ac.ma',                   'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 17
            ['nom' => 'Chaanoun',    'prenom' => 'Jihane',      'email' => 'j.chaanoun@ump.ac.ma',                 'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 18
            ['nom' => 'Radi',        'prenom' => 'Nadia',       'email' => 'n.radi@ump.ac.ma',                     'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 19
            ['nom' => 'Tazi',        'prenom' => 'Omar',        'email' => 'o.tazi@ump.ac.ma',                     'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 20
            ['nom' => 'Benomar',     'prenom' => 'Laila',       'email' => 'l.benomar@ump.ac.ma',                  'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 21

            // ── ENSEIGNANTS — Département 3 : Génie Appliqué (10 profs) ───
            ['nom' => 'Qodad',       'prenom' => 'Oumnia',      'email' => 'o.qodad@ump.ac.ma',                    'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 22 — Chef du département Génie Appliqué
            ['nom' => 'Hana',        'prenom' => 'Khadija',     'email' => 'k.hana@ump.ac.ma',                     'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 23
            ['nom' => 'Filali',      'prenom' => 'Hassan',      'email' => 'h.filali@ump.ac.ma',                   'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 24
            ['nom' => 'Tahiri',      'prenom' => 'Kaoutar',     'email' => 'k.tahiri@ump.ac.ma',                   'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 25
            ['nom' => 'Ouali',       'prenom' => 'Driss',       'email' => 'd.ouali@ump.ac.ma',                    'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 26
            ['nom' => 'Mrani',       'prenom' => 'Fatima',      'email' => 'f.mrani@ump.ac.ma',                    'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 27
            ['nom' => 'Boukhris',    'prenom' => 'Samir',       'email' => 's.boukhris@ump.ac.ma',                 'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 28
            ['nom' => 'Cherkaoui',   'prenom' => 'Imane',       'email' => 'i.cherkaoui@ump.ac.ma',                'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 29
            ['nom' => 'Benyahia',    'prenom' => 'Reda',        'email' => 'r.benyahia@ump.ac.ma',                 'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 30
            ['nom' => 'Sabri',       'prenom' => 'Meriem',      'email' => 'm.sabri@ump.ac.ma',                    'mot_de_passe' => Hash::make('password'), 'role' => 'ENSEIGNANT', 'actif' => true, 'date_creation' => now()],
            // id_user 31

            // ── ÉTUDIANTS — CDL ───────────────────────────────────────────
            ['nom' => 'Bellatrach',  'prenom' => 'Mohammed',    'email' => 'bellatrach.mohammed.24@ump.ac.ma',     'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user 32
            ['nom' => 'Elmir',       'prenom' => 'Rayane',      'email' => 'elmir.rayane.24@ump.ac.ma',            'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user 33
            ['nom' => 'Chehlafi',    'prenom' => 'Ibrahim',     'email' => 'chehlafi.ibrahim.24@ump.ac.ma',        'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user 34
            ['nom' => 'Lamrani',     'prenom' => 'Nadia',       'email' => 'lamrani.nadia.23@ump.ac.ma',           'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => false, 'date_creation' => now()],
            // id_user 35 (inactive)
            ['nom' => 'Belhit',      'prenom' => 'Abdelhak',    'email' => 'belhite.abdelhak.23@ump.ac.ma',        'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user 36
            ['nom' => 'Khaldi',      'prenom' => 'Mohammed',    'email' => 'khaldi.mohammed.23@ump.ac.ma',         'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user 37
            ['nom' => 'Abarkani',    'prenom' => 'Nassim',      'email' => 'abarkani.nassim.23@ump.ac.ma',         'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user 38
            ['nom' => 'Eddahem',     'prenom' => 'Reda',        'email' => 'eddahem.reda.23@ump.ac.ma',            'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => false, 'date_creation' => now()],
            // id_user 39 (inactive)

            // ── ÉTUDIANTS — IDIA ──────────────────────────────────────────
            ['nom' => 'Kamal',       'prenom' => 'Yassine',     'email' => 'kamal.yassine.24@ump.ac.ma',           'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user 40
            ['nom' => 'Nadir',       'prenom' => 'Salma',       'email' => 'nadir.salma.24@ump.ac.ma',             'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user 41
            ['nom' => 'Alami',       'prenom' => 'Hamza',       'email' => 'alami.hamza.24@ump.ac.ma',             'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user 42
            ['nom' => 'Senhaji',     'prenom' => 'Meryem',      'email' => 'senhaji.meryem.23@ump.ac.ma',          'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user 43
            ['nom' => 'Haddad',      'prenom' => 'Anas',        'email' => 'haddad.anas.23@ump.ac.ma',             'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => false, 'date_creation' => now()],
            // id_user 44 (inactive)

            // ── ÉTUDIANTS — Web Design ────────────────────────────────────
            ['nom' => 'Ouahbi',      'prenom' => 'Chaymae',     'email' => 'ouahbi.chaymae.24@ump.ac.ma',          'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user 45
            ['nom' => 'Lazrak',      'prenom' => 'Ilyas',       'email' => 'lazrak.ilyas.24@ump.ac.ma',            'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user 46
            ['nom' => 'Ghazali',     'prenom' => 'Rim',         'email' => 'ghazali.rim.23@ump.ac.ma',             'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => true,  'date_creation' => now()],
            // id_user 47
            ['nom' => 'Mekki',       'prenom' => 'Zakaria',     'email' => 'mekki.zakaria.23@ump.ac.ma',           'mot_de_passe' => Hash::make('password'), 'role' => 'ETUDIANT',   'actif' => false, 'date_creation' => now()],
            // id_user 48 (inactive)
        ]);

        /*
        ┌─────────────────────────────────────────────────────────────────────┐
        │ RÉCAPITULATIF id_user                                               │
        │  1  = Admin Alaoui                                                  │
        │  ── Génie Informatique (Dept 1) ──                                  │
        │  2  = Serghini (chef)   6  = Mokhtari  10 = Zaki                   │
        │  3  = Berrahal          7  = Idrissi   11 = (Mokhtari alias→Zaki)  │
        │  4  = Khriss            8  = Amine                                  │
        │  5  = Brahim Sara       9  = Benali                                 │
        │  ── Management (Dept 2) ──                                          │
        │ 12  = Eljay (chef)     17 = Elhila     21 = Benomar                 │
        │ 13  = Missaoui         18 = Chaanoun                                │
        │ 14  = Oulahyane        19 = Radi                                    │
        │ 15  = Boussalam        20 = Tazi                                    │
        │ 16  = Arfaoui                                                       │
        │  ── Génie Appliqué (Dept 3) ──                                      │
        │ 22  = Qodad (chef)     27 = Mrani      31 = Sabri                   │
        │ 23  = Hana             28 = Boukhris                                │
        │ 24  = Filali           29 = Cherkaoui                               │
        │ 25  = Tahiri           30 = Benyahia                                │
        │ 26  = Ouali                                                         │
        │  ── Étudiants CDL ──                                                │
        │ 32=Bellatrach  35=Lamrani(off)  38=Abarkani                         │
        │ 33=Elmir       36=Belhit        39=Eddahem(off)                     │
        │ 34=Chehlafi    37=Khaldi                                             │
        │  ── Étudiants IDIA ──                                               │
        │ 40=Kamal  41=Nadir  42=Alami  43=Senhaji  44=Haddad(off)            │
        │  ── Étudiants Web Design ──                                         │
        │ 45=Ouahbi  46=Lazrak  47=Ghazali  48=Mekki(off)                     │
        └─────────────────────────────────────────────────────────────────────┘
        */

        // ═══════════════════════════════════════════════════════════════════
        // 2. DÉPARTEMENTS
        // ═══════════════════════════════════════════════════════════════════
        DB::table('departement')->insert([
            ['nom_departement' => 'Génie Informatique'],  // id_departement 1
            ['nom_departement' => 'Management'],           // id_departement 2
            ['nom_departement' => 'Génie Appliqué'],       // id_departement 3
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 3. ENSEIGNANTS
        // ═══════════════════════════════════════════════════════════════════
        DB::table('enseignant')->insert([

            // ── Génie Informatique — id_departement 1 ─────────────────────
            ['specialite' => 'Génie Logiciel',             'is_chef' => true,  'id_departement' => 1, 'id_user' => 2],   // id_enseignant 1  — Serghini (CHEF)
            ['specialite' => 'Intelligence Artificielle',  'is_chef' => false, 'id_departement' => 1, 'id_user' => 3],   // id_enseignant 2  — Berrahal
            ['specialite' => 'Réseaux et Sécurité',        'is_chef' => false, 'id_departement' => 1, 'id_user' => 4],   // id_enseignant 3  — Khriss
            ['specialite' => 'Langues et Communication',   'is_chef' => false, 'id_departement' => 1, 'id_user' => 5],   // id_enseignant 4  — Brahim Sara
            ['specialite' => 'Bases de Données',           'is_chef' => false, 'id_departement' => 1, 'id_user' => 6],   // id_enseignant 5  — Elbeqqal
            ['specialite' => 'Développement Web',          'is_chef' => false, 'id_departement' => 1, 'id_user' => 7],   // id_enseignant 6  — Mokhtari
            ['specialite' => 'Systèmes Embarqués',         'is_chef' => false, 'id_departement' => 1, 'id_user' => 8],   // id_enseignant 7  — Idrissi
            ['specialite' => 'Algorithmique',              'is_chef' => false, 'id_departement' => 1, 'id_user' => 9],   // id_enseignant 8  — Amine
            ['specialite' => 'Architecture des Systèmes',  'is_chef' => false, 'id_departement' => 1, 'id_user' => 10],  // id_enseignant 9  — Benali
            ['specialite' => 'Mathématiques Appliquées',   'is_chef' => false, 'id_departement' => 1, 'id_user' => 11],  // id_enseignant 10 — Zaki

            // ── Management — id_departement 2 ─────────────────────────────
            ['specialite' => 'Marketing et Commerce',      'is_chef' => true,  'id_departement' => 2, 'id_user' => 12],  // id_enseignant 11 — Eljay (CHEF)
            ['specialite' => 'Économie et Gestion',        'is_chef' => false, 'id_departement' => 2, 'id_user' => 13],  // id_enseignant 12 — Missaoui
            ['specialite' => 'Droit des Entreprises',      'is_chef' => false, 'id_departement' => 2, 'id_user' => 14],  // id_enseignant 13 — Oulahyane
            ['specialite' => 'Finance et Comptabilité',    'is_chef' => false, 'id_departement' => 2, 'id_user' => 15],  // id_enseignant 14 — Boussalam
            ['specialite' => 'Systèmes d\'Information',    'is_chef' => false, 'id_departement' => 2, 'id_user' => 16],  // id_enseignant 15 — Arfaoui
            ['specialite' => 'Langues et Communication',   'is_chef' => false, 'id_departement' => 2, 'id_user' => 17],  // id_enseignant 16 — Elhila
            ['specialite' => 'Ressources Humaines',        'is_chef' => false, 'id_departement' => 2, 'id_user' => 18],  // id_enseignant 17 — Chaanoun
            ['specialite' => 'Fiscalité et Audit',         'is_chef' => false, 'id_departement' => 2, 'id_user' => 19],  // id_enseignant 18 — Radi
            ['specialite' => 'Business Intelligence',      'is_chef' => false, 'id_departement' => 2, 'id_user' => 20],  // id_enseignant 19 — Tazi
            ['specialite' => 'E-Commerce et Digital',      'is_chef' => false, 'id_departement' => 2, 'id_user' => 21],  // id_enseignant 20 — Benomar

            // ── Génie Appliqué — id_departement 3 ────────────────────────
            ['specialite' => 'Électrotechnique',           'is_chef' => true,  'id_departement' => 3, 'id_user' => 22],  // id_enseignant 21 — Qodad (CHEF)
            ['specialite' => 'Énergies Renouvelables',     'is_chef' => false, 'id_departement' => 3, 'id_user' => 23],  // id_enseignant 22 — Hana
            ['specialite' => 'Mécatronique',               'is_chef' => false, 'id_departement' => 3, 'id_user' => 24],  // id_enseignant 23 — Filali
            ['specialite' => 'Automatisme Industriel',     'is_chef' => false, 'id_departement' => 3, 'id_user' => 25],  // id_enseignant 24 — Tahiri
            ['specialite' => 'Génie Civil',                'is_chef' => false, 'id_departement' => 3, 'id_user' => 26],  // id_enseignant 25 — Ouali
            ['specialite' => 'Conception Mécanique',       'is_chef' => false, 'id_departement' => 3, 'id_user' => 27],  // id_enseignant 26 — Mrani
            ['specialite' => 'Technologies Automobiles',   'is_chef' => false, 'id_departement' => 3, 'id_user' => 28],  // id_enseignant 27 — Boukhris
            ['specialite' => 'Thermodynamique',            'is_chef' => false, 'id_departement' => 3, 'id_user' => 29],  // id_enseignant 28 — Cherkaoui
            ['specialite' => 'Prototypage et Fabrication', 'is_chef' => false, 'id_departement' => 3, 'id_user' => 30],  // id_enseignant 29 — Benyahia
            ['specialite' => 'Mathématiques Appliquées',   'is_chef' => false, 'id_departement' => 3, 'id_user' => 31],  // id_enseignant 30 — Sabri
        ]);

        /*
        ┌─────────────────────────────────────────────────────────────────────┐
        │ RÉCAPITULATIF id_enseignant                                         │
        │  Génie Informatique (Dept 1)                                        │
        │   1=Serghini(chef)  4=Brahim    7=Idrissi   10=Zaki                 │
        │   2=Berrahal        5=Elbeqqal  8=Amine                             │
        │   3=Khriss          6=Mokhtari  9=Benali                            │
        │  Management (Dept 2)                                                │
        │  11=Eljay(chef)  13=Oulahyane  15=Arfaoui  17=Chaanoun  19=Tazi    │
        │  12=Missaoui     14=Boussalam  16=Elhila   18=Radi       20=Benomar │
        │  Génie Appliqué (Dept 3)                                            │
        │  21=Qodad(chef)  23=Filali  25=Ouali   27=Boukhris  29=Benyahia    │
        │  22=Hana         24=Tahiri  26=Mrani   28=Cherkaoui 30=Sabri       │
        └─────────────────────────────────────────────────────────────────────┘
        */

        // ═══════════════════════════════════════════════════════════════════
        // 4. ÉTUDIANTS
        // ═══════════════════════════════════════════════════════════════════
        DB::table('etudiant')->insert([
            // CDL
            ['cne' => 'G110024001', 'id_user' => 32],  // id_etudiant 1  — Bellatrach
            ['cne' => 'G110024002', 'id_user' => 33],  // id_etudiant 2  — Elmir
            ['cne' => 'G110024003', 'id_user' => 34],  // id_etudiant 3  — Chehlafi
            ['cne' => 'G110023004', 'id_user' => 35],  // id_etudiant 4  — Lamrani (inactive)
            ['cne' => 'G110023005', 'id_user' => 36],  // id_etudiant 5  — Belhit
            ['cne' => 'G110023006', 'id_user' => 37],  // id_etudiant 6  — Khaldi
            ['cne' => 'G110023007', 'id_user' => 38],  // id_etudiant 7  — Abarkani
            ['cne' => 'G110023008', 'id_user' => 39],  // id_etudiant 8  — Eddahem (inactive)
            // IDIA
            ['cne' => 'G110024009', 'id_user' => 40],  // id_etudiant 9  — Kamal
            ['cne' => 'G110024010', 'id_user' => 41],  // id_etudiant 10 — Nadir
            ['cne' => 'G110024011', 'id_user' => 42],  // id_etudiant 11 — Alami
            ['cne' => 'G110023012', 'id_user' => 43],  // id_etudiant 12 — Senhaji
            ['cne' => 'G110023013', 'id_user' => 44],  // id_etudiant 13 — Haddad (inactive)
            // Web Design
            ['cne' => 'G110024014', 'id_user' => 45],  // id_etudiant 14 — Ouahbi
            ['cne' => 'G110024015', 'id_user' => 46],  // id_etudiant 15 — Lazrak
            ['cne' => 'G110023016', 'id_user' => 47],  // id_etudiant 16 — Ghazali
            ['cne' => 'G110023017', 'id_user' => 48],  // id_etudiant 17 — Mekki (inactive)
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 5. FILIERES
        // ═══════════════════════════════════════════════════════════════════
        DB::table('filiere')->insert([
            // ── Génie Informatique (id_departement 1) ─────────────────────
            ['nom_filiere' => 'Conception et Développement des Logiciels',          'description' => 'Formation en développement logiciel et architecture.',                                    'id_departement' => 1],  // id_filiere 1
            ['nom_filiere' => 'Informatique Décisionnelle et Intelligence Artificielle', 'description' => 'Formation en science des données et intelligence artificielle.',                    'id_departement' => 1],  // id_filiere 2
            ['nom_filiere' => 'Web Design et Marketing Digital',                    'description' => 'Formation pour créer des sites web professionnels et design graphique.',                 'id_departement' => 1],  // id_filiere 3
            ['nom_filiere' => 'Génie Informatique Embarquée',                       'description' => 'Formation en systèmes embarqués, IoT et programmation bas-niveau.',                     'id_departement' => 1],  // id_filiere 4
            ['nom_filiere' => "Système d'Information et Ingénierie de Données",     'description' => 'Formation en architecture des SI, Big Data et ingénierie des données.',                 'id_departement' => 1],  // id_filiere 5
            // ── Management (id_departement 2) ─────────────────────────────
            ['nom_filiere' => 'Informatique et Gestion des Entreprises (IGE)',       'description' => 'Formation combinant informatique et gestion pour répondre aux besoins des entreprises.','id_departement' => 2],  // id_filiere 6
            ['nom_filiere' => 'Informatique et Gestion des Entreprises (BIGE)',      'description' => "Formation en informatique appliquée à la gestion avancée des entreprises.",             'id_departement' => 2],  // id_filiere 7
            ['nom_filiere' => 'Finance, Comptabilité et Fiscalité (FCF)',            'description' => 'Formation en gestion financière, comptabilité et fiscalité des organisations.',         'id_departement' => 2],  // id_filiere 8
            ['nom_filiere' => 'Marketing et E-Commerce (MEEC)',                     'description' => 'Formation en stratégies marketing, commerce électronique et médias sociaux.',           'id_departement' => 2],  // id_filiere 9
            ['nom_filiere' => "Finance d'Entreprises et Business Intelligence (BFEBI)",'description' => 'Formation en finance avancée, analyse de données décisionnelles et BI.',            'id_departement' => 2],  // id_filiere 10
            // ── Génie Appliqué (id_departement 3) ────────────────────────
            ['nom_filiere' => 'Électrotechnique et Énergies Renouvelables',          'description' => 'Formation en systèmes électriques et technologies des énergies renouvelables.',        'id_departement' => 3],  // id_filiere 11
            ['nom_filiere' => 'Mécatronique Industrielle',                           'description' => 'Formation en automatisation industrielle combinant mécanique, électronique et info.',  'id_departement' => 3],  // id_filiere 12
            ['nom_filiere' => 'Technologie Automobile',                              'description' => 'Formation en diagnostic, maintenance et technologies des véhicules modernes.',         'id_departement' => 3],  // id_filiere 13
            ['nom_filiere' => 'Conception et Prototypage Industriel',                'description' => 'Formation en CAO, prototypage rapide et fabrication industrielle.',                    'id_departement' => 3],  // id_filiere 14
            ['nom_filiere' => 'Génie Civil et Efficacité Energétique (BGCEE)',       'description' => 'Formation en construction durable, gestion de chantier et efficacité énergétique.',   'id_departement' => 3],  // id_filiere 15
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 6. ANNÉES ACADÉMIQUES
        // ═══════════════════════════════════════════════════════════════════
        // FIX: la migration exige id_filiere NOT NULL, donc on crée une entrée
        //      par filière (comme dans le seeder original).
        //      2023-2024 : seules les 3 premières filieres Génie Informatique étaient actives.
        //      2024-2025 : toutes les 15 filieres sont actives.
        DB::table('annee_academique')->insert([
            // ── 2023-2024 ─────────────────────────────────────────────────
            ['libelle' => '2023-2024', 'id_filiere' => 1],   // id_annee 1  — CDL
            ['libelle' => '2023-2024', 'id_filiere' => 2],   // id_annee 2  — IDIA
            ['libelle' => '2023-2024', 'id_filiere' => 3],   // id_annee 3  — Web Design
            // ── 2024-2025 — Génie Informatique ───────────────────────────
            ['libelle' => '2024-2025', 'id_filiere' => 1],   // id_annee 4  — CDL
            ['libelle' => '2024-2025', 'id_filiere' => 2],   // id_annee 5  — IDIA
            ['libelle' => '2024-2025', 'id_filiere' => 3],   // id_annee 6  — Web Design
            ['libelle' => '2024-2025', 'id_filiere' => 4],   // id_annee 7  — GIE Embarquée
            ['libelle' => '2024-2025', 'id_filiere' => 5],   // id_annee 8  — SIID
            // ── 2024-2025 — Management ────────────────────────────────────
            ['libelle' => '2024-2025', 'id_filiere' => 6],   // id_annee 9  — IGE
            ['libelle' => '2024-2025', 'id_filiere' => 7],   // id_annee 10 — BIGE
            ['libelle' => '2024-2025', 'id_filiere' => 8],   // id_annee 11 — FCF
            ['libelle' => '2024-2025', 'id_filiere' => 9],   // id_annee 12 — MEEC
            ['libelle' => '2024-2025', 'id_filiere' => 10],  // id_annee 13 — BFEBI
            // ── 2024-2025 — Génie Appliqué ───────────────────────────────
            ['libelle' => '2024-2025', 'id_filiere' => 11],  // id_annee 14 — EER
            ['libelle' => '2024-2025', 'id_filiere' => 12],  // id_annee 15 — MI
            ['libelle' => '2024-2025', 'id_filiere' => 13],  // id_annee 16 — TA
            ['libelle' => '2024-2025', 'id_filiere' => 14],  // id_annee 17 — CPI
            ['libelle' => '2024-2025', 'id_filiere' => 15],  // id_annee 18 — BGCEE
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 7. SEMESTRES
        // ═══════════════════════════════════════════════════════════════════
        // Règle : S1 et S3 clôturés, S2 et S4 ouverts.
        // On crée les semestres pour les filieres actives en 2023-2024 (annees 1-3)
        // et pour CDL/IDIA/WebDesign en 2024-2025 (annees 4-6) qui ont des étudiants.
        // Les autres filieres 2024-2025 partagent les mêmes semestres numérotés.
        DB::table('semestre')->insert([
            // 2023-2024 — CDL (id_annee 1)
            ['numero' => 1, 'cloture' => true,  'id_annee' => 1],  // id_semestre 1  — S1 CDL 2023-24 (clôturé)
            ['numero' => 2, 'cloture' => false, 'id_annee' => 1],  // id_semestre 2  — S2 CDL 2023-24 (ouvert)
            // 2023-2024 — IDIA (id_annee 2)
            ['numero' => 1, 'cloture' => true,  'id_annee' => 2],  // id_semestre 3  — S1 IDIA 2023-24 (clôturé)
            ['numero' => 2, 'cloture' => false, 'id_annee' => 2],  // id_semestre 4  — S2 IDIA 2023-24 (ouvert)
            // 2023-2024 — Web Design (id_annee 3)
            ['numero' => 1, 'cloture' => true,  'id_annee' => 3],  // id_semestre 5  — S1 WD 2023-24 (clôturé)
            ['numero' => 2, 'cloture' => false, 'id_annee' => 3],  // id_semestre 6  — S2 WD 2023-24 (ouvert)
            // 2024-2025 — CDL (id_annee 4)
            ['numero' => 3, 'cloture' => true,  'id_annee' => 4],  // id_semestre 7  — S3 CDL 2024-25 (clôturé)
            ['numero' => 4, 'cloture' => false, 'id_annee' => 4],  // id_semestre 8  — S4 CDL 2024-25 (ouvert)
        ]);

        /*
        ┌─────────────────────────────────────────────────────────────────────┐
        │ RÉCAPITULATIF id_semestre                                           │
        │  1 = S1 CDL 2023-24 (clôturé)    5 = S1 WD  2023-24 (clôturé)     │
        │  2 = S2 CDL 2023-24 (ouvert)     6 = S2 WD  2023-24 (ouvert)      │
        │  3 = S1 IDIA 2023-24 (clôturé)   7 = S3 CDL 2024-25 (clôturé)     │
        │  4 = S2 IDIA 2023-24 (ouvert)    8 = S4 CDL 2024-25 (ouvert)      │
        └─────────────────────────────────────────────────────────────────────┘
        */

        // ═══════════════════════════════════════════════════════════════════
        // 8. MODULES
        // ═══════════════════════════════════════════════════════════════════
        DB::table('module')->insert([

            // ── CDL — S1 (id_semestre 1, clôturé) ────────────────────────
            ['code_module' => 'CDL-S1-M1', 'nom_module' => 'Algèbre',                                               'id_semestre' => 1,  'id_enseignant' => 10],  // id_module 1
            ['code_module' => 'CDL-S1-M2', 'nom_module' => "Introduction à l'Intelligence Artificielle",            'id_semestre' => 1,  'id_enseignant' => 2],   // id_module 2
            ['code_module' => 'CDL-S1-M3', 'nom_module' => "Système d'Information et Bases de Données",             'id_semestre' => 1,  'id_enseignant' => 5],   // id_module 3
            ['code_module' => 'CDL-S1-M4', 'nom_module' => 'Développement Web : Front End',                         'id_semestre' => 1,  'id_enseignant' => 3],   // id_module 4
            ['code_module' => 'CDL-S1-M5', 'nom_module' => 'Probabilités, Statistiques et Analyse de Données',      'id_semestre' => 1,  'id_enseignant' => 6],   // id_module 5
            ['code_module' => 'CDL-S1-M6', 'nom_module' => 'Structures de Données : Algorithmique Avancée et C',    'id_semestre' => 1,  'id_enseignant' => 1],   // id_module 6
            ['code_module' => 'CDL-S1-M7', 'nom_module' => 'Français',                                              'id_semestre' => 1,  'id_enseignant' => 4],   // id_module 7

            // ── CDL — S2 (id_semestre 2, ouvert) ─────────────────────────
            ['code_module' => 'CDL-S2-M1', 'nom_module' => 'Technologie .NET',                                      'id_semestre' => 2,  'id_enseignant' => 5],   // id_module 8
            ['code_module' => 'CDL-S2-M2', 'nom_module' => 'Programmation Python',                                  'id_semestre' => 2,  'id_enseignant' => 6],   // id_module 9
            ['code_module' => 'CDL-S2-M3', 'nom_module' => 'Communication et Développement Personnel',              'id_semestre' => 2,  'id_enseignant' => 4],   // id_module 10
            ['code_module' => 'CDL-S2-M4', 'nom_module' => 'JEE et Programmation Mobile',                           'id_semestre' => 2,  'id_enseignant' => 2],   // id_module 11

            // ── IDIA — S1 (id_semestre 3, clôturé) ───────────────────────
            ['code_module' => 'IDIA-S1-M1','nom_module' => 'Algorithmes de Machine Learning',                       'id_semestre' => 3, 'id_enseignant' => 2],   // id_module 12
            ['code_module' => 'IDIA-S1-M2','nom_module' => "Introduction à l'Intelligence Artificielle",            'id_semestre' => 3, 'id_enseignant' => 2],   // id_module 13
            ['code_module' => 'IDIA-S1-M3','nom_module' => 'Programmation Python',                                  'id_semestre' => 3, 'id_enseignant' => 6],   // id_module 14
            ['code_module' => 'IDIA-S1-M4','nom_module' => 'Mathématiques 2 : Algèbre Linéaire',                    'id_semestre' => 3, 'id_enseignant' => 10],  // id_module 15
            ['code_module' => 'IDIA-S1-M5','nom_module' => 'Langues Étrangères (Anglais / Français)',               'id_semestre' => 3, 'id_enseignant' => 4],   // id_module 16
            ['code_module' => 'IDIA-S1-M6','nom_module' => 'Développement Web : Front End',                         'id_semestre' => 3, 'id_enseignant' => 3],   // id_module 17

            // ── IDIA — S2 (id_semestre 4, ouvert) ────────────────────────
            ['code_module' => 'IDIA-S2-M1','nom_module' => 'Développement Personnel',                               'id_semestre' => 4, 'id_enseignant' => 4],   // id_module 18
            ['code_module' => 'IDIA-S2-M2','nom_module' => 'POO en Java (Programmation Orientée Objet)',            'id_semestre' => 4, 'id_enseignant' => 2],   // id_module 19
            ['code_module' => 'IDIA-S2-M3','nom_module' => 'Recherche Opérationnelle',                             'id_semestre' => 4, 'id_enseignant' => 9],   // id_module 20
            ['code_module' => 'IDIA-S2-M4','nom_module' => 'Réseaux Informatiques',                                'id_semestre' => 4, 'id_enseignant' => 3],   // id_module 21

            // ── Web Design — S1 (id_semestre 5, clôturé) ─────────────────
            ['code_module' => 'WD-S1-M1',  'nom_module' => 'UX Design',                                            'id_semestre' => 5, 'id_enseignant' => 1],   // id_module 22
            ['code_module' => 'WD-S1-M2',  'nom_module' => 'Digital Marketing et Email Marketing',                 'id_semestre' => 5, 'id_enseignant' => 11],  // id_module 23
            ['code_module' => 'WD-S1-M3',  'nom_module' => 'Linux',                                                'id_semestre' => 5, 'id_enseignant' => 5],   // id_module 24
            ['code_module' => 'WD-S1-M4',  'nom_module' => 'Réseaux Informatiques et Sécurité',                   'id_semestre' => 5, 'id_enseignant' => 3],   // id_module 25
            ['code_module' => 'WD-S1-M5',  'nom_module' => 'Culture Digitale',                                     'id_semestre' => 5, 'id_enseignant' => 4],   // id_module 26
            ['code_module' => 'WD-S1-M6',  'nom_module' => 'PHP et MySQL',                                         'id_semestre' => 5, 'id_enseignant' => 6],   // id_module 27
            ['code_module' => 'WD-S1-M7',  'nom_module' => 'Langue Française',                                     'id_semestre' => 5, 'id_enseignant' => 4],   // id_module 28

            // ── Web Design — S2 (id_semestre 6, ouvert) ──────────────────
            ['code_module' => 'WD-S2-M1',  'nom_module' => 'JavaScript Avancé et Frameworks',                      'id_semestre' => 6, 'id_enseignant' => 6],   // id_module 29
            ['code_module' => 'WD-S2-M2',  'nom_module' => 'SEO et Stratégie de Contenu',                         'id_semestre' => 6, 'id_enseignant' => 11],  // id_module 30
            ['code_module' => 'WD-S2-M3',  'nom_module' => 'WordPress et CMS',                                    'id_semestre' => 6, 'id_enseignant' => 6],   // id_module 31
            ['code_module' => 'WD-S2-M4',  'nom_module' => 'Communication Professionnelle',                        'id_semestre' => 6, 'id_enseignant' => 4],   // id_module 32

            // ── CDL — S3 (id_semestre 7, clôturé) — 2ème année ───────────
            ['code_module' => 'CDL-S3-M1', 'nom_module' => 'Architecture Logicielle et Design Patterns',           'id_semestre' => 7,  'id_enseignant' => 1],   // id_module 33
            ['code_module' => 'CDL-S3-M2', 'nom_module' => 'Développement Mobile Android/iOS',                     'id_semestre' => 7,  'id_enseignant' => 2],   // id_module 34
            ['code_module' => 'CDL-S3-M3', 'nom_module' => 'DevOps et Cloud Computing',                            'id_semestre' => 7,  'id_enseignant' => 7],   // id_module 35
            ['code_module' => 'CDL-S3-M4', 'nom_module' => 'Sécurité des Applications Web',                        'id_semestre' => 7,  'id_enseignant' => 3],   // id_module 36

            // ── CDL — S4 (id_semestre 8, ouvert) — 2ème année ────────────
            ['code_module' => 'CDL-S4-M1', 'nom_module' => 'Projet de Fin d\'Études (PFE)',                         'id_semestre' => 8,  'id_enseignant' => 1],   // id_module 37
            ['code_module' => 'CDL-S4-M2', 'nom_module' => 'Intelligence Artificielle Appliquée',                  'id_semestre' => 8,  'id_enseignant' => 2],   // id_module 38
            ['code_module' => 'CDL-S4-M3', 'nom_module' => 'Entrepreneuriat et Gestion de Projet',                 'id_semestre' => 8,  'id_enseignant' => 11],  // id_module 39
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 9. INTERVENIR (co-intervenants)
        // ═══════════════════════════════════════════════════════════════════
        DB::table('intervenir')->insert([
            ['id_enseignant' => 2,  'id_module' => 6],   // Berrahal co-intervient sur Algo CDL-S1
            ['id_enseignant' => 8,  'id_module' => 4],   // Amine co-intervient sur Dev Web CDL-S1
            ['id_enseignant' => 9,  'id_module' => 12],  // Benali co-intervient sur ML IDIA-S1
            ['id_enseignant' => 3,  'id_module' => 21],  // Khriss co-intervient sur Réseaux IDIA-S2
            ['id_enseignant' => 1,  'id_module' => 25],  // Serghini co-intervient sur Réseaux WD-S1
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 10. INSCRIRE (inscriptions étudiants ↔ semestres)
        // ═══════════════════════════════════════════════════════════════════
        DB::table('inscrire')->insert([
            // ── CDL 1ère année — S1/S2 2023-24 (semestres 1 et 2) ────────
            ['id_etudiant' => 1,  'id_semestre' => 1],  // Bellatrach — S1
            ['id_etudiant' => 1,  'id_semestre' => 2],  // Bellatrach — S2
            ['id_etudiant' => 2,  'id_semestre' => 1],  // Elmir — S1
            ['id_etudiant' => 2,  'id_semestre' => 2],  // Elmir — S2
            ['id_etudiant' => 3,  'id_semestre' => 1],  // Chehlafi — S1
            ['id_etudiant' => 3,  'id_semestre' => 2],  // Chehlafi — S2
            ['id_etudiant' => 4,  'id_semestre' => 1],  // Lamrani (inactive) — S1 seulement
            // ── CDL 2ème année — S3/S4 2024-25 (semestres 7 et 8) ────────
            ['id_etudiant' => 5,  'id_semestre' => 7],  // Belhit — S3
            ['id_etudiant' => 5,  'id_semestre' => 8],  // Belhit — S4
            ['id_etudiant' => 6,  'id_semestre' => 7],  // Khaldi — S3
            ['id_etudiant' => 6,  'id_semestre' => 8],  // Khaldi — S4
            ['id_etudiant' => 7,  'id_semestre' => 7],  // Abarkani — S3
            ['id_etudiant' => 7,  'id_semestre' => 8],  // Abarkani — S4
            ['id_etudiant' => 8,  'id_semestre' => 7],  // Eddahem (inactive) — S3 seulement
            // ── IDIA 1ère année — S1/S2 2023-24 (semestres 3 et 4) ───────
            ['id_etudiant' => 9,  'id_semestre' => 3],  // Kamal — S1
            ['id_etudiant' => 9,  'id_semestre' => 4],  // Kamal — S2
            ['id_etudiant' => 10, 'id_semestre' => 3],  // Nadir — S1
            ['id_etudiant' => 10, 'id_semestre' => 4],  // Nadir — S2
            ['id_etudiant' => 11, 'id_semestre' => 3],  // Alami — S1
            ['id_etudiant' => 11, 'id_semestre' => 4],  // Alami — S2
            ['id_etudiant' => 12, 'id_semestre' => 3],  // Senhaji — S1 seulement
            ['id_etudiant' => 13, 'id_semestre' => 3],  // Haddad (inactive) — S1 seulement
            // ── Web Design 1ère année — S1/S2 2023-24 (semestres 5 et 6) ─
            ['id_etudiant' => 14, 'id_semestre' => 5],  // Ouahbi — S1
            ['id_etudiant' => 14, 'id_semestre' => 6],  // Ouahbi — S2
            ['id_etudiant' => 15, 'id_semestre' => 5],  // Lazrak — S1
            ['id_etudiant' => 15, 'id_semestre' => 6],  // Lazrak — S2
            ['id_etudiant' => 16, 'id_semestre' => 5],  // Ghazali — S1
            ['id_etudiant' => 16, 'id_semestre' => 6],  // Ghazali — S2
            ['id_etudiant' => 17, 'id_semestre' => 5],  // Mekki (inactive) — S1 seulement
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 11. NOTES
        // ═══════════════════════════════════════════════════════════════════
        // Uniquement pour les semestres clôturés : 1 (CDL-S1), 3 (IDIA-S1), 5 (WD-S1), 7 (CDL-S3)
        // Règle : note < 10 → rattrapage renseigné ; note >= 10 → rattrapage null
        DB::table('note')->insert([

            // ── CDL — S1 — Bellatrach (id_etudiant 1) — modules 1-7 ──────
            ['id_etudiant' => 1, 'id_module' => 1, 'note' => 14.50, 'rattrapage' => null],   // Algèbre
            ['id_etudiant' => 1, 'id_module' => 2, 'note' => 12.00, 'rattrapage' => null],   // Intro IA
            ['id_etudiant' => 1, 'id_module' => 3, 'note' => 16.00, 'rattrapage' => null],   // SI & BDD
            ['id_etudiant' => 1, 'id_module' => 4, 'note' =>  9.00, 'rattrapage' => 11.00],  // Dev Web (rattrapé)
            ['id_etudiant' => 1, 'id_module' => 5, 'note' => 13.50, 'rattrapage' => null],   // Stats
            ['id_etudiant' => 1, 'id_module' => 6, 'note' => 15.00, 'rattrapage' => null],   // Algo & C
            ['id_etudiant' => 1, 'id_module' => 7, 'note' => 11.00, 'rattrapage' => null],   // Français

            // ── CDL — S1 — Elmir (id_etudiant 2) ─────────────────────────
            ['id_etudiant' => 2, 'id_module' => 1, 'note' =>  8.00, 'rattrapage' => 10.50],  // Algèbre (rattrapé)
            ['id_etudiant' => 2, 'id_module' => 2, 'note' => 11.00, 'rattrapage' => null],
            ['id_etudiant' => 2, 'id_module' => 3, 'note' => 13.00, 'rattrapage' => null],
            ['id_etudiant' => 2, 'id_module' => 4, 'note' =>  7.50, 'rattrapage' =>  9.00],  // Dev Web (rattrapé <10)
            ['id_etudiant' => 2, 'id_module' => 5, 'note' => 10.00, 'rattrapage' => null],
            ['id_etudiant' => 2, 'id_module' => 6, 'note' => 14.00, 'rattrapage' => null],
            ['id_etudiant' => 2, 'id_module' => 7, 'note' => 12.00, 'rattrapage' => null],

            // ── CDL — S1 — Chehlafi (id_etudiant 3) ──────────────────────
            ['id_etudiant' => 3, 'id_module' => 1, 'note' => 17.00, 'rattrapage' => null],
            ['id_etudiant' => 3, 'id_module' => 2, 'note' => 15.50, 'rattrapage' => null],
            ['id_etudiant' => 3, 'id_module' => 3, 'note' => 14.00, 'rattrapage' => null],
            ['id_etudiant' => 3, 'id_module' => 4, 'note' => 13.00, 'rattrapage' => null],
            ['id_etudiant' => 3, 'id_module' => 5, 'note' => 16.00, 'rattrapage' => null],
            ['id_etudiant' => 3, 'id_module' => 6, 'note' => 18.00, 'rattrapage' => null],
            ['id_etudiant' => 3, 'id_module' => 7, 'note' => 14.50, 'rattrapage' => null],

            // ── CDL — S3 — Belhit (id_etudiant 5) — modules 33-36 ────────
            ['id_etudiant' => 5, 'id_module' => 33, 'note' => 13.00, 'rattrapage' => null],  // Architecture
            ['id_etudiant' => 5, 'id_module' => 34, 'note' => 11.00, 'rattrapage' => null],  // Mobile
            ['id_etudiant' => 5, 'id_module' => 35, 'note' =>  8.50, 'rattrapage' => 10.00], // DevOps (rattrapé)
            ['id_etudiant' => 5, 'id_module' => 36, 'note' => 15.00, 'rattrapage' => null],  // Sécurité

            // ── CDL — S3 — Khaldi (id_etudiant 6) ────────────────────────
            ['id_etudiant' => 6, 'id_module' => 33, 'note' => 16.00, 'rattrapage' => null],
            ['id_etudiant' => 6, 'id_module' => 34, 'note' => 14.00, 'rattrapage' => null],
            ['id_etudiant' => 6, 'id_module' => 35, 'note' => 12.00, 'rattrapage' => null],
            ['id_etudiant' => 6, 'id_module' => 36, 'note' => 17.00, 'rattrapage' => null],

            // ── IDIA — S1 — Kamal (id_etudiant 9) — modules 12-17 ────────
            ['id_etudiant' => 9,  'id_module' => 12, 'note' => 15.00, 'rattrapage' => null],
            ['id_etudiant' => 9,  'id_module' => 13, 'note' => 13.00, 'rattrapage' => null],
            ['id_etudiant' => 9,  'id_module' => 14, 'note' => 16.00, 'rattrapage' => null],
            ['id_etudiant' => 9,  'id_module' => 15, 'note' =>  9.50, 'rattrapage' => 11.50], // (rattrapé)
            ['id_etudiant' => 9,  'id_module' => 16, 'note' => 14.00, 'rattrapage' => null],
            ['id_etudiant' => 9,  'id_module' => 17, 'note' => 12.00, 'rattrapage' => null],

            // ── IDIA — S1 — Nadir (id_etudiant 10) ───────────────────────
            ['id_etudiant' => 10, 'id_module' => 12, 'note' => 18.00, 'rattrapage' => null],
            ['id_etudiant' => 10, 'id_module' => 13, 'note' => 17.00, 'rattrapage' => null],
            ['id_etudiant' => 10, 'id_module' => 14, 'note' => 19.00, 'rattrapage' => null],
            ['id_etudiant' => 10, 'id_module' => 15, 'note' => 16.00, 'rattrapage' => null],
            ['id_etudiant' => 10, 'id_module' => 16, 'note' => 15.00, 'rattrapage' => null],
            ['id_etudiant' => 10, 'id_module' => 17, 'note' => 14.00, 'rattrapage' => null],

            // ── IDIA — S1 — Alami (id_etudiant 11) ───────────────────────
            ['id_etudiant' => 11, 'id_module' => 12, 'note' =>  7.00, 'rattrapage' =>  9.50], // (<10 après rattrapage)
            ['id_etudiant' => 11, 'id_module' => 13, 'note' => 11.00, 'rattrapage' => null],
            ['id_etudiant' => 11, 'id_module' => 14, 'note' => 13.00, 'rattrapage' => null],
            ['id_etudiant' => 11, 'id_module' => 15, 'note' =>  8.00, 'rattrapage' => 10.00], // (rattrapé)
            ['id_etudiant' => 11, 'id_module' => 16, 'note' => 12.00, 'rattrapage' => null],
            ['id_etudiant' => 11, 'id_module' => 17, 'note' => 10.50, 'rattrapage' => null],

            // ── Web Design — S1 — Ouahbi (id_etudiant 14) — modules 22-28 ─
            ['id_etudiant' => 14, 'id_module' => 22, 'note' => 16.00, 'rattrapage' => null],
            ['id_etudiant' => 14, 'id_module' => 23, 'note' => 14.00, 'rattrapage' => null],
            ['id_etudiant' => 14, 'id_module' => 24, 'note' => 11.00, 'rattrapage' => null],
            ['id_etudiant' => 14, 'id_module' => 25, 'note' =>  8.50, 'rattrapage' => 10.50], // (rattrapé)
            ['id_etudiant' => 14, 'id_module' => 26, 'note' => 15.00, 'rattrapage' => null],
            ['id_etudiant' => 14, 'id_module' => 27, 'note' => 13.00, 'rattrapage' => null],
            ['id_etudiant' => 14, 'id_module' => 28, 'note' => 12.00, 'rattrapage' => null],

            // ── Web Design — S1 — Lazrak (id_etudiant 15) ────────────────
            ['id_etudiant' => 15, 'id_module' => 22, 'note' => 13.00, 'rattrapage' => null],
            ['id_etudiant' => 15, 'id_module' => 23, 'note' => 15.00, 'rattrapage' => null],
            ['id_etudiant' => 15, 'id_module' => 24, 'note' =>  9.00, 'rattrapage' => 11.00], // (rattrapé)
            ['id_etudiant' => 15, 'id_module' => 25, 'note' => 10.00, 'rattrapage' => null],
            ['id_etudiant' => 15, 'id_module' => 26, 'note' => 14.00, 'rattrapage' => null],
            ['id_etudiant' => 15, 'id_module' => 27, 'note' => 16.50, 'rattrapage' => null],
            ['id_etudiant' => 15, 'id_module' => 28, 'note' => 11.00, 'rattrapage' => null],
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 12. RÉCLAMATIONS
        // ═══════════════════════════════════════════════════════════════════
        // id_note suit l'ordre d'insertion ci-dessus :
        //  4 = Bellatrach/Dev Web CDL-S1 (note 9.00)
        //  8 = Elmir/Dev Web CDL-S1 (note 7.50)
        // 25 = Ouahbi/Réseaux & Sécurité WD-S1 (note 8.50)
        DB::table('reclamation')->insert([
            [
                'message'          => "Ma note de Développement Web semble incorrecte, je demande une vérification.",
                'date_reclamation' => '2024-02-01 10:30:00',
                'id_note'          => 4,   // Bellatrach — Dev Web Front End CDL-S1
            ],
            [
                'message'          => "Ma note CC Développement Web est trop basse, possible erreur de saisie.",
                'date_reclamation' => '2024-01-25 14:00:00',
                'id_note'          => 11,  // Elmir — Dev Web Front End CDL-S1 (8ème note + offset 3 = 11)
            ],
            [
                'message'          => "Je conteste ma note de Réseaux et Sécurité, j'avais bien rendu l'examen.",
                'date_reclamation' => '2024-02-10 09:15:00',
                'id_note'          => 46,  // Ouahbi — Réseaux & Sécurité WD-S1
            ],
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 13. LOG ACTIONS
        // ═══════════════════════════════════════════════════════════════════
        DB::table('log_action')->insert([
            ['action' => 'CREATE', 'table_concernee' => 'etudiant',    'id_enregistrement' => 1,  'id_user' => 1, 'date_action' => now()],  // Admin crée Bellatrach
            ['action' => 'CREATE', 'table_concernee' => 'etudiant',    'id_enregistrement' => 9,  'id_user' => 1, 'date_action' => now()],  // Admin crée Kamal (IDIA)
            ['action' => 'CREATE', 'table_concernee' => 'etudiant',    'id_enregistrement' => 14, 'id_user' => 1, 'date_action' => now()],  // Admin crée Ouahbi (WD)
            ['action' => 'UPDATE', 'table_concernee' => 'note',        'id_enregistrement' => 4,  'id_user' => 2, 'date_action' => now()],  // Serghini maj note Bellatrach
            ['action' => 'UPDATE', 'table_concernee' => 'note',        'id_enregistrement' => 11, 'id_user' => 2, 'date_action' => now()],  // Serghini maj note Elmir
            ['action' => 'UPDATE', 'table_concernee' => 'reclamation', 'id_enregistrement' => 1,  'id_user' => 1, 'date_action' => now()],  // Admin traite réclamation #1
            ['action' => 'CREATE', 'table_concernee' => 'inscrire',    'id_enregistrement' => 15, 'id_user' => 1, 'date_action' => now()],  // Admin inscrit Kamal
            ['action' => 'CREATE', 'table_concernee' => 'inscrire',    'id_enregistrement' => 24, 'id_user' => 1, 'date_action' => now()],  // Admin inscrit Ouahbi
        ]);
    }
}
