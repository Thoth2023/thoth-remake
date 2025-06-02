<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chave estrangeira à tabela 'options_extraction'.
     *
     * Campos afetados:
     * - id_de: Adiciona uma chave estrangeira referenciando o campo 'id_de' da tabela 'question_extraction'.
     *
     * Funções:
     * - up(): Adiciona a constraint de chave estrangeira 'options_extraction_ibfk_1' ao campo 'id_de', 
     *         referenciando 'id_de' em 'question_extraction', com atualização e deleção em cascata.
     */
    public function up()
    {
        Schema::table('options_extraction', function (Blueprint $table) {
            $table->foreign(['id_de'], 'options_extraction_ibfk_1')->references(['id_de'])->on('question_extraction')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('options_extraction', function (Blueprint $table) {
            $table->dropForeign('options_extraction_ibfk_1');
        });
    }
};
