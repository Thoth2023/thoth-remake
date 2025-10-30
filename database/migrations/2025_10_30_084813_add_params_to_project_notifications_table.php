<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('project_notifications', function (Blueprint $table) {
            // Apenas cria se não existir (defensivo)
            if (!Schema::hasColumn('project_notifications', 'params')) {
                $table->json('params')->nullable()->after('message');
            }
        });
    }

    public function down()
    {
        Schema::table('project_notifications', function (Blueprint $table) {
            if (Schema::hasColumn('project_notifications', 'params')) {
                $table->dropColumn('params');
            }
        });
    }
};
