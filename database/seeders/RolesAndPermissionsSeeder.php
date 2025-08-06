<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions list
        $permissions = [
            'manage ads',
            'view ads',
            'delete ads',
            'manage categories',
            'manage brands',
            'manage models',
            'manage media', // images & video
            'manage profile',
            'access billing',
            'view dashboard',
        ];

        // Create each permission
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);

        // Assign all permissions to super_admin
        $superAdmin->syncPermissions(Permission::all());

        // Assign a subset of permissions to admin
        $admin->syncPermissions([
            'manage ads',
            'view ads',
            'manage media',
            'manage profile',
            'view dashboard',
        ]);

        // Assign to first user or specific email
        $user = User::where('email', 'super_admin@motorbazaar.com')->first();

        if ($user && !$user->hasRole($superAdmin)) {
            $user->assignRole($superAdmin);
        }
    }
}
