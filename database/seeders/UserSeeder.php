<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@abacusts.id',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name' => 'Admin ATS',
            'email' => 'adminats@abacusts.id',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name' => 'Admin Bank',
            'email' => 'adminbank@abacusts.id',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name' => 'Teknisi',
            'email' => 'teknisi@abacusts.id',
            'password' => Hash::make('12345678'),
        ]);
    }
}
