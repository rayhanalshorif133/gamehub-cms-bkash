<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Game::create([
            'title' => 'Stack Jump3',
            'banner' => '/images/game/1737883413_secret-of-mobile-apps.jpg',
            'description' => 'stack-jump',
            'keyword' => 'stack-jump',
            'url' => 'http://bkash.bdgamers.club/public/games/stack-jump/',
            'status' => 1,
        ]);

        Game::create([
            'title' => 'Stack Jump0',
            'banner' => 'https://picsum.photos/seed/picsum/200/200',
            'description' => 'stack-jump',
            'keyword' => 'stack-jump0',
            'url' => 'http://bkash.bdgamers.club/public/games/stack-jump/',
            'status' => 1,
        ]);

        Game::create([
            'title' => 'Brick Out',
            'banner' => '/images/game/1738059975_secret-of-mobile-apps.jpg',
            'description' => 'brick-out',
            'keyword' => 'brick-out',
            'url' => 'http://bkash.bdgamers.club/public/games/brick-out/',
            'status' => 1,
        ]);

        Game::create([
            'title' => 'Speed Racer',
            'banner' => '/images/game/1738130275_2829372927_speed logo fin1.png',
            'description' => 'speed-racer',
            'keyword' => 'speed-racer',
            'url' => 'http://bkash.bdgamers.club/public/games/speed-racer/',
            'status' => 1,
        ]);

    }
}
