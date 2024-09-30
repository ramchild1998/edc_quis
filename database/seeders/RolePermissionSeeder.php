<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Buat permissions
        $permissions = ['view jobs', 'edit jobs', 'delete jobs', 'view jobs', 'manage jobs'];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Buat role dan assign permissions
        $vredyRole = Role::create(['name' => 'vredy']);
        $vredyRole->givePermissionTo($permissions);

        $jkt001Role = Role::create(['name' => 'JKT001']);
        $jkt001Role->givePermissionTo(['view jobs']);

        $admats1Role = Role::create(['name' => 'ADMATS1']);
        $admats1Role->givePermissionTo($permissions);

        $admbank1Role = Role::create(['name' => 'ADMBANK1']);
        $admbank1Role->givePermissionTo(['view jobs', 'edit jobs']);

    }
}
