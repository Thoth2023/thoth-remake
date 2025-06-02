<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para criar a tabela 'status_extraction'.
     *
     * Métodos utilizados:
     * - Schema::create: Cria uma nova tabela no banco de dados.
     * - $table->integer('id_status', true): Cria uma coluna do tipo inteiro chamada 'id_status' e define como auto-incremento (chave primária).
     * - $table->string('description'): Cria uma coluna do tipo string chamada 'description' para armazenar a descrição do status.
     *
     * Esta migration é responsável por estruturar a tabela que armazena os diferentes status de extração, permitindo o controle e identificação dos mesmos.
     */
    public function up()
    {
        Schema::create('status_extraction', function (Blueprint $table) {
            $table->integer('id_status', true);
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
        Schema::dropIfExists('status_extraction');
    }
};
