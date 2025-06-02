<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chave estrangeira à tabela 'search_strategy'.
     *
     * Esta migration adiciona uma restrição de chave estrangeira ao campo 'id_project' da tabela 'search_strategy',
     * referenciando o campo 'id_project' da tabela 'project'. A restrição é nomeada como 'search_strategy_ibfk_1'.
     * 
     * - onUpdate('CASCADE'): Atualizações no campo referenciado em 'project' serão refletidas em 'search_strategy'.
     * - onDelete('CASCADE'): Exclusões no campo referenciado em 'project' resultarão na exclusão dos registros relacionados em 'search_strategy'.
     *
     * Funções:
     * - up(): Aplica a adição da chave estrangeira à tabela 'search_strategy'.
     */
    public function up()
    {
        Schema::table('search_strategy', function (Blueprint $table) {
            $table->foreign(['id_project'], 'search_strategy_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('search_strategy', function (Blueprint $table) {
            $table->dropForeign('search_strategy_ibfk_1');
        });
    }
};
