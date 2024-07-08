<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Level::create(['name' => 'Administrador', 'permissions' => json_encode(['create projects', 'edit projects', 'delete projects', 'view projects', 'manage users'])]);
        Level::create(['name' => 'Pesquisador', 'permissions' => json_encode(['create projects', 'edit projects', 'view projects'])]);
        Level::create(['name' => 'Revisor', 'permissions' => json_encode(['view projects'])]);
        Level::create(['name' => 'Visualizador', 'permissions' => json_encode(['view projects'])]);
    }
}
