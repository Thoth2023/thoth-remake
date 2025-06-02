<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chave estrangeira à tabela 'general_score'.
     *
     * Esta migration adiciona uma restrição de chave estrangeira ao campo 'id_project' da tabela 'general_score',
     * referenciando o campo 'id_project' da tabela 'project'. A restrição é nomeada como 'general_score_ibfk_1'.
     * 
     * - onUpdate('CASCADE'): Atualizações no campo referenciado em 'project' serão refletidas em 'general_score'.
     * - onDelete('CASCADE'): Exclusões no campo referenciado em 'project' resultarão na exclusão dos registros relacionados em 'general_score'.
     *
     * Funções:
     * - up(): Aplica a adição da chave estrangeira à tabela 'general_score'.
     */
    public function up()
    {
        Schema::table('general_score', function (Blueprint $table) {
            $table->foreign(['id_project'], 'general_score_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_score', function (Blueprint $table) {
            $table->dropForeign('general_score_ibfk_1');
        });
    }
};
