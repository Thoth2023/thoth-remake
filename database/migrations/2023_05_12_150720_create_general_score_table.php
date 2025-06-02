<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration para criar a tabela 'general_score'.
     *
     * Esta migration define a estrutura da tabela 'general_score', que armazena pontuações gerais
     * associadas a projetos, incluindo um intervalo de pontuação e uma descrição.
     *
     * Campos:
     * - id_general_score: Identificador único da pontuação geral (chave primária, auto-incremento).
     * - start: Valor inicial do intervalo de pontuação.
     * - end: Valor final do intervalo de pontuação.
     * - description: Descrição da pontuação geral.
     * - id_project: Referência ao projeto relacionado (indexado).
     */
    public function up()
    {
        Schema::create('general_score', function (Blueprint $table) {
            $table->integer('id_general_score', true);
            $table->float('start', 10, 0);
            $table->float('end', 10, 0);
            $table->string('description');
            $table->integer('id_project')->index('id_project');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_score');
    }
};
