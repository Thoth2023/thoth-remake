<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('import_study', function (Blueprint $table) {
            $table->id();
            $table->string('id_project');
            $table->string('id_database');
            $table->string('file');
            $table->string('description');
            $table->string('imported_studies_count');
            $table->string('failed_imports_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_study');
    }
};
