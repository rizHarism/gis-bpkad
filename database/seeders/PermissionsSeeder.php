<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();


        // create permissions
        // user

        Permission::firstOrCreate(['name' => 'home.peta sebaran']);
        Permission::firstOrCreate(['name' => 'dashboard.index']);
        Permission::firstOrCreate(['name' => 'data dasar.index']);
        Permission::firstOrCreate(['name' => 'data dasar.bmd']);
        Permission::firstOrCreate(['name' => 'data dasar.opd']);
        Permission::firstOrCreate(['name' => 'data aset.index']);
        Permission::firstOrCreate(['name' => 'data aset.aset tanah']);
        Permission::firstOrCreate(['name' => 'data aset.aset gedung']);
        Permission::firstOrCreate(['name' => 'data aset.aset jaringan']);
        Permission::firstOrCreate(['name' => 'administrator.index']);
        Permission::firstOrCreate(['name' => 'administrator.pengaturan role']);
        Permission::firstOrCreate(['name' => 'administrator.manajemen user']);


        // Assigning super admin
        User::truncate();
        $superAdminRole = Role::firstOrCreate(['name' => 'Super-Admin']);
        $superAdminPermissions = [
            'home.peta sebaran',
            'dashboard.index',
            'data dasar.index',
            'data dasar.bmd',
            'data dasar.opd',
            'data aset.index',
            'data aset.aset tanah',
            'data aset.aset gedung',
            'data aset.aset jaringan',
            'administrator.index',
            'administrator.pengaturan role',
            'administrator.manajemen user',
        ];
        $superAdminRole->syncPermissions($superAdminPermissions);

        $user = \App\Models\User::where('username', 'Admin')->first();
        if (!$user) {
            $user = \App\Models\User::firstOrCreate([
                'username' => 'Admin',
                // 'email' => 'admin@test',
                'password' => bcrypt('1234567809'),
                'skpd_id' => '848',
                'avatar' => 'default-avatar.png',
            ]);
            echo "username: Admin\n";
            echo "password: 1234567809\n";
        }


        $user->assignRole($superAdminRole);

        // default role
        $generalRole = Role::firstOrCreate(['name' => 'General']);
        $generalPermissions = [
            'home.peta sebaran',
        ];
        $generalRole->syncPermissions($generalPermissions);
    }
}
