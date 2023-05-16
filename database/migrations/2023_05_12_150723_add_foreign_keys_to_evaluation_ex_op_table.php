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
        Schema::table('evaluation_ex_op', function (Blueprint $table) {
            $table->foreign(['id_qe'], 'evaluation_ex_op_ibfk_3')->references(['id_de'])->on('question_extraction')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_paper'], 'evaluation_ex_op_ibfk_2')->references(['id_paper'])->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_option'], 'evaluation_ex_op_ibfk_1')->references(['id_option'])->on('options_extraction')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluation_ex_op', function (Blueprint $table) {
            $table->dropForeign('evaluation_ex_op_ibfk_3');
            $table->dropForeign('evaluation_ex_op_ibfk_2');
            $table->dropForeign('evaluation_ex_op_ibfk_1');
        });
    }
};
