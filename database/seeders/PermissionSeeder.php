<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'Create User', 'slug' => 'create_user'],
            ['name' => 'Edit User', 'slug' => 'edit_user'],
            ['name' => 'Delete User', 'slug' => 'delete_user'],
            ['name' => 'View User', 'slug' => 'view_user'],

            ['name' => 'Create Organization', 'slug' => 'create_organization'],
            ['name' => 'Edit Organization', 'slug' => 'edit_organization'],
            ['name' => 'Delete Organization', 'slug' => 'delete_organization'],

        ];
    }
}
