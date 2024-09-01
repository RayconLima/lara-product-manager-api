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
        
        $user = User::where('name', 'super admin')->first();
        $role = Role::where('name', 'super-admin')->first();
        $user->roles()->attach($role);

        $this->setAdmin();
        $this->setSeller();
    }

    private function setSeller(): void
    {
        $user = User::where('name', 'ciclano')->first();
        $role = Role::where('name', 'seller')->first();

        $permissionsSeller = [
            'list_products',
            'show_product',
            'update_product',
            'list_categories',
            'show_category'
        ];

        $existingPermissions = $role->permissions->pluck('name')->toArray();

        $newPermissions = array_diff($permissionsSeller, $existingPermissions);

        $permissionIds = Permission::whereIn('name', $newPermissions)->pluck('id');

        $role->permissions()->attach($permissionIds);

        $user->roles()->attach($role);
    }
    
    private function setAdmin(): void
    {
        $user = User::where('name', 'fulano')->first();
        $role = Role::where('name', 'admin')->first();
        $permissions = Permission::all();
        $role->permissions()->attach($permissions);
        $user->roles()->attach($role);
    }
}
