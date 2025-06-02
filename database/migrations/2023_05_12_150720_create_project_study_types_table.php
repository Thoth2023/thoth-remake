<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Cria a tabela 'project_study_types' para associar projetos aos tipos de estudo.
     *
     * Campos:
     * - id_project_study_types: Chave primária incremental.
     * - id_project: Referência ao projeto (indexado).
     * - id_study_type: Referência ao tipo de estudo (indexado).
     *
     * Esta migration estabelece a relação entre projetos e tipos de estudo, permitindo
     * que cada projeto seja vinculado a um ou mais tipos de estudo.
     */
    public function up()
    {
        Schema::create('project_study_types', function (Blueprint $table) {
            $table->integer('id_project_study_types', true);
            $table->integer('id_project')->index('id_project');
            $table->integer('id_study_type')->index('id_study_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_study_types');
    }
};
