<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('area')->insert([
             ['area_name' => 'Thamrin', 'id_area' => '029', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Menteng DPI', 'id_area' => '030', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Kuningan', 'id_area' => '031', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Karet Satrio', 'id_area' => '032', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Senopati', 'id_area' => '033', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Senayan', 'id_area' => '034', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Blok M', 'id_area' => '035', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Pondok Indah Plaza', 'id_area' => '036', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Gandaria', 'id_area' => '037', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Pejaten', 'id_area' => '038', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Kemang', 'id_area' => '039', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Fatmawati', 'id_area' => '040', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Bintaro', 'id_area' => '041', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Ciledug', 'id_area' => '042', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Pamulang', 'id_area' => '043', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Pondok Cabe', 'id_area' => '044', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Depok', 'id_area' => '045', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['area_name' => 'Cimanggis', 'id_area' => '046', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
