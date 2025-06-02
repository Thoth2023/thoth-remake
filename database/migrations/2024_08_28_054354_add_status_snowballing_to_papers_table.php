<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar a coluna 'status_snowballing' à tabela 'papers'.
     *
     * Esta migration realiza as seguintes operações:
     * - Adiciona a coluna 'status_snowballing' do tipo unsignedBigInteger à tabela 'papers',
     *   posicionando-a após a coluna 'status_extraction' e definindo o valor padrão como 4.
     * - Cria uma chave estrangeira para 'status_snowballing', referenciando a coluna 'id'
     *   da tabela 'status_snowballing', com deleção em cascata.
     *
     * Métodos utilizados:
     * - Schema::table(): Modifica a estrutura de uma tabela existente.
     * - $table->unsignedBigInteger(): Cria uma nova coluna do tipo unsigned big integer.
     * - $table->default(): Define um valor padrão para a coluna.
     * - $table->after(): Especifica a posição da nova coluna em relação às existentes.
     * - $table->foreign(): Cria uma chave estrangeira para a coluna especificada.
     * - references(): Define a coluna referenciada na tabela estrangeira.
     * - on(): Especifica a tabela estrangeira.
     * - onDelete('cascade'): Define que, ao deletar o registro referenciado, os registros relacionados também serão deletados.
     */
    public function up()
    {
        Schema::table('papers', function (Blueprint $table) {
            // Adiciona a coluna status_snowballing após status_extraction
            $table->unsignedBigInteger('status_snowballing')
                ->default(4)
                ->after('status_extraction');

            // Define a chave estrangeira para a tabela status_snowballing
            $table->foreign('status_snowballing')
                ->references('id')
                ->on('status_snowballing')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('papers', function (Blueprint $table) {
            // Remove a chave estrangeira
            $table->dropForeign(['status_snowballing']);

            // Remove a coluna status_snowballing
            $table->dropColumn('status_snowballing');
        });
    }
};
