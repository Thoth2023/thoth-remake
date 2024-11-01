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
        Schema::table('project_databases', function (Blueprint $table) {
            $table->string('search_string', 750)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('project_databases', function (Blueprint $table) {
            $table->string('search_string', 500)->nullable()->change();
        });
    }
};
