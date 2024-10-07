<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(ProvinceSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(SubdistrictSeeder::class);
        $this->call(PoscodeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(VendorSeeder::class);
        $this->call(OfficeSeeder::class);
        // User::factory(10)->create();
        $this->call(RolePermissionSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(MapingAreaSeeder::class);
    }
}
