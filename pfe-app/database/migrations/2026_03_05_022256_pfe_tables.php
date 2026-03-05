<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('utilisateur', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nom', 40);
            $table->string('prenom', 40);
            $table->string('email', 50)->unique();
            $table->string('mot_de_passe', 255);
            $table->enum('role', ['ADMIN', 'ENSEIGNANT', 'ETUDIANT']);
            $table->boolean('actif')->default(true);
            $table->dateTime('date_creation')->useCurrent();
        });

        Schema::create('enseignant', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->primary();
            $table->string('specialite', 100);
            $table->string('departement', 100);
            $table->boolean('is_chef')->default(false);

            $table->foreign('id_user')
                  ->references('id_user')->on('utilisateur')
                  ->onDelete('cascade');
        });

        Schema::create('filiere', function (Blueprint $table) {
            $table->id('id_filiere');
            $table->string('nom_filiere', 100)->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('responsable_id');

            $table->foreign('responsable_id')
                  ->references('id_user')->on('enseignant')
                  ->onDelete('restrict');
        });

        Schema::create('annee_academique', function (Blueprint $table) {
            $table->id('id_annee');
            $table->string('libelle', 20);
            $table->unsignedBigInteger('id_filiere');

            $table->foreign('id_filiere')
                  ->references('id_filiere')->on('filiere')
                  ->onDelete('cascade');
        });

        Schema::create('semestre', function (Blueprint $table) {
            $table->id('id_semestre');
            $table->unsignedTinyInteger('numero'); // 1 or 2
            $table->boolean('cloture')->default(false);
            $table->unsignedBigInteger('id_annee');

            $table->foreign('id_annee')
                  ->references('id_annee')->on('annee_academique')
                  ->onDelete('cascade');
        });

        Schema::create('module', function (Blueprint $table) {
            $table->id('id_module');
            $table->string('code_module', 20)->unique();
            $table->string('nom_module', 100);
            $table->unsignedBigInteger('id_semestre');

            $table->foreign('id_semestre')
                  ->references('id_semestre')->on('semestre')
                  ->onDelete('cascade');
        });

        Schema::create('enseignement', function (Blueprint $table) {
            $table->id('id_enseignement');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_module');

            $table->unique(['id_user', 'id_module']);

            $table->foreign('id_user')
                  ->references('id_user')->on('enseignant')
                  ->onDelete('cascade');

            $table->foreign('id_module')
                  ->references('id_module')->on('module')
                  ->onDelete('cascade');
        });

        Schema::create('etudiant', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->primary();
            $table->string('cne', 20)->unique();
            $table->unsignedBigInteger('id_filiere');
            $table->integer('annee_actuelle');

            $table->foreign('id_user')
                  ->references('id_user')->on('utilisateur')
                  ->onDelete('cascade');

            $table->foreign('id_filiere')
                  ->references('id_filiere')->on('filiere')
                  ->onDelete('restrict');
        });

        Schema::create('inscription', function (Blueprint $table) {
            $table->id('id_inscription');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_semestre');
            $table->dateTime('date_inscription')->useCurrent();

            $table->unique(['id_user', 'id_semestre']);

            $table->foreign('id_user')
                  ->references('id_user')->on('etudiant')
                  ->onDelete('cascade');

            $table->foreign('id_semestre')
                  ->references('id_semestre')->on('semestre')
                  ->onDelete('cascade');
        });

        Schema::create('evaluation', function (Blueprint $table) {
            $table->id('id_evaluation');
            $table->string('libelle', 100);
            $table->enum('type', ['CC', 'TP', 'EXAM']);
            $table->date('date_evaluation');
            $table->unsignedBigInteger('id_module');

            $table->foreign('id_module')
                  ->references('id_module')->on('module')
                  ->onDelete('cascade');
        });

        Schema::create('note', function (Blueprint $table) {
            $table->id('id_note');
            $table->decimal('note', 5, 2)->nullable();
            $table->decimal('rattrapage', 5, 2)->nullable();
            $table->decimal('note_finale', 5, 2)->nullable();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_evaluation');

            $table->unique(['id_user', 'id_evaluation']);

            $table->foreign('id_user')
                  ->references('id_user')->on('etudiant')
                  ->onDelete('cascade');

            $table->foreign('id_evaluation')
                  ->references('id_evaluation')->on('evaluation')
                  ->onDelete('cascade');
        });

        Schema::create('reclamation', function (Blueprint $table) {
            $table->id('id_reclamation');
            $table->text('message');
            $table->dateTime('date_reclamation')->useCurrent();
            $table->enum('statut', ['EN_ATTENTE', 'TRAITEE', 'REJETEE', 'EN_COURS'])->default('EN_ATTENTE');
            $table->unsignedBigInteger('id_note');
            $table->unsignedBigInteger('id_user');

            $table->foreign('id_note')
                  ->references('id_note')->on('note')
                  ->onDelete('cascade');

            $table->foreign('id_user')
                  ->references('id_user')->on('etudiant')
                  ->onDelete('cascade');
        });

        Schema::create('log_action', function (Blueprint $table) {
            $table->id('id_log');
            $table->string('action', 100);
            $table->string('table_concernee', 50);
            $table->integer('id_enregistrement')->nullable();
            $table->dateTime('date_action')->useCurrent();
            $table->unsignedBigInteger('id_user')->nullable();

            $table->foreign('id_user')
                  ->references('id_user')->on('utilisateur')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_action');
        Schema::dropIfExists('reclamation');
        Schema::dropIfExists('note');
        Schema::dropIfExists('evaluation');
        Schema::dropIfExists('inscription');
        Schema::dropIfExists('etudiant');
        Schema::dropIfExists('enseignement');
        Schema::dropIfExists('module');
        Schema::dropIfExists('semestre');
        Schema::dropIfExists('annee_academique');
        Schema::dropIfExists('filiere');
        Schema::dropIfExists('enseignant');
        Schema::dropIfExists('utilisateur');
    }
};