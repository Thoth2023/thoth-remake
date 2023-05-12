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
        Schema::create('project_study_types', function (Blueprint $table) {
            $table->integer('id_project_study_types', true);
            $table->integer('id_project')->index('id_project');
            $table->integer('id_study_type')->index('id_study_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_study_types');
    }
};
