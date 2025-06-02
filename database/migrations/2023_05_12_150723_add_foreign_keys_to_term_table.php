<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chave estrangeira à tabela 'term'.
     *
     * Esta migration adiciona uma restrição de chave estrangeira ao campo 'id_project' da tabela 'term',
     * referenciando o campo 'id_project' da tabela 'project'. A restrição é nomeada como 'term_ibfk_1'.
     * 
     * - Ao atualizar ou deletar um registro em 'project', as alterações são propagadas para 'term' devido ao uso de 'CASCADE'.
     *
     * Métodos:
     * - up(): Aplica a restrição de chave estrangeira à tabela 'term'.
     */
    public function up()
    {
        Schema::table('term', function (Blueprint $table) {
            $table->foreign(['id_project'], 'term_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('term', function (Blueprint $table) {
            $table->dropForeign('term_ibfk_1');
        });
    }
};
