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
                'name'  => 'list_products',
                'label' => 'Listar Produtos'
            ],
            [
                'id'    => 2,
                'name'  => 'show_product',
                'label' => 'Mostrar Produto'
            ],
            [
                'id'    => 3,
                'name'  => 'new_product',
                'label' => 'Adicionar novo produto'
            ],
            [
                'id'    => 4,
                'name'  => 'update_product',
                'label' => 'Atualizar produto'
            ],
            [
                'id'    => 5,
                'name'  => 'destroy_product',
                'label' => 'Apagar produto'
            ],
            [
                'id'    => 6,
                'name'  => 'list_categories',
                'label' => 'Listar Categorias'
            ],
            [
                'id'    => 7,
                'name'  => 'show_category',
                'label' => 'Mostrar Categoria'
            ],
            [
                'id'    => 8,
                'name'  => 'new_category',
                'label' => 'Adicionar nova categoria'
            ],
            [
                'id'    => 9,
                'name'  => 'update_category',
                'label' => 'Atualizar categoria'
            ],
            [
                'id'    => 10,
                'name'  => 'destroy_category',
                'label' => 'Apagar categoria'
            ],
            [
                'id'    => 11,
                'name'  => 'list_users',
                'label' => 'Listar usuários'
            ],
            [
                'id'    => 12,
                'name'  => 'show_user',
                'label' => 'Mostrar usuário'
            ],
            [
                'id'    => 13,
                'name'  => 'new_user',
                'label' => 'Adicionar novo usuário'
            ],
            [
                'id'    => 14,
                'name'  => 'update_user',
                'label' => 'Atualizar usuário'
            ],
            [
                'id'    => 15,
                'name'  => 'destroy_user',
                'label' => 'Apagar usuário'
            ],
        ]);
    }
}
