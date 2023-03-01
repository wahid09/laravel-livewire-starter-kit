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
        //$roles = Role::all();
        User::updateOrCreate([
            'role_id' => Role::where('slug', 'super-admin')->first()->id,
            'username' => 'superadmin',
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);

        User::updateOrCreate([
            'role_id' => Role::where('slug', 'staff')->first()->id,
            'username' => 'user',
            'first_name' => 'User',
            'last_name' => 'Admin',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'status' => true
        ]);
    }
}