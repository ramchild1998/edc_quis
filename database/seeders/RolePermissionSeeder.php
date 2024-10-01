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
        $permissions = [
            'User Create', 'User Edit', 'User View',
            'Role Create', 'Role Edit', 'Role View',
            'Permission Create', 'Permission Edit', 'Permission View',
            'Qustion Create', 'Question Edit', 'Question View', 'Question Jobs',
            'Vendor Create', 'Vendor Edit', 'Vendor View',
            'Office Create', 'Office Edit', 'Office View',
            'MappingArea Create', 'MappingArea Edit', 'MappingArea View',
            'Provice Create', 'Provice Edit', 'Provice View',
            'City Create', 'City Edit', 'City View',
            'District Create', 'District Edit', 'District View',
            'Subdistrict Create', 'Subdistrict Edit', 'Subdistrict View',
            'Poscode Create', 'Poscode Edit', 'Poscode View',
            'Report View'];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Buat role dan assign permissions
        $suRole = Role::create(['name' => 'SUPERADMIN']);
        $suRole->givePermissionTo($permissions);

        $teknisiRole = Role::create(['name' => 'TEKNISI']);
        $teknisiRole->givePermissionTo(['Question Jobs']);

        $admatsRole = Role::create(['name' => 'ADMATS']);
        $admatsRole->givePermissionTo(array_diff($permissions, [
            'Provice Create', 'Provice Edit', 'Provice View',
            'City Create', 'City Edit', 'City View',
            'District Create', 'District Edit', 'District View',
            'Subdistrict Create', 'Subdistrict Edit', 'Subdistrict View',
            'Poscode Create', 'Poscode Edit', 'Poscode View']));

        $admbankRole = Role::create(['name' => 'ADMBANK']);
        $admbankRole->givePermissionTo(['Reports View']);

    }
}
