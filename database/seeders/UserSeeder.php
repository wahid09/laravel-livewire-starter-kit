<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'role_id' => Role::where('slug', 'super-admin')->first()->id,
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);

        User::updateOrCreate([
            'role_id' => Role::where('slug', 'staff')->first()->id,
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);
    }
}
