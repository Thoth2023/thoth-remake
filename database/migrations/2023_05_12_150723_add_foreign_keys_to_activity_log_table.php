<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Adiciona chaves estrangeiras à tabela 'activity_log'.
     *
     * Esta migration define as seguintes relações:
     * - 'id_project': Referencia o campo 'id_project' da tabela 'project'.
     *   - Atualizações e deleções em 'project' são propagadas em cascata.
     * - 'id_module': Referencia o campo 'id_module' da tabela 'module'.
     *   - Atualizações e deleções em 'module' são propagadas em cascata.
     * - 'id_user': Referencia o campo 'id' da tabela 'users'.
     *   - Atualizações e deleções em 'users' são propagadas em cascata.
     *
     * As restrições garantem integridade referencial entre 'activity_log' e as tabelas relacionadas,
     * removendo ou atualizando registros automaticamente conforme necessário.
     */
    public function up()
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->foreign(['id_project'], 'activity_log_ibfk_3')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_module'], 'activity_log_ibfk_2')->references(['id_module'])->on('module')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_user', 'activity_log_ibfk_1')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse  the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropForeign('activity_log_ibfk_3');
            $table->dropForeign('activity_log_ibfk_2');
            $table->dropForeign('activity_log_ibfk_1');
        });
    }
};
