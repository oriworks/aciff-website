<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $superAdmin = \App\Models\Role::create(['name' => 'super-admin']);
        $aciff = \App\Models\Role::create(['name' => 'aciff']);
        $adminAciff = \App\Models\Role::create(['name' => 'admin-aciff']);
        $history = \App\Models\Role::create(['name' => 'history']);
        $adminHistory = \App\Models\Role::create(['name' => 'admin-history']);

        $categories = \App\Models\Permission::create(['name' => 'categories']);
        $adminHistory->givePermissionTo($categories);
        $categoriesViewAny = \App\Models\Permission::create(['name' => 'categories.viewAny']);
        $history->givePermissionTo($categoriesViewAny);
        $categoriesView = \App\Models\Permission::create(['name' => 'categories.view']);
        $history->givePermissionTo($categoriesView);
        $categoriesCreate = \App\Models\Permission::create(['name' => 'categories.create']);
        $history->givePermissionTo($categoriesCreate);
        $categoriesUpdate = \App\Models\Permission::create(['name' => 'categories.update']);
        $history->givePermissionTo($categoriesUpdate);
        $categoriesDelete = \App\Models\Permission::create(['name' => 'categories.delete']);
        $history->givePermissionTo($categoriesDelete);
        $categoriesRestore = \App\Models\Permission::create(['name' => 'categories.restore']);
        $history->givePermissionTo($categoriesRestore);
        $categoriesForceDelete = \App\Models\Permission::create(['name' => 'categories.forceDelete']);
        $history->givePermissionTo($categoriesForceDelete);

        \App\Models\Permission::create(['name' => 'users']);
        \App\Models\Permission::create(['name' => 'roles']);
        \App\Models\Permission::create(['name' => 'permissions']);

        $documents = \App\Models\Permission::create(['name' => 'documents']);
        $adminHistory->givePermissionTo($documents);

        $documentsViewAny = \App\Models\Permission::create(['name' => 'documents.viewAny']);
        $history->givePermissionTo($documentsViewAny);

        $documentsViewAny = \App\Models\Permission::create(['name' => 'documents.view']);
        $history->givePermissionTo($documentsViewAny);

        $documentsCreate = \App\Models\Permission::create(['name' => 'documents.create']);
        $history->givePermissionTo($documentsCreate);

        \App\Models\Permission::create(['name' => 'documents.update']);
        \App\Models\Permission::create(['name' => 'documents.attachAnyTag']);
        \App\Models\Permission::create(['name' => 'documents.detachTag']);

        $tags = \App\Models\Permission::create(['name' => 'tags']);
        $adminHistory->givePermissionTo($tags);
        $tagsViewAny = \App\Models\Permission::create(['name' => 'tags.viewAny']);
        $history->givePermissionTo($tagsViewAny);
        $tagsView = \App\Models\Permission::create(['name' => 'tags.view']);
        $history->givePermissionTo($tagsView);
        $tagsCreate = \App\Models\Permission::create(['name' => 'tags.create']);
        $history->givePermissionTo($tagsCreate);
        $tagsUpdate = \App\Models\Permission::create(['name' => 'tags.update']);
        $history->givePermissionTo($tagsUpdate);
        $tagsDelete = \App\Models\Permission::create(['name' => 'tags.delete']);
        $history->givePermissionTo($tagsDelete);
        $tagsRestore = \App\Models\Permission::create(['name' => 'tags.restore']);
        $history->givePermissionTo($tagsRestore);
        $tagsForceDelete = \App\Models\Permission::create(['name' => 'tags.forceDelete']);
        $history->givePermissionTo($tagsForceDelete);
        \App\Models\Permission::create(['name' => 'tags.attachDocument']);
        \App\Models\Permission::create(['name' => 'tags.detachDocument']);

        $superAdmin->givePermissionTo(\App\Models\Permission::all());



        \App\Models\User::factory()->create([
            'id' => '9a82111c-b8e3-4794-9b06-5c6cd5a91a79',
            'name' => 'Joel Oliveira',
            'email' => 'joeloliveira@oriworks.com',
            'password' => bcrypt('qwerty123')
        ])->assignRole($superAdmin);

        \App\Models\User::factory()->create([
            'name' => 'Sandra Rodrigues',
            'email' => 'aciff@aciff.pt',
            'password' => bcrypt('qwerty123')
        ])->assignRole($adminAciff);

        \App\Models\User::factory()->create([
            'id' => '9a894154-2251-45ac-9268-3270e3b269ab',
            'name' => 'Francisca',
            'email' => 'francisca@gmail.com',
            'password' => bcrypt('qwerty123')
        ])->assignRole($history);

        \App\Models\User::factory()->create([
            'id' => '9a829953-bd3f-4314-aee3-c5cfd92d419c',
            'name' => 'Fernando Cardoso',
            'email' => 'fernando.cardoso@gmail.com',
            'password' => bcrypt('qwerty123')
        ])->assignRole($adminHistory);


        $this->call([
            \Database\Seeders\CategorySeeder::class,
            \Database\Seeders\DocumentSeeder::class,
        ]);
    }
}
