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
        Schema::create('min_to_app', function (Blueprint $table) {
            $table->integer('id_min_to_app', true);
            $table->integer('id_project')->index('id_project');
            $table->integer('id_general_score')->index('id_general_score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('min_to_app');
    }
};
