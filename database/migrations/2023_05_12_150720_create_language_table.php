<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration para criar a tabela 'language'.
     *
     * Esta migration define a estrutura da tabela 'language', que armazena informações sobre idiomas.
     * Campos:
     * - id_language: Chave primária incremental.
     * - description: Descrição do idioma.
     */
    public function up()
    {
        Schema::create('language', function (Blueprint $table) {
            $table->integer('id_language', true);
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language');
    }
};
