<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Buat akun
        $superadmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@abacusts.id',
            'password' => Hash::make('12345678'),
        ]);
        $adminats = User::factory()->create([
            'name' => 'Admin ATS',
            'email' => 'adminats@abacusts.id',
            'password' => Hash::make('12345678'),
        ]);
        $adminbank = User::factory()->create([
            'name' => 'Admin Bank',
            'email' => 'adminbank@abacusts.id',
            'password' => Hash::make('12345678'),
        ]);
        $teknisi = User::factory()->create([
            'name' => 'Teknisi',
            'email' => 'teknisi@abacusts.id',
            'password' => Hash::make('12345678'),
        ]);

        // Buat permissions
        $permissions = [
            'User Create', 'User Edit', 'User View',
            'Role Create', 'Role Edit', 'Role View',
            'Permission Create', 'Permission Edit', 'Permission View',
            'Visit Create', 'Visit Edit', 'Visit View',
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
        $teknisiRole->givePermissionTo(['Visit Create, Visit View']);

        $admatsRole = Role::create(['name' => 'ADMATS']);
        $admatsRole->givePermissionTo(array_diff($permissions, [
            'Provice Create', 'Provice Edit', 'Provice View',
            'City Create', 'City Edit', 'City View',
            'District Create', 'District Edit', 'District View',
            'Subdistrict Create', 'Subdistrict Edit', 'Subdistrict View',
            'Poscode Create', 'Poscode Edit', 'Poscode View']));

        $admbankRole = Role::create(['name' => 'ADMBANK']);
        $admbankRole->givePermissionTo(['Report View']);

        // Assign role
        $superadmin->assignRole('SUPERADMIN');
        $adminats->assignRole('ADMATS');
        $adminbank->assignRole('ADMBANK');
        $teknisi->assignRole('TEKNISI');

    }
}
