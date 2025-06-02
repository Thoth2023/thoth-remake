<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    
    /**
     * Cria a tabela 'bib_upload' no banco de dados.
     *
     * Esta migration define a estrutura da tabela 'bib_upload', que armazena informações
     * sobre uploads de arquivos bibliográficos associados a projetos.
     *
     * Campos:
     * - id_bib: Identificador único do upload (chave primária, auto-incremento).
     * - name: Nome do arquivo ou upload.
     * - id_project_database: Referência ao projeto relacionado (indexado).
     */
    public function up()
    {
        Schema::create('bib_upload', function (Blueprint $table) {
            $table->integer('id_bib', true);
            $table->string('name');
            $table->integer('id_project_database')->index('id_project_database');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bib_upload');
    }
};
