<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            [
                'id'    => 1,
                'name'  => 'list_product',
                'label' => 'Listar Produtos'
            ],
            [
                'id'    => 2,
                'name'  => 'list_categories',
                'label' => 'Listar Categorias'
            ]
        ]);
    }
}
