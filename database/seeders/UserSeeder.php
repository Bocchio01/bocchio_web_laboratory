<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Tommaso Bocchietti',
            'email' => 'tommaso.bocchietti@gmail.com',
            'password' => Hash::make('1234'),
            'is_admin' => true,
        ]);

        User::factory(10)->create();
    }
}
