<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

       Permission::create(['name' => 'do recommandation']);
        Permission::create(['name' => 'share food']);
        Permission::create(['name' => 'blocked user']);
        Permission::create(['name' => 'valide order']);
        Permission::create(['name' => 'give permission']);

        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        $adminRole->givePermissionTo('do recommandation', 'share food', 'blocked user', 'valide order', 'give permission');

    }
}
