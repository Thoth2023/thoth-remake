<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration para criar a tabela 'options_extraction'.
     *
     * Esta migration define a estrutura da tabela 'options_extraction', que armazena opções de extração
     * associadas a um determinado 'id_de'.
     * Campos:
     * - id_option: Chave primária, auto-incremento.
     * - description: Descrição da opção de extração.
     * - id_de: Referência ao 'id_de' associado (com índice).
     */
    public function up()
    {
        Schema::create('options_extraction', function (Blueprint $table) {
            $table->integer('id_option', true);
            $table->string('description');
            $table->integer('id_de')->index('id_de');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options_extraction');
    }
};
