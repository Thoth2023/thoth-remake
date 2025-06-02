<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Cria a tabela 'types_question' no banco de dados.
     *
     * Campos:
     * - id_type (integer, auto-incremento, chave primária): Identificador único do tipo de questão.
     * - type (string): Nome ou descrição do tipo de questão.
     */
    public function up()
    {
        Schema::create('types_question', function (Blueprint $table) {
            $table->integer('id_type', true);
            $table->string('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types_question');
    }
};
