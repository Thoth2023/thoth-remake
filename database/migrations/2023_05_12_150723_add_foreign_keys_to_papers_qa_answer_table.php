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
        Schema::table('papers_qa_answer', function (Blueprint $table) {
            $table->foreign(['id_question'], 'papers_qa_answer_ibfk_3')->references(['id_qa'])->on('question_quality')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_answer'], 'papers_qa_answer_ibfk_2')->references(['id_score'])->on('score_quality');
            $table->foreign(['id_paper'], 'papers_qa_answer_ibfk_1')->references(['id_paper'])->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('papers_qa_answer', function (Blueprint $table) {
            $table->dropForeign('papers_qa_answer_ibfk_3');
            $table->dropForeign('papers_qa_answer_ibfk_2');
            $table->dropForeign('papers_qa_answer_ibfk_1');
        });
    }
};
