<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'  => 'super admin',
            'email' => 'admin@admin.com',
        ]);
        User::factory()->create([
            'name'  => 'fulano',
            'email' => 'fulano@example.com',
        ]);
        User::factory()->create([
            'name'  => 'ciclano',
            'email' => 'ciclano@example.com',
        ]);
    }
}
