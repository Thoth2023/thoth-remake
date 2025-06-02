<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chaves estrangeiras à tabela 'project_languages'.
     *
     * Campos afetados:
     * - id_language: Referencia o campo 'id_language' da tabela 'language'.
     * - id_project: Referencia o campo 'id_project' da tabela 'project'.
     *
     * Funções:
     * - up(): Adiciona as restrições de chave estrangeira para os campos 'id_language' e 'id_project',
     *         garantindo integridade referencial. Ambas as chaves possuem as ações 'CASCADE' para
     *         atualização e exclusão, ou seja, alterações ou remoções nas tabelas referenciadas
     *         serão refletidas automaticamente na tabela 'project_languages'.
     */
    public function up()
    {
        Schema::table('project_languages', function (Blueprint $table) {
            $table->foreign(['id_language'], 'project_languages_ibfk_1')->references(['id_language'])->on('language')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_project'], 'project_languages_ibfk_2')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_languages', function (Blueprint $table) {
            $table->dropForeign('project_languages_ibfk_1');
            $table->dropForeign('project_languages_ibfk_2');
        });
    }
};
