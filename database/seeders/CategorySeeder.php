<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Anime',   'slug' => 'anime',   'description' => 'Japanese animation spanning every genre imaginable.',          'icon' => '🎌', 'color' => '#FF6B6B', 'sort_order' => 1],
            ['name' => 'Gaming',  'slug' => 'gaming',  'description' => 'Video games, esports, walkthroughs, and gaming culture.',      'icon' => '🎮', 'color' => '#4ECDC4', 'sort_order' => 2],
            ['name' => 'Movies',  'slug' => 'movies',  'description' => 'Blockbusters, indie films, trailers, and cinematic universes.', 'icon' => '🎬', 'color' => '#FFE66D', 'sort_order' => 3],
            ['name' => 'TV Shows','slug' => 'tv-shows','description' => 'Series, seasons, episode guides, and fandom theories.',        'icon' => '📺', 'color' => '#A8E6CF', 'sort_order' => 4],
            ['name' => 'K-Pop',   'slug' => 'k-pop',   'description' => 'Korean pop music, idols, groups, and fan culture.',            'icon' => '🎤', 'color' => '#FF8B94', 'sort_order' => 5],
            ['name' => 'Comics',  'slug' => 'comics',  'description' => 'Marvel, DC, and indie comics, heroes, and story arcs.',        'icon' => '💥', 'color' => '#B8B8FF', 'sort_order' => 6],
            ['name' => 'Manga',   'slug' => 'manga',   'description' => 'Japanese comics, webtoons, and illustrated storytelling.',     'icon' => '📖', 'color' => '#FFDAC1', 'sort_order' => 7],
            ['name' => 'Cosplay', 'slug' => 'cosplay', 'description' => 'Costume artistry, tutorials, events, and cosplay communities.','icon' => '🎭', 'color' => '#C7CEEA', 'sort_order' => 8],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
