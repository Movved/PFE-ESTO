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
        // Roles: ADMIN, ENSEIGNANT, ETUDIANT
        // IDs are auto-incremented; comments track each ID for reference.
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
            // id_user 23 (email fixed — was duplicate of Missaoui)
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

            // ── ÉTUDIANTS — Filière 1 : CDL (Conception et Développement des Logiciels) ──
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

            // ── ÉTUDIANTS — Filière 2 : IDIA (Informatique Décisionnelle et IA) ──
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

            // ── ÉTUDIANTS — Filière 3 : Web Design et Marketing Digital ───
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
        │  2  = Serghini (chef dept)      7  = Idrissi                        │
        │  3  = Berrahal                  8  = Amine                          │
        │  4  = Khriss                    9  = Benali                         │
        │  5  = Brahim Sara              10  = Zaki                           │
        │  6  = Elbeqqal                 11  = Mokhtari                       │
        │  ── Management (Dept 2) ──                                          │
        │ 12  = Eljay (chef dept)        17  = Elhila                         │
        │ 13  = Missaoui                 18  = Chaanoun                       │
        │ 14  = Oulahyane               19  = Radi                            │
        │ 15  = Boussalam               20  = Tazi                            │
        │ 16  = Arfaoui                 21  = Benomar                         │
        │  ── Génie Appliqué (Dept 3) ──                                      │
        │ 22  = Qodad (chef dept)        27  = Mrani                          │
        │ 23  = Hana                     28  = Boukhris                       │
        │ 24  = Filali                   29  = Cherkaoui                      │
        │ 25  = Tahiri                   30  = Benyahia                       │
        │ 26  = Ouali                    31  = Sabri                          │
        │  ── Étudiants CDL ──                                                │
        │ 32  = Bellatrach   35 = Lamrani(inactive)  38 = Abarkani            │
        │ 33  = Elmir        36 = Belhit              39 = Eddahem(inactive)  │
        │ 34  = Chehlafi     37 = Khaldi                                      │
        │  ── Étudiants IDIA ──                                               │
        │ 40  = Kamal        42 = Alami    44 = Haddad(inactive)              │
        │ 41  = Nadir        43 = Senhaji                                     │
        │  ── Étudiants Web Design ──                                         │
        │ 45  = Ouahbi       47 = Ghazali                                     │
        │ 46  = Lazrak       48 = Mekki(inactive)                             │
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
        // Spécialités choisies selon le département.
        // Un seul prof par département a is_chef = true.
        DB::table('enseignant')->insert([

            // ── Génie Informatique — id_departement 1 ─────────────────────
            ['specialite' => 'Génie Logiciel',              'is_chef' => true,  'id_departement' => 1, 'id_user' => 2],   // id_enseignant 1  — Serghini (CHEF)
            ['specialite' => 'Intelligence Artificielle',   'is_chef' => false, 'id_departement' => 1, 'id_user' => 3],   // id_enseignant 2  — Berrahal
            ['specialite' => 'Réseaux et Sécurité',         'is_chef' => false, 'id_departement' => 1, 'id_user' => 4],   // id_enseignant 3  — Khriss
            ['specialite' => 'Langues et Communication',    'is_chef' => false, 'id_departement' => 1, 'id_user' => 5],   // id_enseignant 4  — Brahim Sara
            ['specialite' => 'Bases de Données',            'is_chef' => false, 'id_departement' => 1, 'id_user' => 6],   // id_enseignant 5  — Elbeqqal
            ['specialite' => 'Développement Web',           'is_chef' => false, 'id_departement' => 1, 'id_user' => 7],   // id_enseignant 6  — Mokhtari
            ['specialite' => 'Systèmes Embarqués',          'is_chef' => false, 'id_departement' => 1, 'id_user' => 8],   // id_enseignant 7  — Idrissi
            ['specialite' => 'Algorithmique',               'is_chef' => false, 'id_departement' => 1, 'id_user' => 9],   // id_enseignant 8  — Amine
            ['specialite' => 'Architecture des Systèmes',   'is_chef' => false, 'id_departement' => 1, 'id_user' => 10],  // id_enseignant 9  — Benali
            ['specialite' => 'Mathématiques Appliquées',    'is_chef' => false, 'id_departement' => 1, 'id_user' => 11],  // id_enseignant 10 — Zaki

            // ── Management — id_departement 2 ─────────────────────────────
            ['specialite' => 'Marketing et Commerce',       'is_chef' => true,  'id_departement' => 2, 'id_user' => 12],  // id_enseignant 11 — Eljay (CHEF)
            ['specialite' => 'Économie et Gestion',         'is_chef' => false, 'id_departement' => 2, 'id_user' => 13],  // id_enseignant 12 — Missaoui
            ['specialite' => 'Droit des Entreprises',       'is_chef' => false, 'id_departement' => 2, 'id_user' => 14],  // id_enseignant 13 — Oulahyane
            ['specialite' => 'Finance et Comptabilité',     'is_chef' => false, 'id_departement' => 2, 'id_user' => 15],  // id_enseignant 14 — Boussalam
            ['specialite' => 'Systèmes d\'Information',     'is_chef' => false, 'id_departement' => 2, 'id_user' => 16],  // id_enseignant 15 — Arfaoui
            ['specialite' => 'Langues et Communication',    'is_chef' => false, 'id_departement' => 2, 'id_user' => 17],  // id_enseignant 16 — Elhila
            ['specialite' => 'Ressources Humaines',         'is_chef' => false, 'id_departement' => 2, 'id_user' => 18],  // id_enseignant 17 — Chaanoun
            ['specialite' => 'Fiscalité et Audit',          'is_chef' => false, 'id_departement' => 2, 'id_user' => 19],  // id_enseignant 18 — Radi
            ['specialite' => 'Business Intelligence',       'is_chef' => false, 'id_departement' => 2, 'id_user' => 20],  // id_enseignant 19 — Tazi
            ['specialite' => 'E-Commerce et Digital',       'is_chef' => false, 'id_departement' => 2, 'id_user' => 21],  // id_enseignant 20 — Benomar

            // ── Génie Appliqué — id_departement 3 ────────────────────────
            ['specialite' => 'Électrotechnique',            'is_chef' => true,  'id_departement' => 3, 'id_user' => 22],  // id_enseignant 21 — Qodad (CHEF)
            ['specialite' => 'Énergies Renouvelables',      'is_chef' => false, 'id_departement' => 3, 'id_user' => 23],  // id_enseignant 22 — Hana
            ['specialite' => 'Mécatronique',                'is_chef' => false, 'id_departement' => 3, 'id_user' => 24],  // id_enseignant 23 — Filali
            ['specialite' => 'Automatisme Industriel',      'is_chef' => false, 'id_departement' => 3, 'id_user' => 25],  // id_enseignant 24 — Tahiri
            ['specialite' => 'Génie Civil',                 'is_chef' => false, 'id_departement' => 3, 'id_user' => 26],  // id_enseignant 25 — Ouali
            ['specialite' => 'Conception Mécanique',        'is_chef' => false, 'id_departement' => 3, 'id_user' => 27],  // id_enseignant 26 — Mrani
            ['specialite' => 'Technologies Automobiles',    'is_chef' => false, 'id_departement' => 3, 'id_user' => 28],  // id_enseignant 27 — Boukhris
            ['specialite' => 'Thermodynamique',             'is_chef' => false, 'id_departement' => 3, 'id_user' => 29],  // id_enseignant 28 — Cherkaoui
            ['specialite' => 'Prototypage et Fabrication',  'is_chef' => false, 'id_departement' => 3, 'id_user' => 30],  // id_enseignant 29 — Benyahia
            ['specialite' => 'Mathématiques Appliquées',    'is_chef' => false, 'id_departement' => 3, 'id_user' => 31],  // id_enseignant 30 — Sabri
        ]);

        /*
        ┌─────────────────────────────────────────────────────────────────────┐
        │ RÉCAPITULATIF id_enseignant                                         │
        │  Génie Informatique (Dept 1)                                        │
        │   1=Serghini(chef)  4=Brahim   7=Idrissi  10=Zaki                  │
        │   2=Berrahal        5=Elbeqqal  8=Amine                             │
        │   3=Khriss          6=Mokhtari  9=Benali                            │
        │  Management (Dept 2)                                                │
        │  11=Eljay(chef)    14=Boussalam 17=Chaanoun 20=Benomar              │
        │  12=Missaoui       15=Arfaoui  18=Radi                              │
        │  13=Oulahyane      16=Elhila   19=Tazi                              │
        │  Génie Appliqué (Dept 3)                                            │
        │  21=Qodad(chef)    24=Tahiri   27=Boukhris 30=Sabri                 │
        │  22=Hana           25=Ouali    28=Cherkaoui                         │
        │  23=Filali         26=Mrani    29=Benyahia                          │
        └─────────────────────────────────────────────────────────────────────┘
        */

        // ═══════════════════════════════════════════════════════════════════
        // 4. ÉTUDIANTS
        // ═══════════════════════════════════════════════════════════════════
        // CNE format: G11 + year (23 or 24) + sequential number
        DB::table('etudiant')->insert([

            // CDL students
            ['cne' => 'G110024001', 'id_user' => 32],  // id_etudiant 1  — Bellatrach Mohammed
            ['cne' => 'G110024002', 'id_user' => 33],  // id_etudiant 2  — Elmir Rayane
            ['cne' => 'G110024003', 'id_user' => 34],  // id_etudiant 3  — Chehlafi Ibrahim
            ['cne' => 'G110023004', 'id_user' => 35],  // id_etudiant 4  — Lamrani Nadia (inactive)
            ['cne' => 'G110023005', 'id_user' => 36],  // id_etudiant 5  — Belhit Abdelhak
            ['cne' => 'G110023006', 'id_user' => 37],  // id_etudiant 6  — Khaldi Mohammed
            ['cne' => 'G110023007', 'id_user' => 38],  // id_etudiant 7  — Abarkani Nassim
            ['cne' => 'G110023008', 'id_user' => 39],  // id_etudiant 8  — Eddahem Reda (inactive)

            // IDIA students
            ['cne' => 'G110024009', 'id_user' => 40],  // id_etudiant 9  — Kamal Yassine
            ['cne' => 'G110024010', 'id_user' => 41],  // id_etudiant 10 — Nadir Salma
            ['cne' => 'G110024011', 'id_user' => 42],  // id_etudiant 11 — Alami Hamza
            ['cne' => 'G110023012', 'id_user' => 43],  // id_etudiant 12 — Senhaji Meryem
            ['cne' => 'G110023013', 'id_user' => 44],  // id_etudiant 13 — Haddad Anas (inactive)

            // Web Design students
            ['cne' => 'G110024014', 'id_user' => 45],  // id_etudiant 14 — Ouahbi Chaymae
            ['cne' => 'G110024015', 'id_user' => 46],  // id_etudiant 15 — Lazrak Ilyas
            ['cne' => 'G110023016', 'id_user' => 47],  // id_etudiant 16 — Ghazali Rim
            ['cne' => 'G110023017', 'id_user' => 48],  // id_etudiant 17 — Mekki Zakaria (inactive)
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 5. FILIERES
        // ═══════════════════════════════════════════════════════════════════
        DB::table('filiere')->insert([

            // ── Génie Informatique (id_departement 1) — 5 filieres ────────
            ['nom_filiere' => 'Conception et Développement des Logiciels',
             'description' => 'Formation en développement logiciel et architecture.',
             'id_departement' => 1],
            // id_filiere 1 — CDL

            ['nom_filiere' => 'Informatique Décisionnelle et Intelligence Artificielle',
             'description' => 'Formation en science des données et intelligence artificielle.',
             'id_departement' => 1],
            // id_filiere 2 — IDIA

            ['nom_filiere' => 'Web Design et Marketing Digital',
             'description' => 'Formation pour créer des sites web professionnels et design graphique.',
             'id_departement' => 1],
            // id_filiere 3 — WDMD

            ['nom_filiere' => 'Génie Informatique Embarquée',
             'description' => 'Formation en systèmes embarqués, IoT et programmation bas-niveau.',
             'id_departement' => 1],
            // id_filiere 4 — GIE (nouvelle)

            ['nom_filiere' => 'Système d\'Information et Ingénierie de Données',
             'description' => 'Formation en architecture des SI, Big Data et ingénierie des données.',
             'id_departement' => 1],
            // id_filiere 5 — SIID (nouvelle)

            // ── Management (id_departement 2) — 5 filieres ────────────────
            ['nom_filiere' => 'Informatique et Gestion des Entreprises (IGE)',
             'description' => 'Formation combinant informatique et gestion pour répondre aux besoins des entreprises.',
             'id_departement' => 2],
            // id_filiere 6 — IGE

            ['nom_filiere' => 'Informatique et Gestion des Entreprises (BIGE)',
             'description' => "Formation en informatique appliquée à la gestion avancée des entreprises.",
             'id_departement' => 2],
            // id_filiere 7 — BIGE

            ['nom_filiere' => 'Finance, Comptabilité et Fiscalité (FCF)',
             'description' => 'Formation en gestion financière, comptabilité et fiscalité des organisations.',
             'id_departement' => 2],
            // id_filiere 8 — FCF

            ['nom_filiere' => 'Marketing et E-Commerce (MEEC)',
             'description' => 'Formation en stratégies marketing, commerce électronique et médias sociaux.',
             'id_departement' => 2],
            // id_filiere 9 — MEEC (nouvelle)

            ['nom_filiere' => 'Finance d\'Entreprises et Business Intelligence (BFEBI)',
             'description' => 'Formation en finance avancée, analyse de données décisionnelles et BI.',
             'id_departement' => 2],
            // id_filiere 10 — BFEBI (nouvelle)

            // ── Génie Appliqué (id_departement 3) — 5 filieres ───────────
            ['nom_filiere' => 'Électrotechnique et Énergies Renouvelables',
             'description' => 'Formation en systèmes électriques et technologies des énergies renouvelables.',
             'id_departement' => 3],
            // id_filiere 11 — EER

            ['nom_filiere' => 'Mécatronique Industrielle',
             'description' => 'Formation en automatisation industrielle combinant mécanique, électronique et informatique.',
             'id_departement' => 3],
            // id_filiere 12 — MI

            ['nom_filiere' => 'Technologie Automobile',
             'description' => 'Formation en diagnostic, maintenance et technologies des véhicules modernes.',
             'id_departement' => 3],
            // id_filiere 13 — TA

            ['nom_filiere' => 'Conception et Prototypage Industriel',
             'description' => 'Formation en CAO, prototypage rapide et fabrication industrielle.',
             'id_departement' => 3],
            // id_filiere 14 — CPI (nouvelle)

            ['nom_filiere' => 'Génie Civil et Efficacité Energétique (BGCEE)',
             'description' => 'Formation en construction durable, gestion de chantier et efficacité énergétique des bâtiments.',
             'id_departement' => 3],
            // id_filiere 15 — BGCEE (nouvelle)
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 6. ANNÉES ACADÉMIQUES
        // ═══════════════════════════════════════════════════════════════════
        DB::table('annee_academique')->insert([
            ['libelle' => '2023-2024'],  // id_annee 1
            ['libelle' => '2024-2025'],  // id_annee 2
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 7. SEMESTRES
        // ═══════════════════════════════════════════════════════════════════
        // Règle : S1 et S3 sont clôturés (cloture = true)
        //         S2 et S4 sont ouverts   (cloture = false)
        DB::table('semestre')->insert([
            ['numero' => 1, 'cloture' => true,  'id_annee' => 1],  // id_semestre 1 — S1 2023-24 (clôturé)
            ['numero' => 2, 'cloture' => false, 'id_annee' => 1],  // id_semestre 2 — S2 2023-24 (ouvert)
            ['numero' => 3, 'cloture' => true,  'id_annee' => 2],  // id_semestre 3 — S3 2024-25 (clôturé)
            ['numero' => 4, 'cloture' => false, 'id_annee' => 2],  // id_semestre 4 — S4 2024-25 (ouvert)
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 8. MODULES
        // ═══════════════════════════════════════════════════════════════════
        // Chaque module appartient à un semestre et est assigné à un enseignant principal.
        // La colonne id_filiere est optionnelle ; on la renseigne quand plusieurs filieres
        // partagent le même code_module (pour lever l'ambiguïté).
        DB::table('module')->insert([

            // ── CDL — S1 (id_semestre 1, clôturé) ────────────────────────
            ['code_module' => 'CDL-S1-M1',  'nom_module' => 'Algèbre',                                                      'id_semestre' => 1, 'id_filiere' => 1, 'id_enseignant' => 10],  // id_module 1  — Zaki
            ['code_module' => 'CDL-S1-M2',  'nom_module' => "Introduction à l'Intelligence Artificielle",                   'id_semestre' => 1, 'id_filiere' => 1, 'id_enseignant' => 2],   // id_module 2  — Berrahal
            ['code_module' => 'CDL-S1-M3',  'nom_module' => "Système d'Information et Bases de Données",                    'id_semestre' => 1, 'id_filiere' => 1, 'id_enseignant' => 5],   // id_module 3  — Elbeqqal
            ['code_module' => 'CDL-S1-M4',  'nom_module' => 'Développement Web : Front End',                                'id_semestre' => 1, 'id_filiere' => 1, 'id_enseignant' => 3],   // id_module 4  — Khriss
            ['code_module' => 'CDL-S1-M5',  'nom_module' => 'Probabilités, Statistiques et Analyse de Données',             'id_semestre' => 1, 'id_filiere' => 1, 'id_enseignant' => 6],   // id_module 5  — Mokhtari
            ['code_module' => 'CDL-S1-M6',  'nom_module' => 'Structures de Données : Algorithmique Avancée et C',           'id_semestre' => 1, 'id_filiere' => 1, 'id_enseignant' => 1],   // id_module 6  — Serghini
            ['code_module' => 'CDL-S1-M7',  'nom_module' => 'Français',                                                     'id_semestre' => 1, 'id_filiere' => 1, 'id_enseignant' => 4],   // id_module 7  — Brahim Sara

            // ── CDL — S2 (id_semestre 2, ouvert) ─────────────────────────
            ['code_module' => 'CDL-S2-M1',  'nom_module' => 'Technologie .NET',                                             'id_semestre' => 2, 'id_filiere' => 1, 'id_enseignant' => 5],   // id_module 8  — Elbeqqal
            ['code_module' => 'CDL-S2-M2',  'nom_module' => 'Programmation Python',                                        'id_semestre' => 2, 'id_filiere' => 1, 'id_enseignant' => 6],   // id_module 9  — Mokhtari
            ['code_module' => 'CDL-S2-M3',  'nom_module' => 'Communication et Développement Personnel',                    'id_semestre' => 2, 'id_filiere' => 1, 'id_enseignant' => 4],   // id_module 10 — Brahim Sara
            ['code_module' => 'CDL-S2-M4',  'nom_module' => 'JEE et Programmation Mobile',                                 'id_semestre' => 2, 'id_filiere' => 1, 'id_enseignant' => 2],   // id_module 11 — Berrahal

            // ── IDIA — S1 (id_semestre 1, clôturé) ───────────────────────
            ['code_module' => 'IDIA-S1-M1', 'nom_module' => 'Algorithmes de Machine Learning',                             'id_semestre' => 1, 'id_filiere' => 2, 'id_enseignant' => 2],   // id_module 12 — Berrahal
            ['code_module' => 'IDIA-S1-M2', 'nom_module' => "Introduction à l'Intelligence Artificielle",                  'id_semestre' => 1, 'id_filiere' => 2, 'id_enseignant' => 2],   // id_module 13 — Berrahal
            ['code_module' => 'IDIA-S1-M3', 'nom_module' => 'Programmation Python',                                        'id_semestre' => 1, 'id_filiere' => 2, 'id_enseignant' => 6],   // id_module 14 — Mokhtari
            ['code_module' => 'IDIA-S1-M4', 'nom_module' => 'Mathématiques 2 : Algèbre Linéaire',                          'id_semestre' => 1, 'id_filiere' => 2, 'id_enseignant' => 10],  // id_module 15 — Zaki
            ['code_module' => 'IDIA-S1-M5', 'nom_module' => 'Langues Étrangères (Anglais / Français)',                     'id_semestre' => 1, 'id_filiere' => 2, 'id_enseignant' => 4],   // id_module 16 — Brahim Sara
            ['code_module' => 'IDIA-S1-M6', 'nom_module' => 'Développement Web : Front End',                               'id_semestre' => 1, 'id_filiere' => 2, 'id_enseignant' => 3],   // id_module 17 — Khriss

            // ── IDIA — S2 (id_semestre 2, ouvert) ────────────────────────
            ['code_module' => 'IDIA-S2-M1', 'nom_module' => 'Développement Personnel',                                     'id_semestre' => 2, 'id_filiere' => 2, 'id_enseignant' => 4],   // id_module 18 — Brahim Sara
            ['code_module' => 'IDIA-S2-M2', 'nom_module' => 'POO en Java (Programmation Orientée Objet)',                  'id_semestre' => 2, 'id_filiere' => 2, 'id_enseignant' => 2],   // id_module 19 — Berrahal
            ['code_module' => 'IDIA-S2-M3', 'nom_module' => 'Recherche Opérationnelle',                                   'id_semestre' => 2, 'id_filiere' => 2, 'id_enseignant' => 9],   // id_module 20 — Benali
            ['code_module' => 'IDIA-S2-M4', 'nom_module' => 'Réseaux Informatiques',                                      'id_semestre' => 2, 'id_filiere' => 2, 'id_enseignant' => 3],   // id_module 21 — Khriss

            // ── Web Design — S1 (id_semestre 1, clôturé) ─────────────────
            ['code_module' => 'WD-S1-M1',   'nom_module' => 'UX Design',                                                   'id_semestre' => 1, 'id_filiere' => 3, 'id_enseignant' => 1],   // id_module 22 — Serghini
            ['code_module' => 'WD-S1-M2',   'nom_module' => 'Digital Marketing et Email Marketing',                        'id_semestre' => 1, 'id_filiere' => 3, 'id_enseignant' => 11],  // id_module 23 — Eljay
            ['code_module' => 'WD-S1-M3',   'nom_module' => 'Linux',                                                       'id_semestre' => 1, 'id_filiere' => 3, 'id_enseignant' => 5],   // id_module 24 — Elbeqqal
            ['code_module' => 'WD-S1-M4',   'nom_module' => 'Réseaux Informatiques et Sécurité',                           'id_semestre' => 1, 'id_filiere' => 3, 'id_enseignant' => 3],   // id_module 25 — Khriss
            ['code_module' => 'WD-S1-M5',   'nom_module' => 'Culture Digitale',                                            'id_semestre' => 1, 'id_filiere' => 3, 'id_enseignant' => 4],   // id_module 26 — Brahim Sara
            ['code_module' => 'WD-S1-M6',   'nom_module' => 'PHP et MySQL',                                                'id_semestre' => 1, 'id_filiere' => 3, 'id_enseignant' => 6],   // id_module 27 — Mokhtari
            ['code_module' => 'WD-S1-M7',   'nom_module' => 'Langue Française',                                            'id_semestre' => 1, 'id_filiere' => 3, 'id_enseignant' => 4],   // id_module 28 — Brahim Sara

            // ── Web Design — S2 (id_semestre 2, ouvert) ──────────────────
            ['code_module' => 'WD-S2-M1',   'nom_module' => 'JavaScript Avancé et Frameworks',                             'id_semestre' => 2, 'id_filiere' => 3, 'id_enseignant' => 6],   // id_module 29 — Mokhtari
            ['code_module' => 'WD-S2-M2',   'nom_module' => 'SEO et Stratégie de Contenu',                                'id_semestre' => 2, 'id_filiere' => 3, 'id_enseignant' => 11],  // id_module 30 — Eljay
            ['code_module' => 'WD-S2-M3',   'nom_module' => 'WordPress et CMS',                                           'id_semestre' => 2, 'id_filiere' => 3, 'id_enseignant' => 6],   // id_module 31 — Mokhtari
            ['code_module' => 'WD-S2-M4',   'nom_module' => 'Communication Professionnelle',                               'id_semestre' => 2, 'id_filiere' => 3, 'id_enseignant' => 4],   // id_module 32 — Brahim Sara

            // ── IGE — S1 (id_semestre 1, clôturé) ────────────────────────
            ['code_module' => 'IGE-S1-M1',  'nom_module' => 'Mathématique Financière',                                     'id_semestre' => 1, 'id_filiere' => 6, 'id_enseignant' => 11],  // id_module 33 — Eljay
            ['code_module' => 'IGE-S1-M2',  'nom_module' => 'Marketing Fondamental',                                       'id_semestre' => 1, 'id_filiere' => 6, 'id_enseignant' => 12],  // id_module 34 — Missaoui
            ['code_module' => 'IGE-S1-M3',  'nom_module' => 'Droit des Entreprises',                                       'id_semestre' => 1, 'id_filiere' => 6, 'id_enseignant' => 13],  // id_module 35 — Oulahyane
            ['code_module' => 'IGE-S1-M4',  'nom_module' => 'Algorithme et Programmation',                                 'id_semestre' => 1, 'id_filiere' => 6, 'id_enseignant' => 14],  // id_module 36 — Boussalam
            ['code_module' => 'IGE-S1-M5',  'nom_module' => 'Outils Informatiques de Gestion',                            'id_semestre' => 1, 'id_filiere' => 6, 'id_enseignant' => 15],  // id_module 37 — Arfaoui
            ['code_module' => 'IGE-S1-M6',  'nom_module' => 'Langues Étrangères',                                         'id_semestre' => 1, 'id_filiere' => 6, 'id_enseignant' => 16],  // id_module 38 — Elhila

            // ── IGE — S2 (id_semestre 2, ouvert) ─────────────────────────
            ['code_module' => 'IGE-S2-M1',  'nom_module' => 'Comptabilité Générale',                                       'id_semestre' => 2, 'id_filiere' => 6, 'id_enseignant' => 14],  // id_module 39 — Boussalam
            ['code_module' => 'IGE-S2-M2',  'nom_module' => 'Bases de Données et SQL',                                    'id_semestre' => 2, 'id_filiere' => 6, 'id_enseignant' => 15],  // id_module 40 — Arfaoui
            ['code_module' => 'IGE-S2-M3',  'nom_module' => 'Gestion des Ressources Humaines',                            'id_semestre' => 2, 'id_filiere' => 6, 'id_enseignant' => 17],  // id_module 41 — Chaanoun
            ['code_module' => 'IGE-S2-M4',  'nom_module' => 'Communication en Entreprise',                                'id_semestre' => 2, 'id_filiere' => 6, 'id_enseignant' => 16],  // id_module 42 — Elhila

            // ── BIGE — S1 (id_semestre 1, clôturé) ───────────────────────
            ['code_module' => 'BIGE-S1-M1', 'nom_module' => 'Algorithmique',                                               'id_semestre' => 1, 'id_filiere' => 7, 'id_enseignant' => 8],   // id_module 43 — Amine
            ['code_module' => 'BIGE-S1-M2', 'nom_module' => 'Analyse Mathématique',                                        'id_semestre' => 1, 'id_filiere' => 7, 'id_enseignant' => 10],  // id_module 44 — Zaki
            ['code_module' => 'BIGE-S1-M3', 'nom_module' => 'Introduction à la Gestion',                                  'id_semestre' => 1, 'id_filiere' => 7, 'id_enseignant' => 12],  // id_module 45 — Missaoui

            // ── BIGE — S2 (id_semestre 2, ouvert) ────────────────────────
            ['code_module' => 'BIGE-S2-M1', 'nom_module' => 'OOP C++',                                                    'id_semestre' => 2, 'id_filiere' => 7, 'id_enseignant' => 8],   // id_module 46 — Amine
            ['code_module' => 'BIGE-S2-M2', 'nom_module' => 'Base de Données MySQL',                                      'id_semestre' => 2, 'id_filiere' => 7, 'id_enseignant' => 5],   // id_module 47 — Elbeqqal
            ['code_module' => 'BIGE-S2-M3', 'nom_module' => 'Comptabilité Analytique',                                    'id_semestre' => 2, 'id_filiere' => 7, 'id_enseignant' => 14],  // id_module 48 — Boussalam

            // ── FCF — S1 (id_semestre 1, clôturé) ────────────────────────
            ['code_module' => 'FCF-S1-M1',  'nom_module' => 'Comptabilité Générale',                                       'id_semestre' => 1, 'id_filiere' => 8, 'id_enseignant' => 14],  // id_module 49 — Boussalam
            ['code_module' => 'FCF-S1-M2',  'nom_module' => 'Fiscalité des Entreprises',                                   'id_semestre' => 1, 'id_filiere' => 8, 'id_enseignant' => 18],  // id_module 50 — Radi
            ['code_module' => 'FCF-S1-M3',  'nom_module' => 'Mathématiques Financières',                                   'id_semestre' => 1, 'id_filiere' => 8, 'id_enseignant' => 11],  // id_module 51 — Eljay

            // ── FCF — S2 (id_semestre 2, ouvert) ─────────────────────────
            ['code_module' => 'FCF-S2-M1',  'nom_module' => 'Audit et Contrôle de Gestion',                               'id_semestre' => 2, 'id_filiere' => 8, 'id_enseignant' => 18],  // id_module 52 — Radi
            ['code_module' => 'FCF-S2-M2',  'nom_module' => 'Comptabilité Approfondie',                                   'id_semestre' => 2, 'id_filiere' => 8, 'id_enseignant' => 14],  // id_module 53 — Boussalam
            ['code_module' => 'FCF-S2-M3',  'nom_module' => 'Finance d\'Entreprise',                                      'id_semestre' => 2, 'id_filiere' => 8, 'id_enseignant' => 19],  // id_module 54 — Tazi

            // ── MEEC — S1 (id_semestre 1, clôturé) ───────────────────────
            ['code_module' => 'MEEC-S1-M1', 'nom_module' => 'Marketing Digital',                                           'id_semestre' => 1, 'id_filiere' => 9, 'id_enseignant' => 20],  // id_module 55 — Benomar
            ['code_module' => 'MEEC-S1-M2', 'nom_module' => 'E-Commerce et Plateformes',                                   'id_semestre' => 1, 'id_filiere' => 9, 'id_enseignant' => 11],  // id_module 56 — Eljay
            ['code_module' => 'MEEC-S1-M3', 'nom_module' => 'Réseaux Sociaux et Community Management',                    'id_semestre' => 1, 'id_filiere' => 9, 'id_enseignant' => 20],  // id_module 57 — Benomar

            // ── MEEC — S2 (id_semestre 2, ouvert) ────────────────────────
            ['code_module' => 'MEEC-S2-M1', 'nom_module' => 'SEO / SEM et Publicité en Ligne',                            'id_semestre' => 2, 'id_filiere' => 9, 'id_enseignant' => 20],  // id_module 58 — Benomar
            ['code_module' => 'MEEC-S2-M2', 'nom_module' => 'Gestion de Projet Digital',                                  'id_semestre' => 2, 'id_filiere' => 9, 'id_enseignant' => 17],  // id_module 59 — Chaanoun
            ['code_module' => 'MEEC-S2-M3', 'nom_module' => 'Analyse des Données Marketing',                              'id_semestre' => 2, 'id_filiere' => 9, 'id_enseignant' => 19],  // id_module 60 — Tazi

            // ── BFEBI — S1 (id_semestre 1, clôturé) ──────────────────────
            ['code_module' => 'BFEBI-S1-M1','nom_module' => 'Finance d\'Entreprise Avancée',                               'id_semestre' => 1, 'id_filiere' => 10, 'id_enseignant' => 19],  // id_module 61 — Tazi
            ['code_module' => 'BFEBI-S1-M2','nom_module' => 'Business Intelligence et Tableaux de Bord',                  'id_semestre' => 1, 'id_filiere' => 10, 'id_enseignant' => 19],  // id_module 62 — Tazi
            ['code_module' => 'BFEBI-S1-M3','nom_module' => 'Marchés Financiers',                                         'id_semestre' => 1, 'id_filiere' => 10, 'id_enseignant' => 11],  // id_module 63 — Eljay

            // ── BFEBI — S2 (id_semestre 2, ouvert) ───────────────────────
            ['code_module' => 'BFEBI-S2-M1','nom_module' => 'Analyse Financière et Reporting',                             'id_semestre' => 2, 'id_filiere' => 10, 'id_enseignant' => 19],  // id_module 64 — Tazi
            ['code_module' => 'BFEBI-S2-M2','nom_module' => 'Big Data pour la Finance',                                   'id_semestre' => 2, 'id_filiere' => 10, 'id_enseignant' => 9],   // id_module 65 — Benali
            ['code_module' => 'BFEBI-S2-M3','nom_module' => 'Stratégie d\'Entreprise',                                    'id_semestre' => 2, 'id_filiere' => 10, 'id_enseignant' => 11],  // id_module 66 — Eljay

            // ── EER — S1 (id_semestre 1, clôturé) ────────────────────────
            ['code_module' => 'EER-S1-M1',  'nom_module' => 'Électricité et Circuits Électriques',                        'id_semestre' => 1, 'id_filiere' => 11, 'id_enseignant' => 21],  // id_module 67 — Qodad
            ['code_module' => 'EER-S1-M2',  'nom_module' => 'Énergies Renouvelables : Principes',                         'id_semestre' => 1, 'id_filiere' => 11, 'id_enseignant' => 22],  // id_module 68 — Hana
            ['code_module' => 'EER-S1-M3',  'nom_module' => 'Mathématiques pour l\'Ingénieur',                            'id_semestre' => 1, 'id_filiere' => 11, 'id_enseignant' => 30],  // id_module 69 — Sabri

            // ── EER — S2 (id_semestre 2, ouvert) ─────────────────────────
            ['code_module' => 'EER-S2-M1',  'nom_module' => 'Systèmes Photovoltaïques',                                   'id_semestre' => 2, 'id_filiere' => 11, 'id_enseignant' => 22],  // id_module 70 — Hana
            ['code_module' => 'EER-S2-M2',  'nom_module' => 'Électrotechnique Avancée',                                   'id_semestre' => 2, 'id_filiere' => 11, 'id_enseignant' => 21],  // id_module 71 — Qodad
            ['code_module' => 'EER-S2-M3',  'nom_module' => 'Automatisme et API',                                         'id_semestre' => 2, 'id_filiere' => 11, 'id_enseignant' => 24],  // id_module 72 — Tahiri

            // ── MI — S1 (id_semestre 1, clôturé) ─────────────────────────
            ['code_module' => 'MI-S1-M1',   'nom_module' => 'Mécanique et Résistance des Matériaux',                      'id_semestre' => 1, 'id_filiere' => 12, 'id_enseignant' => 23],  // id_module 73 — Filali
            ['code_module' => 'MI-S1-M2',   'nom_module' => 'Électronique Industrielle',                                  'id_semestre' => 1, 'id_filiere' => 12, 'id_enseignant' => 21],  // id_module 74 — Qodad
            ['code_module' => 'MI-S1-M3',   'nom_module' => 'Automatisation des Processus',                               'id_semestre' => 1, 'id_filiere' => 12, 'id_enseignant' => 24],  // id_module 75 — Tahiri

            // ── MI — S2 (id_semestre 2, ouvert) ──────────────────────────
            ['code_module' => 'MI-S2-M1',   'nom_module' => 'Robotique et Systèmes de Vision',                            'id_semestre' => 2, 'id_filiere' => 12, 'id_enseignant' => 23],  // id_module 76 — Filali
            ['code_module' => 'MI-S2-M2',   'nom_module' => 'Programmation d\'Automates',                                 'id_semestre' => 2, 'id_filiere' => 12, 'id_enseignant' => 24],  // id_module 77 — Tahiri
            ['code_module' => 'MI-S2-M3',   'nom_module' => 'Maintenance Industrielle',                                   'id_semestre' => 2, 'id_filiere' => 12, 'id_enseignant' => 27],  // id_module 78 — Boukhris

            // ── TA — S1 (id_semestre 1, clôturé) ─────────────────────────
            ['code_module' => 'TA-S1-M1',   'nom_module' => 'Moteurs Thermiques',                                         'id_semestre' => 1, 'id_filiere' => 13, 'id_enseignant' => 27],  // id_module 79 — Boukhris
            ['code_module' => 'TA-S1-M2',   'nom_module' => 'Systèmes Électriques des Véhicules',                         'id_semestre' => 1, 'id_filiere' => 13, 'id_enseignant' => 21],  // id_module 80 — Qodad
            ['code_module' => 'TA-S1-M3',   'nom_module' => 'Diagnostic Automobile',                                      'id_semestre' => 1, 'id_filiere' => 13, 'id_enseignant' => 27],  // id_module 81 — Boukhris

            // ── TA — S2 (id_semestre 2, ouvert) ──────────────────────────
            ['code_module' => 'TA-S2-M1',   'nom_module' => 'Technologies Véhicules Électriques',                         'id_semestre' => 2, 'id_filiere' => 13, 'id_enseignant' => 22],  // id_module 82 — Hana
            ['code_module' => 'TA-S2-M2',   'nom_module' => 'Gestion de Maintenance',                                     'id_semestre' => 2, 'id_filiere' => 13, 'id_enseignant' => 27],  // id_module 83 — Boukhris
            ['code_module' => 'TA-S2-M3',   'nom_module' => 'Transmission et Châssis',                                   'id_semestre' => 2, 'id_filiere' => 13, 'id_enseignant' => 28],  // id_module 84 — Cherkaoui

            // ── CPI — S1 (id_semestre 1, clôturé) ────────────────────────
            ['code_module' => 'CPI-S1-M1',  'nom_module' => 'CAO et Dessin Industriel',                                   'id_semestre' => 1, 'id_filiere' => 14, 'id_enseignant' => 26],  // id_module 85 — Mrani
            ['code_module' => 'CPI-S1-M2',  'nom_module' => 'Matériaux et Procédés de Fabrication',                       'id_semestre' => 1, 'id_filiere' => 14, 'id_enseignant' => 29],  // id_module 86 — Benyahia
            ['code_module' => 'CPI-S1-M3',  'nom_module' => 'Prototypage Rapide et Impression 3D',                        'id_semestre' => 1, 'id_filiere' => 14, 'id_enseignant' => 29],  // id_module 87 — Benyahia

            // ── CPI — S2 (id_semestre 2, ouvert) ─────────────────────────
            ['code_module' => 'CPI-S2-M1',  'nom_module' => 'Méthode des Éléments Finis',                                 'id_semestre' => 2, 'id_filiere' => 14, 'id_enseignant' => 30],  // id_module 88 — Sabri
            ['code_module' => 'CPI-S2-M2',  'nom_module' => 'Gestion de Projet Industriel',                               'id_semestre' => 2, 'id_filiere' => 14, 'id_enseignant' => 26],  // id_module 89 — Mrani
            ['code_module' => 'CPI-S2-M3',  'nom_module' => 'Simulation et Maquettage Numérique',                        'id_semestre' => 2, 'id_filiere' => 14, 'id_enseignant' => 26],  // id_module 90 — Mrani

            // ── BGCEE — S1 (id_semestre 1, clôturé) ──────────────────────
            ['code_module' => 'BGCEE-S1-M1','nom_module' => 'Matériaux de Construction',                                   'id_semestre' => 1, 'id_filiere' => 15, 'id_enseignant' => 25],  // id_module 91 — Ouali
            ['code_module' => 'BGCEE-S1-M2','nom_module' => 'Résistance des Matériaux et Structures',                     'id_semestre' => 1, 'id_filiere' => 15, 'id_enseignant' => 25],  // id_module 92 — Ouali
            ['code_module' => 'BGCEE-S1-M3','nom_module' => 'Thermique des Bâtiments et Efficacité Énergétique',          'id_semestre' => 1, 'id_filiere' => 15, 'id_enseignant' => 28],  // id_module 93 — Cherkaoui

            // ── BGCEE — S2 (id_semestre 2, ouvert) ───────────────────────
            ['code_module' => 'BGCEE-S2-M1','nom_module' => 'Gestion et Suivi de Chantier',                               'id_semestre' => 2, 'id_filiere' => 15, 'id_enseignant' => 25],  // id_module 94 — Ouali
            ['code_module' => 'BGCEE-S2-M2','nom_module' => 'Énergies Renouvelables dans le Bâtiment',                    'id_semestre' => 2, 'id_filiere' => 15, 'id_enseignant' => 22],  // id_module 95 — Hana
            ['code_module' => 'BGCEE-S2-M3','nom_module' => 'BIM (Building Information Modeling)',                        'id_semestre' => 2, 'id_filiere' => 15, 'id_enseignant' => 25],  // id_module 96 — Ouali

            // ── SIID — S1 (id_semestre 1, clôturé) ───────────────────────
            ['code_module' => 'SIID-S1-M1', 'nom_module' => 'Modélisation des Systèmes d\'Information',                   'id_semestre' => 1, 'id_filiere' => 5, 'id_enseignant' => 1],    // id_module 97  — Serghini
            ['code_module' => 'SIID-S1-M2', 'nom_module' => 'Big Data et Hadoop',                                         'id_semestre' => 1, 'id_filiere' => 5, 'id_enseignant' => 9],    // id_module 98  — Benali
            ['code_module' => 'SIID-S1-M3', 'nom_module' => 'Data Warehouse et ETL',                                      'id_semestre' => 1, 'id_filiere' => 5, 'id_enseignant' => 5],    // id_module 99  — Elbeqqal

            // ── SIID — S2 (id_semestre 2, ouvert) ────────────────────────
            ['code_module' => 'SIID-S2-M1', 'nom_module' => 'NoSQL et Bases de Données Distribuées',                      'id_semestre' => 2, 'id_filiere' => 5, 'id_enseignant' => 5],    // id_module 100 — Elbeqqal
            ['code_module' => 'SIID-S2-M2', 'nom_module' => 'Gouvernance et Qualité des Données',                         'id_semestre' => 2, 'id_filiere' => 5, 'id_enseignant' => 9],    // id_module 101 — Benali
            ['code_module' => 'SIID-S2-M3', 'nom_module' => 'Cloud Computing et Déploiement',                             'id_semestre' => 2, 'id_filiere' => 5, 'id_enseignant' => 7],    // id_module 102 — Idrissi

            // ── GIE — S1 (id_semestre 1, clôturé) ────────────────────────
            ['code_module' => 'GIE-S1-M1',  'nom_module' => 'Architecture des Systèmes Embarqués',                        'id_semestre' => 1, 'id_filiere' => 4, 'id_enseignant' => 7],    // id_module 103 — Idrissi
            ['code_module' => 'GIE-S1-M2',  'nom_module' => 'Programmation C pour Microcontrôleurs',                      'id_semestre' => 1, 'id_filiere' => 4, 'id_enseignant' => 7],    // id_module 104 — Idrissi
            ['code_module' => 'GIE-S1-M3',  'nom_module' => 'Électronique Numérique',                                     'id_semestre' => 1, 'id_filiere' => 4, 'id_enseignant' => 8],    // id_module 105 — Amine

            // ── GIE — S2 (id_semestre 2, ouvert) ─────────────────────────
            ['code_module' => 'GIE-S2-M1',  'nom_module' => 'Systèmes Temps Réel et RTOS',                                'id_semestre' => 2, 'id_filiere' => 4, 'id_enseignant' => 7],    // id_module 106 — Idrissi
            ['code_module' => 'GIE-S2-M2',  'nom_module' => 'IoT et Protocoles de Communication',                         'id_semestre' => 2, 'id_filiere' => 4, 'id_enseignant' => 3],    // id_module 107 — Khriss
            ['code_module' => 'GIE-S2-M3',  'nom_module' => 'Sécurité des Systèmes Embarqués',                            'id_semestre' => 2, 'id_filiere' => 4, 'id_enseignant' => 3],    // id_module 108 — Khriss
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 9. INTERVENIR (co-intervenants — enseignants additionnels par module)
        // ═══════════════════════════════════════════════════════════════════
        // Un enseignant peut co-intervenir sur un module dont il n'est pas le responsable principal.
        // On utilise des modules concrets et des enseignants du même département.
        DB::table('intervenir')->insert([
            // CDL
            ['id_enseignant' => 2,  'id_module' => 6],   // Berrahal co-intervient sur Algorithmique CDL-S1
            ['id_enseignant' => 8,  'id_module' => 4],   // Amine co-intervient sur Dev Web Front End CDL-S1
            // IDIA
            ['id_enseignant' => 9,  'id_module' => 12],  // Benali co-intervient sur ML CDL-S1
            ['id_enseignant' => 3,  'id_module' => 21],  // Khriss co-intervient sur Réseaux IDIA-S2
            // Web Design
            ['id_enseignant' => 1,  'id_module' => 25],  // Serghini co-intervient sur Réseaux & Sécurité WD-S1
            // IGE
            ['id_enseignant' => 12, 'id_module' => 34],  // Missaoui co-intervient sur Marketing IGE-S1
            ['id_enseignant' => 16, 'id_module' => 38],  // Elhila co-intervient sur Langues IGE-S1
            // EER
            ['id_enseignant' => 30, 'id_module' => 72],  // Sabri co-intervient sur Automatisme EER-S2
            // MI
            ['id_enseignant' => 22, 'id_module' => 75],  // Hana co-intervient sur Automatisation MI-S1
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 10. INSCRIRE (inscriptions étudiants ↔ semestres)
        // ═══════════════════════════════════════════════════════════════════
        // Un étudiant est inscrit dans un ou deux semestres (S1 passé + S2 actuel).
        DB::table('inscrire')->insert([

            // ── CDL students ──────────────────────────────────────────────
            ['id_etudiant' => 1,  'id_semestre' => 1],  // Bellatrach — S1 (clôturé)
            ['id_etudiant' => 1,  'id_semestre' => 2],  // Bellatrach — S2 (ouvert)
            ['id_etudiant' => 2,  'id_semestre' => 1],  // Elmir — S1
            ['id_etudiant' => 2,  'id_semestre' => 2],  // Elmir — S2
            ['id_etudiant' => 3,  'id_semestre' => 1],  // Chehlafi — S1
            ['id_etudiant' => 3,  'id_semestre' => 2],  // Chehlafi — S2
            ['id_etudiant' => 4,  'id_semestre' => 1],  // Lamrani (inactive) — S1 only
            ['id_etudiant' => 5,  'id_semestre' => 3],  // Belhit — S3 (clôturé, 2ème année)
            ['id_etudiant' => 5,  'id_semestre' => 4],  // Belhit — S4 (ouvert)
            ['id_etudiant' => 6,  'id_semestre' => 3],  // Khaldi — S3
            ['id_etudiant' => 6,  'id_semestre' => 4],  // Khaldi — S4
            ['id_etudiant' => 7,  'id_semestre' => 3],  // Abarkani — S3
            ['id_etudiant' => 7,  'id_semestre' => 4],  // Abarkani — S4
            ['id_etudiant' => 8,  'id_semestre' => 3],  // Eddahem (inactive) — S3 only

            // ── IDIA students ─────────────────────────────────────────────
            ['id_etudiant' => 9,  'id_semestre' => 1],  // Kamal — S1
            ['id_etudiant' => 9,  'id_semestre' => 2],  // Kamal — S2
            ['id_etudiant' => 10, 'id_semestre' => 1],  // Nadir — S1
            ['id_etudiant' => 10, 'id_semestre' => 2],  // Nadir — S2
            ['id_etudiant' => 11, 'id_semestre' => 1],  // Alami — S1
            ['id_etudiant' => 11, 'id_semestre' => 2],  // Alami — S2
            ['id_etudiant' => 12, 'id_semestre' => 1],  // Senhaji — S1
            ['id_etudiant' => 13, 'id_semestre' => 1],  // Haddad (inactive) — S1 only

            // ── Web Design students ───────────────────────────────────────
            ['id_etudiant' => 14, 'id_semestre' => 1],  // Ouahbi — S1
            ['id_etudiant' => 14, 'id_semestre' => 2],  // Ouahbi — S2
            ['id_etudiant' => 15, 'id_semestre' => 1],  // Lazrak — S1
            ['id_etudiant' => 15, 'id_semestre' => 2],  // Lazrak — S2
            ['id_etudiant' => 16, 'id_semestre' => 1],  // Ghazali — S1
            ['id_etudiant' => 16, 'id_semestre' => 2],  // Ghazali — S2
            ['id_etudiant' => 17, 'id_semestre' => 1],  // Mekki (inactive) — S1 only
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 11. NOTES
        // ═══════════════════════════════════════════════════════════════════
        // On enregistre uniquement les notes des semestres clôturés (S1 et S3).
        // Les semestres ouverts (S2, S4) n'ont pas encore de notes.
        // Règle : note < 10 → rattrapage renseigné ; note >= 10 → rattrapage null
        DB::table('note')->insert([

            // ── CDL — S1 — Bellatrach (id_etudiant 1) ────────────────────
            ['id_etudiant' => 1,  'id_module' => 1,  'note' => 14.50, 'rattrapage' => null],   // Algèbre
            ['id_etudiant' => 1,  'id_module' => 2,  'note' => 12.00, 'rattrapage' => null],   // Intro IA
            ['id_etudiant' => 1,  'id_module' => 3,  'note' => 16.00, 'rattrapage' => null],   // SI & BDD
            ['id_etudiant' => 1,  'id_module' => 4,  'note' =>  9.00, 'rattrapage' => 11.00],  // Dev Web (rattrapé)
            ['id_etudiant' => 1,  'id_module' => 5,  'note' => 13.50, 'rattrapage' => null],   // Stats
            ['id_etudiant' => 1,  'id_module' => 6,  'note' => 15.00, 'rattrapage' => null],   // Algo & C
            ['id_etudiant' => 1,  'id_module' => 7,  'note' => 11.00, 'rattrapage' => null],   // Français

            // ── CDL — S1 — Elmir (id_etudiant 2) ─────────────────────────
            ['id_etudiant' => 2,  'id_module' => 1,  'note' =>  8.00, 'rattrapage' => 10.50],  // Algèbre (rattrapé)
            ['id_etudiant' => 2,  'id_module' => 2,  'note' => 11.00, 'rattrapage' => null],   // Intro IA
            ['id_etudiant' => 2,  'id_module' => 3,  'note' => 13.00, 'rattrapage' => null],   // SI & BDD
            ['id_etudiant' => 2,  'id_module' => 4,  'note' =>  7.50, 'rattrapage' =>  9.00],  // Dev Web (rattrapé mais <10 encore)
            ['id_etudiant' => 2,  'id_module' => 5,  'note' => 10.00, 'rattrapage' => null],   // Stats
            ['id_etudiant' => 2,  'id_module' => 6,  'note' => 14.00, 'rattrapage' => null],   // Algo & C
            ['id_etudiant' => 2,  'id_module' => 7,  'note' => 12.00, 'rattrapage' => null],   // Français

            // ── CDL — S1 — Chehlafi (id_etudiant 3) ──────────────────────
            ['id_etudiant' => 3,  'id_module' => 1,  'note' => 17.00, 'rattrapage' => null],   // Algèbre
            ['id_etudiant' => 3,  'id_module' => 2,  'note' => 15.50, 'rattrapage' => null],   // Intro IA
            ['id_etudiant' => 3,  'id_module' => 3,  'note' => 14.00, 'rattrapage' => null],   // SI & BDD
            ['id_etudiant' => 3,  'id_module' => 4,  'note' => 13.00, 'rattrapage' => null],   // Dev Web
            ['id_etudiant' => 3,  'id_module' => 5,  'note' => 16.00, 'rattrapage' => null],   // Stats
            ['id_etudiant' => 3,  'id_module' => 6,  'note' => 18.00, 'rattrapage' => null],   // Algo & C
            ['id_etudiant' => 3,  'id_module' => 7,  'note' => 14.50, 'rattrapage' => null],   // Français

            // ── IDIA — S1 — Kamal (id_etudiant 9) ────────────────────────
            ['id_etudiant' => 9,  'id_module' => 12, 'note' => 15.00, 'rattrapage' => null],   // ML
            ['id_etudiant' => 9,  'id_module' => 13, 'note' => 13.00, 'rattrapage' => null],   // Intro IA
            ['id_etudiant' => 9,  'id_module' => 14, 'note' => 16.00, 'rattrapage' => null],   // Python
            ['id_etudiant' => 9,  'id_module' => 15, 'note' =>  9.50, 'rattrapage' => 11.50],  // Algèbre linéaire (rattrapé)
            ['id_etudiant' => 9,  'id_module' => 16, 'note' => 14.00, 'rattrapage' => null],   // Langues
            ['id_etudiant' => 9,  'id_module' => 17, 'note' => 12.00, 'rattrapage' => null],   // Dev Web

            // ── IDIA — S1 — Nadir (id_etudiant 10) ───────────────────────
            ['id_etudiant' => 10, 'id_module' => 12, 'note' => 18.00, 'rattrapage' => null],   // ML
            ['id_etudiant' => 10, 'id_module' => 13, 'note' => 17.00, 'rattrapage' => null],   // Intro IA
            ['id_etudiant' => 10, 'id_module' => 14, 'note' => 19.00, 'rattrapage' => null],   // Python
            ['id_etudiant' => 10, 'id_module' => 15, 'note' => 16.00, 'rattrapage' => null],   // Algèbre linéaire
            ['id_etudiant' => 10, 'id_module' => 16, 'note' => 15.00, 'rattrapage' => null],   // Langues
            ['id_etudiant' => 10, 'id_module' => 17, 'note' => 14.00, 'rattrapage' => null],   // Dev Web

            // ── IDIA — S1 — Alami (id_etudiant 11) ───────────────────────
            ['id_etudiant' => 11, 'id_module' => 12, 'note' =>  7.00, 'rattrapage' =>  9.50],  // ML (rattrapé <10)
            ['id_etudiant' => 11, 'id_module' => 13, 'note' => 11.00, 'rattrapage' => null],   // Intro IA
            ['id_etudiant' => 11, 'id_module' => 14, 'note' => 13.00, 'rattrapage' => null],   // Python
            ['id_etudiant' => 11, 'id_module' => 15, 'note' =>  8.00, 'rattrapage' => 10.00],  // Algèbre linéaire (rattrapé)
            ['id_etudiant' => 11, 'id_module' => 16, 'note' => 12.00, 'rattrapage' => null],   // Langues
            ['id_etudiant' => 11, 'id_module' => 17, 'note' => 10.50, 'rattrapage' => null],   // Dev Web

            // ── Web Design — S1 — Ouahbi (id_etudiant 14) ────────────────
            ['id_etudiant' => 14, 'id_module' => 22, 'note' => 16.00, 'rattrapage' => null],   // UX Design
            ['id_etudiant' => 14, 'id_module' => 23, 'note' => 14.00, 'rattrapage' => null],   // Digital Marketing
            ['id_etudiant' => 14, 'id_module' => 24, 'note' => 11.00, 'rattrapage' => null],   // Linux
            ['id_etudiant' => 14, 'id_module' => 25, 'note' =>  8.50, 'rattrapage' => 10.50],  // Réseaux & Sécurité (rattrapé)
            ['id_etudiant' => 14, 'id_module' => 26, 'note' => 15.00, 'rattrapage' => null],   // Culture Digitale
            ['id_etudiant' => 14, 'id_module' => 27, 'note' => 13.00, 'rattrapage' => null],   // PHP & MySQL
            ['id_etudiant' => 14, 'id_module' => 28, 'note' => 12.00, 'rattrapage' => null],   // Langue Française

            // ── Web Design — S1 — Lazrak (id_etudiant 15) ────────────────
            ['id_etudiant' => 15, 'id_module' => 22, 'note' => 13.00, 'rattrapage' => null],   // UX Design
            ['id_etudiant' => 15, 'id_module' => 23, 'note' => 15.00, 'rattrapage' => null],   // Digital Marketing
            ['id_etudiant' => 15, 'id_module' => 24, 'note' =>  9.00, 'rattrapage' => 11.00],  // Linux (rattrapé)
            ['id_etudiant' => 15, 'id_module' => 25, 'note' => 10.00, 'rattrapage' => null],   // Réseaux & Sécurité
            ['id_etudiant' => 15, 'id_module' => 26, 'note' => 14.00, 'rattrapage' => null],   // Culture Digitale
            ['id_etudiant' => 15, 'id_module' => 27, 'note' => 16.50, 'rattrapage' => null],   // PHP & MySQL
            ['id_etudiant' => 15, 'id_module' => 28, 'note' => 11.00, 'rattrapage' => null],   // Langue Française
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 12. RÉCLAMATIONS
        // ═══════════════════════════════════════════════════════════════════
        // Les réclamations portent sur des notes existantes (id_note auto-incrémenté).
        // id_note 4 = Bellatrach/Dev Web (note 9.00 → rattrapage 11.00)
        // id_note 8 = Elmir/Dev Web (note 7.50 → rattrapage 9.00)
        // id_note 25 = Ouahbi/Réseaux & Sécurité
        DB::table('reclamation')->insert([
            [
                'message'          => "Ma note de Développement Web semble incorrecte, je demande une vérification.",
                'date_reclamation' => '2024-02-01 10:30:00',
                'id_note'          => 4,  // Bellatrach — Dev Web Front End CDL-S1
            ],
            [
                'message'          => "Ma note CC Développement Web est trop basse, possible erreur de saisie.",
                'date_reclamation' => '2024-01-25 14:00:00',
                'id_note'          => 8,  // Elmir — Dev Web Front End CDL-S1
            ],
            [
                'message'          => "Je conteste ma note de Réseaux et Sécurité, j'avais bien rendu l'examen.",
                'date_reclamation' => '2024-02-10 09:15:00',
                'id_note'          => 25, // Ouahbi — Réseaux & Sécurité WD-S1
            ],
        ]);

        // ═══════════════════════════════════════════════════════════════════
        // 13. LOG ACTIONS
        // ═══════════════════════════════════════════════════════════════════
        // Historique des actions effectuées par les utilisateurs sur les données.
        DB::table('log_action')->insert([
            ['action' => 'CREATE', 'table_concernee' => 'etudiant',     'id_enregistrement' => 1,  'id_user' => 1, 'date_action' => now()],  // Admin crée Bellatrach
            ['action' => 'CREATE', 'table_concernee' => 'etudiant',     'id_enregistrement' => 9,  'id_user' => 1, 'date_action' => now()],  // Admin crée Kamal (IDIA)
            ['action' => 'CREATE', 'table_concernee' => 'etudiant',     'id_enregistrement' => 14, 'id_user' => 1, 'date_action' => now()],  // Admin crée Ouahbi (WD)
            ['action' => 'UPDATE', 'table_concernee' => 'note',         'id_enregistrement' => 4,  'id_user' => 2, 'date_action' => now()],  // Serghini met à jour note Bellatrach
            ['action' => 'UPDATE', 'table_concernee' => 'note',         'id_enregistrement' => 8,  'id_user' => 2, 'date_action' => now()],  // Serghini met à jour note Elmir
            ['action' => 'UPDATE', 'table_concernee' => 'reclamation',  'id_enregistrement' => 1,  'id_user' => 1, 'date_action' => now()],  // Admin traite réclamation #1
            ['action' => 'CREATE', 'table_concernee' => 'inscrire',     'id_enregistrement' => 15, 'id_user' => 1, 'date_action' => now()],  // Admin inscrit Kamal
            ['action' => 'CREATE', 'table_concernee' => 'inscrire',     'id_enregistrement' => 24, 'id_user' => 1, 'date_action' => now()],  // Admin inscrit Ouahbi
        ]);
    }
}