<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Province::factory()->count(10)->create();
        $dumpFilePath = database_path('seeds/edc_db_city.sql');
        if (file_exists($dumpFilePath)) {
            $sql = file_get_contents($dumpFilePath);
            DB::unprepared($sql);
        }
    }
}
