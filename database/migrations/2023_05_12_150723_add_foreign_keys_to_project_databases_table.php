<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    /**
     * Migration para adicionar chaves estrangeiras à tabela 'project_databases'.
     *
     * Campos afetados:
     * - id_database: Referência à coluna 'id_database' da tabela 'data_base'.
     * - id_project: Referência à coluna 'id_project' da tabela 'project'.
     *
     * Funções:
     * - up(): Adiciona as restrições de chave estrangeira para garantir integridade referencial.
     *   - A chave estrangeira 'project_databases_ibfk_2' conecta 'id_database' à tabela 'data_base', 
     *     com atualização e exclusão em cascata.
     *   - A chave estrangeira 'project_databases_ibfk_1' conecta 'id_project' à tabela 'project', 
     *     também com atualização e exclusão em cascata.
     */
    public function up()
    {
        Schema::table('project_databases', function (Blueprint $table) {
            $table->foreign(['id_database'], 'project_databases_ibfk_2')->references(['id_database'])->on('data_base')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_project'], 'project_databases_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_databases', function (Blueprint $table) {
            $table->dropForeign('project_databases_ibfk_2');
            $table->dropForeign('project_databases_ibfk_1');
        });
    }
};
