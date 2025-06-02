<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para criar a tabela 'status_snowballing'.
     *
     * Métodos utilizados:
     * - up(): Cria a tabela 'status_snowballing' com as seguintes colunas:
     *   - id(): Chave primária auto-incrementável.
     *   - string('description'): Campo para armazenar a descrição do status.
     *   - timestamps(): Cria os campos 'created_at' e 'updated_at' para controle de data/hora.
     */
    public function up(): void
    {
        Schema::create('status_snowballing', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_snowballing');
    }
};
