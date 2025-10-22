<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('project', function (Blueprint $table) {
            // Flag: usuário reconheceu o aviso de protocolo antes de conduzir
            if (!Schema::hasColumn('project', 'protocol_warning_ack')) {
                $table->boolean('protocol_warning_ack')->default(false)->after('is_public');
            }
        });
    }

    public function down(): void
    {
        Schema::table('project', function (Blueprint $table) {
            if (Schema::hasColumn('project', 'protocol_warning_ack')) {
                $table->dropColumn('protocol_warning_ack');
            }
        });
    }
};
