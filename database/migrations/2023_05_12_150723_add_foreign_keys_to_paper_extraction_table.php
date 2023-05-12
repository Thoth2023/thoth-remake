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
        Schema::table('paper_extraction', function (Blueprint $table) {
            $table->foreign(['id_resposta'], 'paper_extraction_ibfk_2')->references(['id_option'])->on('options_extraction')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_paper'], 'paper_extraction_ibfk_1')->references(['id_paper'])->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paper_extraction', function (Blueprint $table) {
            $table->dropForeign('paper_extraction_ibfk_2');
            $table->dropForeign('paper_extraction_ibfk_1');
        });
    }
};
