<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'user_name' => 'admin_1',
            'password' => Hash::make('admin123'),
            'email' => 'admin@admin.com',
            'user_role' => User::IS_ADMIN,
            'registered_at' => now()
        ]);
    }
}
