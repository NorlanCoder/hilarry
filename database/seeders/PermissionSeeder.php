<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'do recommandation']);
        Permission::create(['name' => 'share food']);
        Permission::create(['name' => 'blocked user']);
        Permission::create(['name' => 'valide order']);
    }
}
