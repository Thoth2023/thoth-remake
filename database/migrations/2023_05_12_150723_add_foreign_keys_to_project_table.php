<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chave estrangeira à tabela 'project'.
     *
     * Esta migration adiciona uma restrição de chave estrangeira ao campo 'id_user' da tabela 'project',
     * referenciando o campo 'id' da tabela 'users'. A restrição é nomeada como 'project_ibfk_1' e está
     * configurada para atualizar e deletar em cascata.
     *
     * Campos afetados:
     * - id_user: campo da tabela 'project' que receberá a restrição de chave estrangeira.
     *
     * Funções:
     * - up(): Aplica a restrição de chave estrangeira à tabela 'project'.
     */
    public function up()
    {
        Schema::table('project', function (Blueprint $table) {
            $table->foreign(['id_user'], 'project_ibfk_1')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project', function (Blueprint $table) {
            $table->dropForeign('project_ibfk_1');
        });
    }
};
