<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $admin   = User::where('email', 'admin@fanhubplus.com')->first();
        $anime   = Category::where('slug', 'anime')->first();
        $gaming  = Category::where('slug', 'gaming')->first();
        $movies  = Category::where('slug', 'movies')->first();
        $kpop    = Category::where('slug', 'k-pop')->first();
        $cosplay = Category::where('slug', 'cosplay')->first();
        $tvShows = Category::where('slug', 'tv-shows')->first();
        $comics  = Category::where('slug', 'comics')->first();

        $body = fn(string $text) => "<p>{$text}</p><p>" . implode('</p><p>', array_fill(0, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.')) . '</p>';

        $articles = [
            // Featured articles
            ['category_id' => $anime->id,   'user_id' => $admin->id, 'title' => 'Top 10 Anime of 2024 – The Year in Review',                   'slug' => 'top-10-anime-2024',             'excerpt' => 'We rank the standout anime titles that defined 2024.', 'cover_image' => 'images/Top 10 Anime of 2024 – The Year in Review.jpg', 'article_type' => 'article',          'status' => 'published', 'is_featured' => true,  'view_count' => 4820, 'tags' => ['2024','rankings','review']],
            ['category_id' => $gaming->id,  'user_id' => $admin->id, 'title' => 'Best RPGs Released in 2023: A Complete Guide',                 'slug' => 'best-rpgs-2023',                'excerpt' => 'From Baldur\'s Gate 3 to Starfield — the RPG year that delivered.', 'cover_image' => 'images/Best RPGs Released in 2023.jpg', 'article_type' => 'article',          'status' => 'published', 'is_featured' => true,  'view_count' => 3960, 'tags' => ['rpg','2023','guide']],
            ['category_id' => $movies->id,  'user_id' => $admin->id, 'title' => 'The Marvel Cinematic Universe: Phase 5 and Beyond',            'slug' => 'mcu-phase-5-beyond',            'excerpt' => 'Where the MCU is headed and what fans can expect next.', 'cover_image' => 'images/The Marvel Cinematic Universe.jpg', 'article_type' => 'article',          'status' => 'published', 'is_featured' => true,  'view_count' => 5100, 'tags' => ['mcu','marvel','phase5']],
            ['category_id' => $kpop->id,    'user_id' => $admin->id, 'title' => 'K-Pop\'s Global Takeover: How South Korea Conquered Music',    'slug' => 'kpop-global-takeover',          'excerpt' => 'An analysis of how K-Pop engineered its worldwide fanbase.',                       'article_type' => 'article',          'status' => 'published', 'is_featured' => true,  'view_count' => 4200, 'tags' => ['kpop','music','culture']],
            ['category_id' => $cosplay->id, 'user_id' => $admin->id, 'title' => 'Cosplay as Art: The Making of Award-Winning Costumes',          'slug' => 'cosplay-as-art',                'excerpt' => 'Dive into the craftsmanship behind competition-winning cosplay builds.',           'article_type' => 'article',          'status' => 'published', 'is_featured' => true,  'view_count' => 2800, 'tags' => ['art','craftsmanship','competition']],
            // Event Highlights
            ['category_id' => $anime->id,   'user_id' => $admin->id, 'title' => 'Anime Expo 2025: Everything That Happened',                    'slug' => 'anime-expo-2025-highlights',    'excerpt' => 'Panels, announcements, and unforgettable moments from AX 2025.',                  'article_type' => 'event_highlight',  'status' => 'published', 'is_featured' => true,  'view_count' => 6300, 'event_date' => '2025-07-04', 'event_location' => 'Los Angeles, CA', 'tags' => ['event','anime-expo','2025']],
            ['category_id' => $gaming->id,  'user_id' => $admin->id, 'title' => 'The Game Awards 2024: Winners and Highlights',                  'slug' => 'game-awards-2024-highlights',   'excerpt' => 'A full recap of the biggest night in gaming.',                                     'article_type' => 'event_highlight',  'status' => 'published', 'is_featured' => false, 'view_count' => 5400, 'event_date' => '2024-12-12', 'event_location' => 'Los Angeles, CA', 'tags' => ['awards','gaming','2024']],
            ['category_id' => $movies->id,  'user_id' => $admin->id, 'title' => 'San Diego Comic-Con 2025: Marvel & DC Panels Recap',            'slug' => 'sdcc-2025-marvel-dc-recap',     'excerpt' => 'Every announcement from the biggest comic convention on earth.',                   'article_type' => 'event_highlight',  'status' => 'published', 'is_featured' => false, 'view_count' => 4700, 'event_date' => '2025-07-24', 'event_location' => 'San Diego, CA',   'tags' => ['sdcc','marvel','dc']],
            ['category_id' => $kpop->id,    'user_id' => $admin->id, 'title' => 'KCON 2025 LA: A Day in the Life',                               'slug' => 'kcon-2025-la-recap',            'excerpt' => 'Fan accounts, artist stages, and the electric energy of KCON LA 2025.',           'article_type' => 'event_highlight',  'status' => 'published', 'is_featured' => false, 'view_count' => 3800, 'event_date' => '2025-08-03', 'event_location' => 'Los Angeles, CA', 'tags' => ['kcon','kpop','event']],
            // More articles
            ['category_id' => $tvShows->id, 'user_id' => $admin->id, 'title' => 'Why Arcane is the Best Video Game Adaptation Ever Made',        'slug' => 'arcane-best-adaptation',        'excerpt' => 'A deep dive into why Arcane succeeded where so many others failed.',               'article_type' => 'article',          'status' => 'published', 'is_featured' => false, 'view_count' => 3200, 'tags' => ['arcane','adaptation','netflix']],
            ['category_id' => $comics->id,  'user_id' => $admin->id, 'title' => 'The Best Marvel Comics to Read Before the Next MCU Film',       'slug' => 'best-marvel-comics-mcu',        'excerpt' => 'Essential reading for any fan heading into the next Avengers chapter.',             'article_type' => 'article',          'status' => 'published', 'is_featured' => false, 'view_count' => 2900, 'tags' => ['marvel','comics','reading-list']],
        ];

        foreach ($articles as $data) {
            $data['body'] = $body($data['excerpt']);
            Article::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
