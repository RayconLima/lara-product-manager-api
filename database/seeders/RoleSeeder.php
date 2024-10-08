<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'name' => 'super-admin',
                'label' => 'Super Administrador'
            ],
            [
                'name' => 'admin',
                'label' => 'Administrador'
            ],
            [
                'name' => 'seller',
                'label' => 'vendedor'
            ]
        ]);
    }
}
