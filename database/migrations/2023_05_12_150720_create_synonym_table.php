<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Cria a tabela 'synonym' no banco de dados.
     *
     * Campos:
     * - id_synonym (integer, auto-incremento): Identificador único do sinônimo.
     * - description (string): Descrição ou texto do sinônimo.
     * - id_term (integer, indexado): Referência ao termo principal ao qual o sinônimo está associado.
     */
    public function up()
    {
        Schema::create('synonym', function (Blueprint $table) {
            $table->integer('id_synonym', true);
            $table->string('description');
            $table->integer('id_term')->index('id_term');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('synonym');
    }
};
