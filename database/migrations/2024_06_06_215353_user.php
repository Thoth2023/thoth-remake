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

        // Só cria o super usuário se as variáveis de ambiente estiverem definidas
        $superUserEmail = env('SUPER_USER_EMAIL');
        $superUserUsername = env('SUPER_USER_USERNAME');
        $superUserPassword = env('SUPER_USER_PASSWORD');

        if ($superUserEmail && $superUserUsername && $superUserPassword) {
            User::updateOrCreate(
                ['email' => $superUserEmail],
                [
                    'username' => $superUserUsername,
                    'role' => 'SUPER_USER',
                    'terms' => 'required',
                    'password' => bcrypt($superUserPassword),
                ]
            );
        }
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
