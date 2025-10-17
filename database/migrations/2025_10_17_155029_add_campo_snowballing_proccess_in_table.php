<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('papers_snowballing', function (Blueprint $table) {
            $table->string('snowballing_process')
                ->nullable()
                ->after('type_snowballing')
                ->comment('Define se o processo de snowballing foi manual ou automático');
        });
    }

    public function down(): void
    {
        Schema::table('papers_snowballing', function (Blueprint $table) {
            $table->dropColumn('snowballing_process');
        });
    }
};
