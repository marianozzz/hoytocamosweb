<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles (idempotente)
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Crear permisos (idempotente)
        $permissions = [
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'genres.manage',
            'countries.manage',
            'provinces.manage',
            'cities.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Asignar permisos a roles
        $admin->syncPermissions(Permission::all());
        $editor->syncPermissions(['users.view', 'genres.manage']);
    }
}