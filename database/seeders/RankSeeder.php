<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rank::updateOrCreate([
            'rank_name' => 'Lt Col',
            'rank_short_name' => 'Lt Col',
            'rank_order' => '3',
            'created_by' => '1',
        ]);

        Rank::updateOrCreate([
            'rank_name' => 'Brig. Gen',
            'rank_short_name' => 'Brig. Gen',
            'rank_order' => '2',
            'created_by' => '1',
        ]);
        Rank::updateOrCreate([
            'rank_name' => 'Maj Gen',
            'rank_short_name' => 'Maj Gen',
            'rank_order' => '1',
            'created_by' => '1',
        ]);
        Rank::updateOrCreate([
            'rank_name' => 'Col',
            'rank_short_name' => 'Col',
            'rank_order' => '4',
            'created_by' => '1',
        ]);
        Rank::updateOrCreate([
            'rank_name' => 'Maj',
            'rank_short_name' => 'Maj',
            'rank_order' => '5',
            'created_by' => '1',
        ]);
    }
}
