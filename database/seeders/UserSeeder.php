<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan tidak double (kalau sudah ada, update saja)
        DB::table('users')->updateOrInsert(
            ['id' => 1],
            [
                'name' => 'User Dummy',
                'email' => 'user@example.com',
                'password' => Hash::make('password'), // default: 'password'
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
