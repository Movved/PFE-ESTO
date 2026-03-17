<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reclamation', function (Blueprint $table) {
            $table->boolean('traite')->default(false)->after('date_reclamation');
            $table->text('reponse')->nullable()->after('traite');
        });
    }

    public function down(): void
    {
        Schema::table('reclamation', function (Blueprint $table) {
            $table->dropColumn(['traite', 'reponse']);
        });
    }
};
