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
        Schema::table('options_extraction', function (Blueprint $table) {
            $table->foreign(['id_de'], 'options_extraction_ibfk_1')->references(['id_de'])->on('question_extraction')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('options_extraction', function (Blueprint $table) {
            $table->dropForeign('options_extraction_ibfk_1');
        });
    }
};
