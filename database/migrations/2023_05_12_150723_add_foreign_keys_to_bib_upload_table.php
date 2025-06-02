<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Adiciona uma chave estrangeira à tabela 'bib_upload'.
     *
     * Esta migration cria uma relação entre o campo 'id_project_database' da tabela 'bib_upload'
     * e o campo 'id_project_database' da tabela 'project_databases'. A relação é configurada para
     * atualizar e deletar em cascata, garantindo integridade referencial entre as tabelas.
     *
     * Campos envolvidos:
     * - bib_upload.id_project_database: Referência ao banco de dados do projeto associado ao upload.
     * - project_databases.id_project_database: Identificador único do banco de dados do projeto.
     *
     * Restrições:
     * - Ao atualizar ou deletar um registro em 'project_databases', as alterações são propagadas para 'bib_upload'.
     */
    public function up()
    {
        Schema::table('bib_upload', function (Blueprint $table) {
            $table->foreign(['id_project_database'], 'bib_upload_ibfk_1')->references(['id_project_database'])->on('project_databases')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bib_upload', function (Blueprint $table) {
            $table->dropForeign('bib_upload_ibfk_1');
        });
    }
};
