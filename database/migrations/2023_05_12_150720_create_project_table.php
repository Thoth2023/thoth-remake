<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Migration para criar a tabela 'project'.
     *
     * Campos:
     * - id_project: inteiro, chave primária auto-incrementada. Identificador único do projeto.
     * - id_user: unsignedBigInteger, indexado. Referência ao usuário responsável pelo projeto.
     * - title: string. Título do projeto.
     * - description: string. Descrição do projeto.
     * - objectives: string. Objetivos do projeto.
     * - created_by: string. Nome do criador do projeto.
     * - start_date: date. Data de início do projeto.
     * - end_date: date. Data de término do projeto.
     * - c_papers: inteiro, padrão 0. Quantidade de artigos/papers associados ao projeto.
     * - planning: float(10,0), padrão 0. Progresso da etapa de planejamento.
     * - import: float(10,0), padrão 0. Progresso da etapa de importação.
     * - selection: float(10,0), padrão 0. Progresso da etapa de seleção.
     * - quality: float(10,0), padrão 0. Progresso da etapa de avaliação de qualidade.
     * - extraction: float(10,0), padrão 0. Progresso da etapa de extração de dados.
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->integer('id_project', true);
            $table->unsignedBigInteger('id_user')->index('id_user');
            $table->string('title');
            $table->string('description');
            $table->string('objectives');
            $table->string('created_by');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('c_papers')->default(0);
            $table->float('planning', 10, 0)->default(0);
            $table->float('import', 10, 0)->default(0);
            $table->float('selection', 10, 0)->default(0);
            $table->float('quality', 10, 0)->default(0);
            $table->float('extraction', 10, 0)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project');
    }
};
