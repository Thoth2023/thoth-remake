<?php
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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
        User::where('email', 'superuser@superuser.com')->delete();
    }
};