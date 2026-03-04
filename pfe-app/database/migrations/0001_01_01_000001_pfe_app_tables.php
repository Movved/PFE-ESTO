<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nom', 40);
            $table->string('prenom', 40);
            $table->string('email', 50)->unique();
            $table->string('mot_de_passe', 255);
            $table->enum('role', ['ADMIN', 'ENSEIGNANT', 'ETUDIANT']);
            $table->boolean('actif')->default(true);
            $table->dateTime('date_creation')->useCurrent();
        });

        Schema::create('enseignants', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->primary();
            $table->string('specialite', 100);
            $table->string('departement', 100);
            $table->boolean('is_chef')->default(false);

            $table->foreign('id_user')
                  ->references('id_user')->on('utilisateurs')
                  ->cascadeOnDelete();
        });

        Schema::create('filieres', function (Blueprint $table) {
            $table->id('id_filiere');
            $table->string('nom_filiere', 100)->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('responsable_id');

            $table->foreign('responsable_id')
                  ->references('id_user')->on('enseignants')
                  ->restrictOnDelete();
        });

        Schema::create('annees_academiques', function (Blueprint $table) {
            $table->id('id_annee');
            $table->string('libelle', 20);  
            $table->unsignedBigInteger('id_filiere');

            $table->foreign('id_filiere')
                  ->references('id_filiere')->on('filieres')
                  ->cascadeOnDelete();
        });

        Schema::create('semestres', function (Blueprint $table) {
            $table->id('id_semestre');
            $table->unsignedTinyInteger('numero');
            $table->boolean('cloture')->default(false);
            $table->unsignedBigInteger('id_annee');

            $table->foreign('id_annee')
                  ->references('id_annee')->on('annees_academiques')
                  ->cascadeOnDelete();
        });
        DB::statement('ALTER TABLE semestres ADD CONSTRAINT chk_numero CHECK (numero IN (1,2))');

        Schema::create('modules', function (Blueprint $table) {
            $table->id('id_module');
            $table->string('code_module', 20)->unique();
            $table->string('nom_module', 100);
            $table->unsignedBigInteger('id_semestre');

            $table->foreign('id_semestre')
                  ->references('id_semestre')->on('semestres')
                  ->cascadeOnDelete();
        });

        Schema::create('enseignements', function (Blueprint $table) {
            $table->id('id_enseignement');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_module');

            $table->unique(['id_user', 'id_module']);

            $table->foreign('id_user')
                  ->references('id_user')->on('enseignants')
                  ->cascadeOnDelete();

            $table->foreign('id_module')
                  ->references('id_module')->on('modules')
                  ->cascadeOnDelete();
        });

        Schema::create('etudiants', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->primary();
            $table->string('cne', 20)->unique();
            $table->unsignedBigInteger('id_filiere');
            $table->integer('annee_actuelle');

            $table->foreign('id_user')
                  ->references('id_user')->on('utilisateurs')
                  ->cascadeOnDelete();

            $table->foreign('id_filiere')
                  ->references('id_filiere')->on('filieres')
                  ->restrictOnDelete();
        });

        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id('id_inscription');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_semestre');
            $table->dateTime('date_inscription')->useCurrent();

            $table->unique(['id_user', 'id_semestre']);

            $table->foreign('id_user')
                  ->references('id_user')->on('etudiants')
                  ->cascadeOnDelete();

            $table->foreign('id_semestre')
                  ->references('id_semestre')->on('semestres')
                  ->cascadeOnDelete();
        });

        Schema::create('evaluations', function (Blueprint $table) {
            $table->id('id_evaluation');
            $table->string('libelle', 100);
            $table->enum('type', ['CC', 'TP', 'EXAM']);
            $table->date('date_evaluation');
            $table->unsignedBigInteger('id_module');

            $table->foreign('id_module')
                  ->references('id_module')->on('modules')
                  ->cascadeOnDelete();
        });

        Schema::create('notes', function (Blueprint $table) {
            $table->id('id_note');
            $table->decimal('note', 5, 2)->nullable();
            $table->decimal('rattrapage', 5, 2)->nullable();
            $table->decimal('note_finale', 5, 2)->nullable();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_evaluation');

            $table->unique(['id_user', 'id_evaluation']);

            $table->foreign('id_user')
                  ->references('id_user')->on('etudiants')
                  ->cascadeOnDelete();

            $table->foreign('id_evaluation')
                  ->references('id_evaluation')->on('evaluations')
                  ->cascadeOnDelete();
        });
        Schema::create('reclamations', function (Blueprint $table) {
            $table->id('id_reclamation');
            $table->text('message');
            $table->dateTime('date_reclamation')->useCurrent();
            $table->enum('statut', ['EN_ATTENTE', 'TRAITEE', 'REJETEE'])->default('EN_ATTENTE');
            $table->unsignedBigInteger('id_note');
            $table->unsignedBigInteger('id_user');

            $table->foreign('id_note')
                  ->references('id_note')->on('notes')
                  ->cascadeOnDelete();

            $table->foreign('id_user')
                  ->references('id_user')->on('etudiants')
                  ->cascadeOnDelete();
        });

        Schema::create('log_actions', function (Blueprint $table) {
            $table->id('id_log');
            $table->string('action', 100);
            $table->string('table_concernee', 50);
            $table->integer('id_enregistrement')->nullable();
            $table->dateTime('date_action')->useCurrent();
            $table->unsignedBigInteger('id_user')->nullable();

            $table->foreign('id_user')
                  ->references('id_user')->on('utilisateurs')
                  ->nullOnDelete();
        });





    }

    public function down(): void {
        Schema::dropIfExists('utilisateurs');
        Schema::dropIfExists('enseignants');
        Schema::dropIfExists('filieres');
        Schema::dropIfExists('annees_academiques');
        Schema::dropIfExists('semestres');
        Schema::dropIfExists('modules');
        Schema::dropIfExists('enseignements');
        Schema::dropIfExists('etudiants');
        Schema::dropIfExists('inscriptions');
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('notes');
        Schema::dropIfExists('reclamations');
        Schema::dropIfExists('log_actions');

    }
};