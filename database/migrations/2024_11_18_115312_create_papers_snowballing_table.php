<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Criar a tabela sem a chave estrangeira
        Schema::create('papers_snowballing', function (Blueprint $table) {
            $table->id();
            $table->integer('paper_reference_id')->nullable();
            $table->foreign('paper_reference_id')->references('id_paper')->on('papers')->onDelete('set null');
            $table->unsignedBigInteger('parent_snowballing_id')->nullable(); // Apenas definir a coluna

            $table->string('doi')->nullable();
            $table->string('title');
            $table->string('authors')->nullable();
            $table->year('year')->nullable();
            $table->text('abstract')->nullable();
            $table->text('keywords')->nullable();
            $table->string('type')->nullable();
            $table->string('bib_key')->nullable();
            $table->string('url')->nullable();
            $table->string('type_snowballing')->nullable();
            $table->boolean('is_duplicate')->default(false);
            $table->boolean('is_relevant')->nullable();
            $table->timestamps();
        });

        // Adicionar a chave estrangeira separadamente
        Schema::table('papers_snowballing', function (Blueprint $table) {
            $table->foreign('parent_snowballing_id')->references('id')->on('papers_snowballing')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('papers_snowballing', function (Blueprint $table) {
            $table->dropForeign(['parent_snowballing_id']);
        });

        Schema::dropIfExists('papers_snowballing');
    }
};
