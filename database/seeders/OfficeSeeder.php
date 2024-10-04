<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\District;
use App\Models\Poscode;
use App\Models\Province;
use App\Models\Subdistrict;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $province_id = Province::where('province_name', 'DKI JAKARTA')->value('id');
        $city_id = City::where('city_name', 'JAKARTA BARAT')->value('id');
        $district_id = District::where('district_name', 'GROGOL PETAMBURAN')->value('id');
        $subdistrict_id = Subdistrict::where('subdistrict_name', 'GROGOL')->value('id');
        $poscode_id = Poscode::where('poscode', 11450)->value('id');
         DB::table('office')->insert([
            [
                'vendor_id' => 1,
                'code_office' => 'ATS-JKT',
                'office_name' => 'EDC Jakarta',
                'address' => 'Jl. Raya Daan Mogot No.48 A, RT.6/RW.3',
                'pic_name' => 'Intan',
                'email' => 'admin.edc@abacusts.id',
                'phone' => '+62 853-3589-1053',
                'status' => 1,
                'province_id' => $province_id,
                'city_id' => $city_id,
                'district_id' => $district_id,
                'subdistrict_id' => $subdistrict_id,
                'poscode_id' => $poscode_id,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        User::where('name', 'Super Admin')->update(['office_id' => 1]);
        User::where('name', 'Admin ATS')->update(['office_id' => 1]);
        User::where('name', 'Admin Bank')->update(['office_id' => 1]);
        User::where('name', 'Teknisi')->update(['office_id' => 1]);
    }
}
