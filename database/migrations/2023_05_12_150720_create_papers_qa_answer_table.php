<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers_qa_answer', function (Blueprint $table) {
            $table->integer('id_papers_qa_answer', true);
            $table->integer('id_paper')->index('id_paper');
            $table->integer('id_question')->index('id_question');
            $table->integer('id_answer')->index('id_answer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papers_qa_answer');
    }
};
