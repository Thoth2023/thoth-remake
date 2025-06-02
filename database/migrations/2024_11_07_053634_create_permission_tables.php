<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
   
   
    /**
     * Migration responsável por criar as tabelas de permissões, papéis (roles) e seus relacionamentos,
     * utilizando a configuração definida em config/permission.php. Esta migration suporta times (teams)
     * caso esteja habilitado na configuração.
     *
     * Métodos:
     * - up(): Executa a criação das tabelas necessárias para o controle de permissões e papéis, além de
     *   limpar o cache relacionado às permissões.
     *
     * Variáveis e Condições Iniciais:
     * - $teams: Indica se o suporte a times está habilitado (config('permission.teams')).
     * - $tableNames: Array com os nomes das tabelas a serem criadas (config('permission.table_names')).
     * - $columnNames: Array com os nomes das colunas utilizadas nas tabelas (config('permission.column_names')).
     * - $pivotRole: Nome da coluna de chave estrangeira para papéis nas tabelas pivot (padrão: 'role_id').
     * - $pivotPermission: Nome da coluna de chave estrangeira para permissões nas tabelas pivot (padrão: 'permission_id').
     * - Caso $tableNames esteja vazio, lança uma Exception orientando a limpar o cache de configuração.
     * - Caso $teams esteja habilitado e não exista a chave 'team_foreign_key', lança uma Exception orientando a limpar o cache de configuração.
     *
     * Criação das Tabelas:
     * - Schema::create($tableNames['permissions']):
     *   Cria a tabela de permissões com colunas: id, name, guard_name, timestamps e unique composta por name e guard_name.
     *
     * - Schema::create($tableNames['roles']):
     *   Cria a tabela de papéis (roles) com colunas: id, name, guard_name, timestamps.
     *   Se $teams estiver habilitado, adiciona a coluna de chave estrangeira para o time e índice correspondente.
     *   Define unique composta por (team_foreign_key, name, guard_name) se $teams estiver habilitado, senão apenas (name, guard_name).
     *
     * - Schema::create($tableNames['model_has_permissions']):
     *   Cria a tabela pivot entre modelos e permissões.
     *   Colunas: permission_id, model_type, model_morph_key.
     *   Índice para (model_morph_key, model_type).
     *   Foreign key para permission_id referenciando permissions(id).
     *   Se $teams estiver habilitado, adiciona coluna team_foreign_key, índice e primary key composta por (team_foreign_key, permission_id, model_morph_key, model_type).
     *   Caso contrário, primary key composta por (permission_id, model_morph_key, model_type).
     *
     * - Schema::create($tableNames['model_has_roles']):
     *   Cria a tabela pivot entre modelos e papéis.
     *   Colunas: role_id, model_type, model_morph_key.
     *   Índice para (model_morph_key, model_type).
     *   Foreign key para role_id referenciando roles(id).
     *   Se $teams estiver habilitado, adiciona coluna team_foreign_key, índice e primary key composta por (team_foreign_key, role_id, model_morph_key, model_type).
     *   Caso contrário, primary key composta por (role_id, model_morph_key, model_type).
     *
     * - Schema::create($tableNames['role_has_permissions']):
     *   Cria a tabela pivot entre papéis e permissões.
     *   Colunas: permission_id, role_id.
     *   Foreign keys para permission_id (permissions.id) e role_id (roles.id).
     *   Primary key composta por (permission_id, role_id).
     *
     * Função app('cache'):
     * - Após a criação das tabelas, limpa o cache de permissões utilizando a store e key definidas na configuração
     *   (config('permission.cache.store') e config('permission.cache.key')), garantindo que as alterações de permissões
     *   sejam refletidas imediatamente.
     */
    public function up(): void
    {
        $teams = config('permission.teams');
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $pivotRole = $columnNames['role_pivot_key'] ?? 'role_id';
        $pivotPermission = $columnNames['permission_pivot_key'] ?? 'permission_id';

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }
        if ($teams && empty($columnNames['team_foreign_key'] ?? null)) {
            throw new \Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            //$table->engine('InnoDB');
            $table->bigIncrements('id'); // permission id
            $table->string('name');       // For MyISAM use string('name', 225); // (or 166 for InnoDB with Redundant/Compact row format)
            $table->string('guard_name'); // For MyISAM use string('guard_name', 25);
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) use ($teams, $columnNames) {
            //$table->engine('InnoDB');
            $table->bigIncrements('id'); // role id
            if ($teams || config('permission.testing')) { // permission.testing is a fix for sqlite testing
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
            }
            $table->string('name');       // For MyISAM use string('name', 225); // (or 166 for InnoDB with Redundant/Compact row format)
            $table->string('guard_name'); // For MyISAM use string('guard_name', 25);
            $table->timestamps();
            if ($teams || config('permission.testing')) {
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames, $pivotPermission, $teams) {
            $table->unsignedBigInteger($pivotPermission);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign($pivotPermission)
                ->references('id') // permission id
                ->on($tableNames['permissions'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], $pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            } else {
                $table->primary([$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            }

        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames, $pivotRole, $teams) {
            $table->unsignedBigInteger($pivotRole);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign($pivotRole)
                ->references('id') // role id
                ->on($tableNames['roles'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], $pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            } else {
                $table->primary([$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            }
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames, $pivotRole, $pivotPermission) {
            $table->unsignedBigInteger($pivotPermission);
            $table->unsignedBigInteger($pivotRole);

            $table->foreign($pivotPermission)
                ->references('id') // permission id
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign($pivotRole)
                ->references('id') // role id
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary([$pivotPermission, $pivotRole], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
};
