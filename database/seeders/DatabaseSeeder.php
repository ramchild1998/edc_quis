<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $superadmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@abacusts.id',
        ]);
        $adminats = User::factory()->create([
            'name' => 'Admin ATS',
            'email' => 'adminats@abacusts.id',
        ]);
        $adminbank = User::factory()->create([
            'name' => 'Admin Bank',
            'email' => 'adminbank@abacusts.id',
        ]);
        $teknisi = User::factory()->create([
            'name' => 'Teknisi',
            'email' => 'teknisi@abacusts.id',
        ]);
    }
}
