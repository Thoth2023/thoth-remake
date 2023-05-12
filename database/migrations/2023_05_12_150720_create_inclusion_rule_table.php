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
        Schema::create('inclusion_rule', function (Blueprint $table) {
            $table->integer('id_inclusion_rule', true);
            $table->integer('id_rule')->index('id_rule');
            $table->integer('id_project')->index('id_project');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inclusion_rule');
    }
};
