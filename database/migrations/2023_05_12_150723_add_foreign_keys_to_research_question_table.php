<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chave estrangeira à tabela 'research_question'.
     *
     * Esta migration adiciona uma restrição de chave estrangeira ao campo 'id_project' da tabela 'research_question',
     * referenciando o campo 'id_project' da tabela 'project'. A restrição é nomeada como 'research_question_ibfk_1'.
     * 
     * - onUpdate('CASCADE'): Atualizações no campo referenciado em 'project' serão propagadas para 'research_question'.
     * - onDelete('CASCADE'): Exclusões no campo referenciado em 'project' resultarão na exclusão em cascata dos registros relacionados em 'research_question'.
     *
     * Funções:
     * - up(): Aplica a adição da chave estrangeira à tabela 'research_question'.
     */
    public function up()
    {
        Schema::table('research_question', function (Blueprint $table) {
            $table->foreign(['id_project'], 'research_question_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('research_question', function (Blueprint $table) {
            $table->dropForeign('research_question_ibfk_1');
        });
    }
};
