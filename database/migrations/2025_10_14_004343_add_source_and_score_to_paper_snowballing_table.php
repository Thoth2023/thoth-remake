<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('papers_snowballing', function (Blueprint $table) {
            $table->string('source')->nullable()->after('type_snowballing');
            $table->float('relevance_score')->nullable()->after('source');
            $table->unsignedInteger('duplicate_count')->default(1)->after('relevance_score');
        });
    }

    public function down(): void
    {
        Schema::table('papers_snowballing', function (Blueprint $table) {
            $table->dropColumn(['source', 'relevance_score', 'duplicate_count']);
        });
    }
};
