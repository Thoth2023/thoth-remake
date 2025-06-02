<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Migration para criar a tabela 'activity_log'.
     *
     * Esta tabela armazena registros de atividades dos usuários no sistema,
     * incluindo o usuário responsável, o módulo relacionado, a descrição da atividade,
     * e, opcionalmente, o projeto associado. Também inclui timestamps de criação e atualização.
     *
     * Campos:
     * - id_log: Identificador único da atividade (chave primária).
     * - id_user: Referência ao usuário que realizou a atividade.
     * - id_module: Referência ao módulo relacionado à atividade.
     * - activity: Descrição da atividade realizada.
     * - id_project: (Opcional) Referência ao projeto relacionado à atividade.
     * - created_at / updated_at: Timestamps de criação e atualização do registro.
     */
    public function up()
    {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->integer('id_log', true);
            $table->unsignedBigInteger('id_user')->index('id_user');
            $table->integer('id_module')->index('id_module');
            $table->string('activity');
            $table->integer('id_project')->nullable()->index('id_project');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_log');
    }
};
