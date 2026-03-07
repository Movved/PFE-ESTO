<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {

        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nom', 40);
            $table->string('prenom', 40);
            $table->string('email', 255)->unique();
            $table->string('mot_de_passe', 255);
            $table->string('role', 50);
            $table->boolean('actif');
            $table->dateTime('date_creation')->useCurrent();
        });

        Schema::create('departements', function (Blueprint $table) {
            $table->id('id_departement');
            $table->string('nom_departement', 50);
        });

        Schema::create('enseignants', function (Blueprint $table) {
            $table->id('id_enseignant');
            $table->string('specialite', 50);
            $table->boolean('is_chef');
            $table->unsignedBigInteger('id_departement');
            $table->unsignedBigInteger('id_user');

            $table->unique('id_user');
            $table->foreign('id_departement')->references('id_departement')->on('departements')->cascadeOnDelete();
            $table->foreign('id_user')->references('id_user')->on('utilisateurs')->cascadeOnDelete();
        });

        Schema::create('etudiants', function (Blueprint $table) {
            $table->id('id_etudiant');
            $table->string('cne', 20)->unique();
            $table->unsignedBigInteger('id_user');

            $table->unique('id_user');
            $table->foreign('id_user')->references('id_user')->on('utilisateurs')->cascadeOnDelete();
        });

        Schema::create('filieres', function (Blueprint $table) {
            $table->id('id_filiere');
            $table->string('nom_filiere', 50)->unique();
            $table->text('description');
            $table->unsignedBigInteger('id_departement');

            $table->foreign('id_departement')->references('id_departement')->on('departements')->cascadeOnDelete();
        });

        Schema::create('annees_academiques', function (Blueprint $table) {
            $table->id('id_annee');
            $table->string('libelle', 20);
            $table->unsignedBigInteger('id_filiere');

            $table->foreign('id_filiere')->references('id_filiere')->on('filieres')->cascadeOnDelete();
        });

        Schema::create('semestres', function (Blueprint $table) {
            $table->id('id_semestre');
            $table->integer('numero');
            $table->boolean('cloture');
            $table->unsignedBigInteger('id_annee');

            $table->foreign('id_annee')->references('id_annee')->on('annees_academiques')->cascadeOnDelete();
        });
        DB::statement('ALTER TABLE semestres ADD CONSTRAINT chk_numero CHECK (numero IN (1,2))');

        Schema::create('modules', function (Blueprint $table) {
            $table->id('id_module');
            $table->string('code_module', 20)->unique();
            $table->string('nom_module', 50);
            $table->unsignedBigInteger('id_semestre');
            $table->unsignedBigInteger('id_enseignant');

            $table->foreign('id_semestre')->references('id_semestre')->on('semestres')->cascadeOnDelete();
            $table->foreign('id_enseignant')->references('id_enseignant')->on('enseignants')->cascadeOnDelete();
        });

        Schema::create('notes', function (Blueprint $table) {
            $table->id('id_note');
            $table->decimal('note', 4, 2)->nullable();
            $table->decimal('rattrapage', 4, 2)->nullable();
            $table->unsignedBigInteger('id_etudiant');
            $table->unsignedBigInteger('id_module');

            $table->unique(['id_etudiant', 'id_module']);
            $table->foreign('id_etudiant')->references('id_etudiant')->on('etudiants')->cascadeOnDelete();
            $table->foreign('id_module')->references('id_module')->on('modules')->cascadeOnDelete();
        });

        Schema::create('reclamations', function (Blueprint $table) {
            $table->id('id_reclamation');
            $table->text('message')->nullable();
            $table->dateTime('date_reclamation')->nullable();
            $table->unsignedBigInteger('id_note');

            $table->foreign('id_note')->references('id_note')->on('notes')->cascadeOnDelete();
        });

        Schema::create('log_actions', function (Blueprint $table) {
            $table->id('id_logs');
            $table->string('action', 100);
            $table->string('table_concernee', 50);
            $table->integer('id_enregistrement');
            $table->dateTime('date_action');
            $table->unsignedBigInteger('id_user');

            $table->foreign('id_user')->references('id_user')->on('utilisateurs')->cascadeOnDelete();
        });

        
        Schema::create('intervenir', function (Blueprint $table) {
            $table->unsignedBigInteger('id_enseignant');
            $table->unsignedBigInteger('id_module');

            $table->primary(['id_enseignant', 'id_module']);
            $table->foreign('id_enseignant')->references('id_enseignant')->on('enseignants')->cascadeOnDelete();
            $table->foreign('id_module')->references('id_module')->on('modules')->cascadeOnDelete();
        });

        
        Schema::create('inscrire', function (Blueprint $table) {
            $table->unsignedBigInteger('id_etudiant');
            $table->unsignedBigInteger('id_semestre');

            $table->primary(['id_etudiant', 'id_semestre']);
            $table->foreign('id_etudiant')->references('id_etudiant')->on('etudiants')->cascadeOnDelete();
            $table->foreign('id_semestre')->references('id_semestre')->on('semestres')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('inscrire');
        Schema::dropIfExists('intervenir');
        Schema::dropIfExists('log_actions');
        Schema::dropIfExists('reclamations');
        Schema::dropIfExists('notes');
        Schema::dropIfExists('modules');
        Schema::dropIfExists('semestres');
        Schema::dropIfExists('annees_academiques');
        Schema::dropIfExists('filieres');
        Schema::dropIfExists('etudiants');
        Schema::dropIfExists('enseignants');
        Schema::dropIfExists('departements');
        Schema::dropIfExists('utilisateurs');
    }
};