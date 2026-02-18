<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'name' => 'Admin',
            'description' => 'System Administrator with full access'
        ]);

        Role::create([
            'name' => 'Faculty',
            'description' => 'Faculty member who teaches courses'
        ]);

        Role::create([
            'name' => 'Student',
            'description' => 'Student who enrolls in courses'
        ]);
    }
}
