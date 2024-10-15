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
            'nip' => '01234567',
            'phone' => '0812345678',
            'email' => 'superadmin@abacusts.id',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name' => 'Admin ATS',
            'nip' => '0123456',
            'phone' => '0812345678',
            'email' => 'adminats@abacusts.id',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name' => 'Admin Bank',
            'nip' => '012345',
            'phone' => '0812345678',
            'email' => 'adminbank@abacusts.id',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name' => 'Teknisi',
            'nip' => '01234',
            'phone' => '0812345678',
            'email' => 'teknisi@abacusts.id',
            'password' => Hash::make('12345678'),
        ]);
    }
}
