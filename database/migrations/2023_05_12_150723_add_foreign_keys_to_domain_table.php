<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chave estrangeira à tabela 'domain'.
     *
     * Esta migration adiciona uma restrição de chave estrangeira ao campo 'id_project' da tabela 'domain',
     * referenciando o campo 'id_project' da tabela 'project'. A restrição é nomeada como 'domain_ibfk_1'
     * e está configurada para atualizar e deletar em cascata.
     *
     * Campos afetados:
     * - id_project: Chave estrangeira que referencia 'id_project' na tabela 'project'.
     *
     * Métodos:
     * - up(): Aplica a adição da chave estrangeira à tabela 'domain'.
     */
    public function up()
    {
        Schema::table('domain', function (Blueprint $table) {
            $table->foreign(['id_project'], 'domain_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domain', function (Blueprint $table) {
            $table->dropForeign('domain_ibfk_1');
        });
    }
};
