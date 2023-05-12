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
        Schema::create('score_quality', function (Blueprint $table) {
            $table->integer('id_score', true);
            $table->string('score_rule');
            $table->string('description');
            $table->integer('score');
            $table->integer('id_qa')->index('id_qa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_quality');
    }
};
