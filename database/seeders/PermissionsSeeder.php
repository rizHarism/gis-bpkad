<?php

namespace Database\Seeders;

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
        Permission::firstOrCreate(['name' => 'dasar bmd.index']);
        Permission::firstOrCreate(['name' => 'data aset.index']);
        Permission::firstOrCreate(['name' => 'data aset.inventaris kib a']);
        Permission::firstOrCreate(['name' => 'data aset.inventaris kib c']);
        Permission::firstOrCreate(['name' => 'data aset.inventaris kib d']);
        Permission::firstOrCreate(['name' => 'pengelolaan aset.index']);
        Permission::firstOrCreate(['name' => 'pengelolaan aset.pengadaan']);
        Permission::firstOrCreate(['name' => 'pengelolaan aset.mutasi aset']);
        Permission::firstOrCreate(['name' => 'administrator.index']);
        Permission::firstOrCreate(['name' => 'adminstrator.setting profil']);
        Permission::firstOrCreate(['name' => 'administrator.konfigurasi simantab']);
        Permission::firstOrCreate(['name' => 'data opd.index']);

        // Assigning super admin
        $superAdminRole = Role::firstOrCreate(['name' => 'Super-Admin']);

        $user = \App\Models\User::where('email', 'admin@test')->first();
        if (!$user) {
            $user = \App\Models\User::firstOrCreate([
                'username' => 'Admin',
                'email' => 'admin@test',
                'password' => bcrypt('1234567809'),
            ]);
            echo "email: admin@test\n";
            echo "password: 1234567809\n";
        }


        $user->assignRole($superAdminRole);

        // default role
        $generalRole = Role::firstOrCreate(['name' => 'General']);
        $generalPermissions = [
            'dasar bmd.index',
            'data aset.index',
            'data aset.inventaris kib a',
            'data aset.inventaris kib c',
            'data aset.inventaris kib d',
            'pengelolaan aset.index',
            'pengelolaan aset.pengadaan',
            'pengelolaan aset.mutasi aset',
            'data opd.index',
        ];
        $generalRole->syncPermissions($generalPermissions);
    }
}