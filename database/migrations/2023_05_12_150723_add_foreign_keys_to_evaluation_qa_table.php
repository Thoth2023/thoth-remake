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
        Schema::table('evaluation_qa', function (Blueprint $table) {
            $table->foreign(['id_score_qa'], 'evaluation_qa_ibfk_3')->references(['id_score'])->on('score_quality')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_qa'], 'evaluation_qa_ibfk_2')->references(['id_qa'])->on('question_quality')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_paper'], 'evaluation_qa_ibfk_4')->references(['id_paper'])->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_member'], 'evaluation_qa_ibfk_1')->references(['id_members'])->on('members')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluation_qa', function (Blueprint $table) {
            $table->dropForeign('evaluation_qa_ibfk_3');
            $table->dropForeign('evaluation_qa_ibfk_2');
            $table->dropForeign('evaluation_qa_ibfk_4');
            $table->dropForeign('evaluation_qa_ibfk_1');
        });
    }
};
