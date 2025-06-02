<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chave estrangeira à tabela 'criteria'.
     *
     * Esta migration adiciona uma restrição de chave estrangeira ao campo 'id_project' da tabela 'criteria',
     * referenciando o campo 'id_project' da tabela 'project'. A restrição é nomeada como 'criteria_ibfk_1'
     * e está configurada para atualizar e deletar em cascata.
     *
     * Campos afetados:
     * - id_project: Chave estrangeira que referencia o campo 'id_project' da tabela 'project'.
     *
     * Métodos:
     * - up(): Aplica a restrição de chave estrangeira à tabela 'criteria'.
     */
    public function up()
    {
        Schema::table('criteria', function (Blueprint $table) {
            $table->foreign(['id_project'], 'criteria_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('criteria', function (Blueprint $table) {
            $table->dropForeign('criteria_ibfk_1');
        });
    }
};
