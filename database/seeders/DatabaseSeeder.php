<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Specification;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        //$this->call(ServiceSeeder::class);
        //$this->call(DivisionSeeder::class);
        $this->call(RankSeeder::class);
        //$this->call(UnitSeeder::class);
        //$this->call(SpecificationSeeder::class);
        //$this->call(ItemTypeSeeder::class);
        //$this->call(ControlTypeSeeder::class);
        //$this->call(AccountUnitSeeder::class);
        //$this->call(ItemGroupSeeder::class);
        //$this->call(ItemTypeSeeder::class);
        //$this->call(ItemDepartmentSeeder::class);
        //$this->call(ItemSectionSeeder::class);
    }
}