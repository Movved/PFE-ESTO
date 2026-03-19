<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {

        Schema::create('utilisateur', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nom', 40);
            $table->string('prenom', 40);
            $table->string('email', 255)->unique();
            $table->string('mot_de_passe', 255);
            $table->string('role', 50);
            $table->boolean('actif');
            $table->dateTime('date_creation')->useCurrent();
        });

        Schema::create('departement', function (Blueprint $table) {
            $table->id('id_departement');
            $table->string('nom_departement', 50);
        });

        Schema::create('enseignant', function (Blueprint $table) {
            $table->id('id_enseignant');
            $table->string('specialite', 100); // ← agrandi de 50→100 (ex: "Systèmes d'Information")
            $table->boolean('is_chef');
            $table->unsignedBigInteger('id_departement');
            $table->unsignedBigInteger('id_user');

            $table->unique('id_user');
            $table->foreign('id_departement')->references('id_departement')->on('departement')->cascadeOnDelete();
            $table->foreign('id_user')->references('id_user')->on('utilisateur')->cascadeOnDelete();
        });

        Schema::create('etudiant', function (Blueprint $table) {
            $table->id('id_etudiant');
            $table->string('cne', 20)->unique();
            $table->unsignedBigInteger('id_user');

            $table->unique('id_user');
            $table->foreign('id_user')->references('id_user')->on('utilisateur')->cascadeOnDelete();
        });

        Schema::create('filiere', function (Blueprint $table) {
            $table->id('id_filiere');
            $table->string('nom_filiere', 255)->unique(); // ← agrandi de 50→255 (noms longs)
            $table->text('description');
            $table->unsignedBigInteger('id_departement');

            $table->foreign('id_departement')->references('id_departement')->on('departement')->cascadeOnDelete();
        });

        Schema::create('annee_academique', function (Blueprint $table) {
            $table->id('id_annee');
            $table->string('libelle', 20);
            // FIX: id_filiere supprimé — une année académique est globale,
            //      elle ne doit pas appartenir à une seule filière.
            //      La relation filière↔année se fait via semestre→module→filière.
        });

        Schema::create('semestre', function (Blueprint $table) {
            $table->id('id_semestre');
            $table->integer('numero'); // valeurs possibles : 1, 2, 3, 4
            $table->boolean('cloture');
            $table->unsignedBigInteger('id_annee');

            $table->foreign('id_annee')->references('id_annee')->on('annee_academique')->cascadeOnDelete();
        });
        // FIX: contrainte élargie à (1,2,3,4) — l'original bloquait S3 et S4
        DB::statement('ALTER TABLE semestre ADD CONSTRAINT chk_numero CHECK (numero IN (1,2,3,4))');

        Schema::create('module', function (Blueprint $table) {
            $table->id('id_module');
            $table->string('code_module', 30)->unique(); // ← agrandi 20→30 (ex: 'BGCEE-S2-M3' = 11 chars)
            $table->string('nom_module', 255);           // ← agrandi 50→255 (noms de modules longs)
            $table->unsignedBigInteger('id_semestre');
            $table->unsignedBigInteger('id_filiere')->nullable(); // FIX: ajouté — lien optionnel filière↔module
            $table->unsignedBigInteger('id_enseignant');

            $table->foreign('id_semestre')->references('id_semestre')->on('semestre')->cascadeOnDelete();
            $table->foreign('id_filiere')->references('id_filiere')->on('filiere')->nullOnDelete(); // nullable donc nullOnDelete
            $table->foreign('id_enseignant')->references('id_enseignant')->on('enseignant')->cascadeOnDelete();
        });

        Schema::create('note', function (Blueprint $table) {
            $table->id('id_note');
            $table->decimal('note', 4, 2)->nullable();
            $table->decimal('rattrapage', 4, 2)->nullable();
            $table->unsignedBigInteger('id_etudiant');
            $table->unsignedBigInteger('id_module');

            $table->unique(['id_etudiant', 'id_module']);
            $table->foreign('id_etudiant')->references('id_etudiant')->on('etudiant')->cascadeOnDelete();
            $table->foreign('id_module')->references('id_module')->on('module')->cascadeOnDelete();
        });

        Schema::create('reclamation', function (Blueprint $table) {
            $table->id('id_reclamation');
            $table->text('message')->nullable();
            $table->dateTime('date_reclamation')->nullable();
            $table->unsignedBigInteger('id_note');

            $table->foreign('id_note')->references('id_note')->on('note')->cascadeOnDelete();
        });

        Schema::create('log_action', function (Blueprint $table) {
            $table->id('id_logs');
            $table->string('action', 100);
            $table->string('table_concernee', 50);
            $table->integer('id_enregistrement');
            $table->dateTime('date_action');
            $table->unsignedBigInteger('id_user');

            $table->foreign('id_user')->references('id_user')->on('utilisateur')->cascadeOnDelete();
        });

        Schema::create('intervenir', function (Blueprint $table) {
            $table->unsignedBigInteger('id_enseignant');
            $table->unsignedBigInteger('id_module');

            $table->primary(['id_enseignant', 'id_module']);
            $table->foreign('id_enseignant')->references('id_enseignant')->on('enseignant')->cascadeOnDelete();
            $table->foreign('id_module')->references('id_module')->on('module')->cascadeOnDelete();
        });

        Schema::create('inscrire', function (Blueprint $table) {
            $table->unsignedBigInteger('id_etudiant');
            $table->unsignedBigInteger('id_semestre');

            $table->primary(['id_etudiant', 'id_semestre']);
            $table->foreign('id_etudiant')->references('id_etudiant')->on('etudiant')->cascadeOnDelete();
            $table->foreign('id_semestre')->references('id_semestre')->on('semestre')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('inscrire');
        Schema::dropIfExists('intervenir');
        Schema::dropIfExists('log_action');
        Schema::dropIfExists('reclamation');
        Schema::dropIfExists('note');
        Schema::dropIfExists('module');
        Schema::dropIfExists('semestre');
        Schema::dropIfExists('annee_academique');
        Schema::dropIfExists('filiere');
        Schema::dropIfExists('etudiant');
        Schema::dropIfExists('enseignant');
        Schema::dropIfExists('departement');
        Schema::dropIfExists('utilisateur');
    }
};