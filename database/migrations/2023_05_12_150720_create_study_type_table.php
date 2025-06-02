<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Cria a tabela 'study_type' no banco de dados.
     *
     * Campos:
     * - id_study_type (integer, auto-incremento, chave primária): Identificador único do tipo de estudo.
     * - description (string): Descrição do tipo de estudo.
     */
    public function up()
    {
        Schema::create('study_type', function (Blueprint $table) {
            $table->integer('id_study_type', true);
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_type');
    }
};
