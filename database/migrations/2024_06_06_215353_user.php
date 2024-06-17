<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['USER', 'SUPER_USER'])->default('USER');
        });

        User::updateOrCreate(
            ['email' => 'superuser@superuser.com'],
            [
                'username' => 'superuser',
                'role' => 'SUPER_USER',
                'terms' => 'required',
                'password' => bcrypt('superpassword'),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
