<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('qa_cutoff', function (Blueprint $table) {
            $table->integer('id_general_score')->nullable()->after('id_project');
            $table->foreign(['id_general_score'], 'id_general_score')
                ->references('id_general_score')
                ->on('general_score')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->dropColumn('score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qa_cutoff', function (Blueprint $table) {
            $table->dropForeign('id_general_score');
            $table->double('score')->default(0);
        });
    }
};
