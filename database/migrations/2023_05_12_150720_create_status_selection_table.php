<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para criar a tabela 'status_selection'.
     *
     * Esta tabela armazena os diferentes status disponíveis para seleção no sistema.
     *
     * Campos:
     * - id_status (integer, auto-increment, chave primária): Identificador único do status.
     * - description (string): Descrição textual do status.
     */
    public function up()
    {
        Schema::create('status_selection', function (Blueprint $table) {
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
        Schema::dropIfExists('status_selection');
    }
};
