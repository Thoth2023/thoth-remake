<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chave estrangeira à tabela 'keyword'.
     *
     * Esta migration adiciona uma restrição de chave estrangeira ao campo 'id_project' da tabela 'keyword',
     * referenciando o campo 'id_project' da tabela 'project'. A restrição é nomeada como 'keyword_ibfk_1'
     * e está configurada para atualizar e deletar em cascata.
     *
     * Campos afetados:
     * - id_project: Chave estrangeira que referencia 'id_project' na tabela 'project'.
     *
     * Métodos:
     * - up(): Adiciona a chave estrangeira à tabela 'keyword'.
     */
    public function up()
    {
        Schema::table('keyword', function (Blueprint $table) {
            $table->foreign(['id_project'], 'keyword_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('keyword', function (Blueprint $table) {
            $table->dropForeign('keyword_ibfk_1');
        });
    }
};
