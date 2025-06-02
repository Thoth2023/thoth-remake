<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chave estrangeira à tabela 'synonym'.
     *
     * Esta migration adiciona uma restrição de chave estrangeira ao campo 'id_term' da tabela 'synonym',
     * referenciando o campo 'id_term' da tabela 'term'. A restrição é nomeada como 'synonym_ibfk_1'.
     * 
     * - Ao atualizar um registro em 'term', as alterações serão propagadas para 'synonym' (CASCADE).
     * - Ao deletar um registro em 'term', os registros relacionados em 'synonym' também serão deletados (CASCADE).
     *
     * Funções:
     * - up(): Aplica a adição da chave estrangeira à tabela 'synonym'.
     */
    public function up()
    {
        Schema::table('synonym', function (Blueprint $table) {
            $table->foreign(['id_term'], 'synonym_ibfk_1')->references(['id_term'])->on('term')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('synonym', function (Blueprint $table) {
            $table->dropForeign('synonym_ibfk_1');
        });
    }
};
