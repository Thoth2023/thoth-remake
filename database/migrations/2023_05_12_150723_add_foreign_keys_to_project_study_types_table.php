<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chaves estrangeiras à tabela 'project_study_types'.
     *
     * Campos afetados:
     * - id_project: Referência à tabela 'project', com atualização e remoção em cascata.
     * - id_study_type: Referência à tabela 'study_type', com atualização e remoção em cascata.
     *
     * Funções:
     * - up(): Adiciona as restrições de chave estrangeira para garantir integridade referencial entre
     *   'project_study_types', 'project' e 'study_type'. As ações 'CASCADE' garantem que alterações ou remoções
     *   nas tabelas referenciadas sejam refletidas automaticamente nesta tabela.
     */
    public function up()
    {
        Schema::table('project_study_types', function (Blueprint $table) {
            $table->foreign(['id_project'], 'project_study_types_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_study_type'], 'project_study_types_ibfk_2')->references(['id_study_type'])->on('study_type')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_study_types', function (Blueprint $table) {
            $table->dropForeign('project_study_types_ibfk_1');
            $table->dropForeign('project_study_types_ibfk_2');
        });
    }
};
