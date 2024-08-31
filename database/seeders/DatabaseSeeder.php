<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function __construct(protected Role $role, protected Permission $permission, public User $user)
    {
    }
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);

        $roleUser       = $this->role->where('name', 'user')->first();
        $permissionUser = $this->permission->where('name', 'list_categories')->first();
        $user           = $this->user->where('id', 1)->first();
        
        $roleUser->permissions()->attach($permissionUser);
        $user->roles()->attach($roleUser);
    }
}
