<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Cria a tabela 'status_qa' para armazenar os diferentes status de QA (Quality Assurance).
     *
     * Campos:
     * - id_status (integer, auto-incremento): Identificador único do status.
     * - status (string): Nome ou descrição do status de QA.
     */
    public function up()
    {
        Schema::create('status_qa', function (Blueprint $table) {
            $table->integer('id_status', true);
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_qa');
    }
};
