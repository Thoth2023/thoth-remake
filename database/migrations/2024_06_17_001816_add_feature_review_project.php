<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    /**
     * Migration para adicionar a coluna 'feature_review' na tabela 'project'.
     *
     * Métodos:
     * - up(): Aplica a migration, adicionando uma nova coluna do tipo string chamada 'feature_review' na tabela 'project'.
     */
    public function up(): void
    {
        Schema::table('project', function (Blueprint $table) {
            $table->string('feature_review');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project', function (Blueprint $table) {
            $table->dropColumn('feature_review');
        });
    }
};
