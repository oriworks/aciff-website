<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function createResource($resourceName, $addictionalActions = [], $roles = [], $admins = [])
    {
        $actions = [
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
            'restore',
            'forceDelete',
        ];

        $permission = \App\Models\Permission::create(['name' => $resourceName]);
        foreach ($admins as $role) {
            $role->givePermissionTo($permission);
        }
        foreach ($actions as $action) {
            $permission = \App\Models\Permission::create(['name' => $resourceName . '.' . $action]);
            foreach ($roles as $role) {
                $role->givePermissionTo($permission);
            }
        }
        foreach ($addictionalActions as $action) {
            $permission = \App\Models\Permission::create(['name' => $resourceName . '.' . $action]);
        }

    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = \App\Models\Role::where('name', 'super-admin')->first();
        $aciff = \App\Models\Role::where('name', 'aciff')->first();
        $adminAciff = \App\Models\Role::where('name', 'admin-aciff')->first();
        $history = \App\Models\Role::where('name', 'history')->first();
        $adminHistory = \App\Models\Role::where('name', 'admin-history')->first();

        $this->createResource('users', [], []);
        $this->createResource('roles', [], []);
        $this->createResource('permissions', [], []);
        $this->createResource('entities', [], [], [$adminAciff]);

        $this->createResource('categories', [], [$history], [$adminHistory]);
        $this->createResource('documents', ['attachAnyTag', 'detachTag'], [$history], [$adminHistory]);
        $this->createResource('tags', ['attachDocument', 'detachDocument'], [$history], [$adminHistory]);

        $superAdmin->givePermissionTo(\App\Models\Permission::all());
    }
}
