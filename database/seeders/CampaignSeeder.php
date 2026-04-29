<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Campaign;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Campaign::create([
            'name' => 'stack-jump',
            'game_keyword' => 'stack-jump',
            'amount' => 1.00,
            'start_date' => '2025-01-22',
            'start_time' => '10:29:00.000000',
            'end_date' => '2025-01-24',
            'end_time' => '10:29:00.000000',
            'banner' => '/images/campaign/17282738_stack_logo.png',
            'status' => 1,
            'description' => NULL,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Campaign::create([
            'name' => 'Brick Out Camp',
            'game_id' => 12,
            'game_keyword' => 'brick-out',
            'amount' => 1.00,
            'start_date' => '2025-01-22',
            'start_time' => '16:27:00.000000',
            'end_date' => '2025-02-01',
            'end_time' => '16:27:00.000000',
            'banner' => '/images/campaign/1738060085_bo.png',
            'status' => 1,
            'description' => NULL,
            'created_by' => NULL,
            'updated_by' => NULL,
        ]);

        Campaign::create([
            'name' => 'Speed Racer',
            'game_id' => 13,
            'game_keyword' => 'speed-racer',
            'amount' => 1.00,
            'start_date' => '2025-01-27',
            'start_time' => '11:58:00.000000',
            'end_date' => '2025-01-31',
            'end_time' => '11:58:00.000000',
            'banner' => '/images/campaign/1738130309_2829372927_speed logo fin1.png',
            'status' => 1,
            'description' => NULL,
            'created_by' => NULL,
            'updated_by' => NULL,
        ]);
    }
}
