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
        Schema::table('min_to_app', function (Blueprint $table) {
            $table->foreign(['id_general_score'], 'min_to_app_ibfk_2')->references(['id_general_score'])->on('general_score')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_project'], 'min_to_app_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('min_to_app', function (Blueprint $table) {
            $table->dropForeign('min_to_app_ibfk_2');
            $table->dropForeign('min_to_app_ibfk_1');
        });
    }
};
