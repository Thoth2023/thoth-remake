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
        Schema::table('question_quality', function (Blueprint $table) {
            $table->foreign(['id_project'], 'question_quality_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['min_to_app'], 'question_quality_ibfk_2')->references(['id_score'])->on('score_quality')->onUpdate('SET NULL')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_quality', function (Blueprint $table) {
            $table->dropForeign('question_quality_ibfk_1');
            $table->dropForeign('question_quality_ibfk_2');
        });
    }
};
