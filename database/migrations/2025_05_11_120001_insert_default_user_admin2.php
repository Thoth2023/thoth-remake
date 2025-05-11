<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert([
            'username' => 'admin2',
            'firstname' => 'Admin',
            'lastname' => 'User',
            'email' => 'admin2@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'institution' => 'Thoth',
            'lattes_link' => null,
            'address' => 'Rua Tiaraju',
            'city' => 'Alegrete',
            'country' => 'Brasil',
            'postal' => '97542',
            'about' => 'admin',
            'occupation' => 'admin',
            'remember_token' => \Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->where('email', 'admin2@admin.com')->delete();
    }
};
