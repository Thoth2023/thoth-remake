<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chaves estrangeiras à tabela 'members'.
     *
     * Esta migration define as seguintes relações:
     * - O campo 'level' da tabela 'members' referencia o campo 'id_level' da tabela 'levels'.
     *   - Restrições: Atualização e exclusão em cascata.
     * - O campo 'id_user' da tabela 'members' referencia o campo 'id' da tabela 'users'.
     *   - Restrições: Atualização e exclusão em cascata.
     * - O campo 'id_project' da tabela 'members' referencia o campo 'id_project' da tabela 'project'.
     *   - Restrições: Atualização e exclusão em cascata.
     *
     * Funções:
     * - up(): Adiciona as chaves estrangeiras à tabela 'members' conforme descrito acima.
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->foreign(['level'], 'members_ibfk_3')->references(['id_level'])->on('levels')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_user'], 'members_ibfk_2')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_project'], 'members_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign('members_ibfk_3');
            $table->dropForeign('members_ibfk_2');
            $table->dropForeign('members_ibfk_1');
        });
    }
};
