<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration para criar a tabela 'levels'.
     *
     * Esta migration define a estrutura da tabela 'levels', que armazena os níveis de acesso ou categorias.
     * Campos:
     * - id_level: Chave primária, auto-incremento.
     * - level: Descrição do nível.
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->integer('id_level', true);
            $table->string('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('levels');
    }
};
