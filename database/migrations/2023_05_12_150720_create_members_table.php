<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration para criar a tabela 'members'.
     *
     * Esta migration define a estrutura da tabela 'members', que armazena informações sobre os membros de um projeto.
     * Campos:
     * - id_members: Chave primária, auto-incremento.
     * - id_user: Referência ao usuário associado (com índice).
     * - id_project: Referência ao projeto associado (com índice).
     * - level: Nível do membro no projeto (com índice).
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->integer('id_members', true);
            $table->unsignedBigInteger('id_user')->index('members_ibfk_2');
            $table->integer('id_project')->index('members_ibfk_1');
            $table->integer('level')->index('members_ibfk_3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
};
