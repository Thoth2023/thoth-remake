<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Run the migrations to create the 'project_languages' table.
     *
     * This table establishes a relationship between projects and languages,
     * allowing each project to be associated with multiple languages.
     * 
     * Columns:
     * - id_project_lang: Primary key, auto-increment integer.
     * - id_project: Foreign key referencing the project, indexed for performance.
     * - id_language: Foreign key referencing the language, indexed for performance.
     */
    public function up()
    {
        Schema::create('project_languages', function (Blueprint $table) {
            $table->integer('id_project_lang', true);
            $table->integer('id_project')->index('id_project');
            $table->integer('id_language')->index('id_language');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_languages');
    }
};
