<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    /**
     * Migration para criar a tabela 'project_databases'.
     *
     * Esta migration define a estrutura da tabela responsável por armazenar a relação
     * entre projetos e bancos de dados. A tabela possui os seguintes campos:
     * - id_project_database: identificador único da relação (chave primária).
     * - id_project: referência ao projeto (indexado).
     * - id_database: referência ao banco de dados (indexado).
     *
     * Utilizada para mapear quais bancos de dados estão associados a cada projeto.
     */
    public function up()
    {
        Schema::create('project_databases', function (Blueprint $table) {
            $table->integer('id_project_database', true);
            $table->integer('id_project')->index('id_project');
            $table->integer('id_database')->index('id_database');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_databases');
    }
};
