<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Migration para criar a tabela 'criteria'.
     *
     * Esta migration define a estrutura da tabela 'criteria', que armazena critérios relacionados a projetos.
     * Campos:
     * - id_criteria: Chave primária incremental.
     * - id: Identificador do critério.
     * - description: Descrição do critério.
     * - pre_selected: Indica se o critério está pré-selecionado.
     * - id_project: Referência ao projeto associado (indexado).
     * - type: Tipo do critério.
     */
    public function up()
    {
        Schema::create('criteria', function (Blueprint $table) {
            $table->integer('id_criteria', true);
            $table->string('id');
            $table->string('description');
            $table->boolean('pre_selected');
            $table->integer('id_project')->index('id_project');
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
        Schema::dropIfExists('criteria');
    }
};
