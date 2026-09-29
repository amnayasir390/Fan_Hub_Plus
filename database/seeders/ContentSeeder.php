<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $anime   = Category::where('slug', 'anime')->first();
        $gaming  = Category::where('slug', 'gaming')->first();
        $movies  = Category::where('slug', 'movies')->first();
        $tvShows = Category::where('slug', 'tv-shows')->first();
        $kpop    = Category::where('slug', 'k-pop')->first();
        $comics  = Category::where('slug', 'comics')->first();
        $manga   = Category::where('slug', 'manga')->first();
        $cosplay = Category::where('slug', 'cosplay')->first();

        $contents = [
            // Anime
            ['category_id' => $anime->id,   'title' => 'Attack on Titan: The Complete Story',         'slug' => 'attack-on-titan-complete-story',       'excerpt' => 'From walls to the world beyond — the epic journey of Eren Yeager.',               'cover_image' => 'images/eren-yeager.jpg', 'content_type' => 'article', 'genre' => 'Action',  'release_year' => 2013, 'popularity' => 98, 'tags' => ['shonen','dark','epic']],
            ['category_id' => $anime->id,   'title' => 'Demon Slayer: Kimetsu no Yaiba',              'slug' => 'demon-slayer-kimetsu-no-yaiba',         'excerpt' => 'Tanjiro Kamado fights demons to restore his sister\'s humanity.',                  'cover_image' => 'images/Demon Slayer Nichirin Blade.jpg', 'content_type' => 'article', 'genre' => 'Action',  'release_year' => 2019, 'popularity' => 96, 'tags' => ['shonen','beautiful','emotional']],
            ['category_id' => $anime->id,   'title' => 'My Hero Academia Season 7',                   'slug' => 'my-hero-academia-season-7',             'excerpt' => 'Heroes and villains clash in the Final War arc.',                                  'content_type' => 'article', 'genre' => 'Superhero','release_year' => 2024, 'popularity' => 90, 'tags' => ['shonen','superhero','school']],
            ['category_id' => $anime->id,   'title' => 'Jujutsu Kaisen: Shibuya Incident',            'slug' => 'jujutsu-kaisen-shibuya-incident',       'excerpt' => 'The most devastating arc in modern shonen anime unfolds.',                         'content_type' => 'article', 'genre' => 'Supernatural','release_year' => 2023,'popularity' => 95, 'tags' => ['dark','supernatural','intense']],
            ['category_id' => $anime->id,   'title' => 'One Piece: Gear 5 Revealed',                  'slug' => 'one-piece-gear-5-revealed',             'excerpt' => 'Luffy awakens the true power of the Gomu Gomu no Mi.',                            'content_type' => 'article', 'genre' => 'Adventure','release_year' => 2023, 'popularity' => 97, 'tags' => ['pirate','adventure','legendary']],
            // Gaming
            ['category_id' => $gaming->id,  'title' => 'Elden Ring: A Masterpiece of Open World',    'slug' => 'elden-ring-masterpiece',               'excerpt' => 'FromSoftware and George R.R. Martin craft the ultimate open-world RPG.',           'cover_image' => 'images/Elden Ring Tarnished Edition Art Book.jpg', 'content_type' => 'article', 'genre' => 'RPG',     'release_year' => 2022, 'popularity' => 99, 'tags' => ['rpg','open-world','dark-fantasy']],
            ['category_id' => $gaming->id,  'title' => 'God of War Ragnarök: Kratos Returns',         'slug' => 'god-of-war-ragnarok',                  'excerpt' => 'Kratos and Atreus face the Norse apocalypse in this sequel.',                      'cover_image' => 'images/Kratos.jpg', 'content_type' => 'article',  'genre' => 'Action',  'release_year' => 2022, 'popularity' => 97, 'tags' => ['action','mythology','sequel']],
            ['category_id' => $gaming->id,  'title' => 'The Legend of Zelda: Tears of the Kingdom',   'slug' => 'zelda-tears-of-the-kingdom',           'excerpt' => 'Link soars above Hyrule in a groundbreaking open-air adventure.',                  'content_type' => 'article', 'genre' => 'Adventure','release_year' => 2023, 'popularity' => 98, 'tags' => ['adventure','nintendo','open-world']],
            ['category_id' => $gaming->id,  'title' => 'Cyberpunk 2077: Phantom Liberty',             'slug' => 'cyberpunk-2077-phantom-liberty',        'excerpt' => 'Night City espionage in the biggest expansion for Cyberpunk 2077.',               'content_type' => 'article', 'genre' => 'RPG',     'release_year' => 2023, 'popularity' => 88, 'tags' => ['cyberpunk','dlc','espionage']],
            ['category_id' => $gaming->id,  'title' => 'Baldur\'s Gate 3: The CRPG Throne',          'slug' => 'baldurs-gate-3',                        'excerpt' => 'Larian Studios delivers the definitive RPG experience of the decade.',            'content_type' => 'article', 'genre' => 'RPG',     'release_year' => 2023, 'popularity' => 100,'tags' => ['rpg','dnd','choice']],
            // Movies
            ['category_id' => $movies->id,  'title' => 'Dune: Part Two – Desert Planet Spectacle',   'slug' => 'dune-part-two',                        'excerpt' => 'Denis Villeneuve completes his stunning sci-fi epic.',                            'content_type' => 'article', 'genre' => 'Sci-Fi',  'release_year' => 2024, 'popularity' => 94, 'tags' => ['sci-fi','epic','adaptation']],
            ['category_id' => $movies->id,  'title' => 'Spider-Man: Across the Spider-Verse',         'slug' => 'spider-man-across-spider-verse',        'excerpt' => 'Miles Morales faces the Spider-Society in an animation revolution.',              'content_type' => 'article', 'genre' => 'Animation','release_year' => 2023,'popularity' => 98, 'tags' => ['animated','marvel','multiverse']],
            ['category_id' => $movies->id,  'title' => 'Avengers: Secret Wars – What We Know',       'slug' => 'avengers-secret-wars-preview',          'excerpt' => 'Everything we know about the MCU\'s next mega-event film.',                      'content_type' => 'article', 'genre' => 'Superhero','release_year' => 2026,'popularity' => 92, 'tags' => ['mcu','avengers','spoilers']],
            ['category_id' => $movies->id,  'title' => 'The Batman Part II: What\'s Next for Gotham','slug' => 'the-batman-part-2',                     'excerpt' => 'Matt Reeves and Robert Pattinson return to Gotham\'s darkest corners.',          'content_type' => 'article', 'genre' => 'Superhero','release_year' => 2026,'popularity' => 89, 'tags' => ['dc','batman','noir']],
            // TV Shows
            ['category_id' => $tvShows->id, 'title' => 'House of the Dragon Season 3 Preview',       'slug' => 'house-of-the-dragon-s3-preview',        'excerpt' => 'The Targaryen civil war escalates in the upcoming season.',                       'content_type' => 'article', 'genre' => 'Fantasy', 'release_year' => 2025, 'popularity' => 90, 'tags' => ['hbo','dragons','westeros']],
            ['category_id' => $tvShows->id, 'title' => 'The Last of Us Season 2 Breakdown',          'slug' => 'the-last-of-us-s2-breakdown',           'excerpt' => 'Ellie and Dina\'s story adapts the iconic second game.',                         'content_type' => 'article', 'genre' => 'Drama',   'release_year' => 2025, 'popularity' => 95, 'tags' => ['hbo','post-apocalyptic','emotional']],
            ['category_id' => $tvShows->id, 'title' => 'Arcane Season 2: Vi and Jinx Return',         'slug' => 'arcane-season-2',                       'excerpt' => 'Netflix and Riot Games continue the visually stunning Arcane saga.',              'content_type' => 'article', 'genre' => 'Animation','release_year' => 2024,'popularity' => 96, 'tags' => ['netflix','league-of-legends','animated']],
            // K-Pop
            ['category_id' => $kpop->id,    'title' => 'BTS: The Legacy of Bangtan',                 'slug' => 'bts-legacy-of-bangtan',                 'excerpt' => 'How BTS reshaped global pop music and fan culture.',                              'content_type' => 'article', 'genre' => 'Idol',    'release_year' => 2024, 'popularity' => 99, 'tags' => ['bts','army','legendary']],
            ['category_id' => $kpop->id,    'title' => 'BLACKPINK: Born Pink World Tour Recap',       'slug' => 'blackpink-born-pink-world-tour',        'excerpt' => 'The record-breaking world tour that proved girl groups dominate.',               'content_type' => 'article', 'genre' => 'Tour',    'release_year' => 2023, 'popularity' => 97, 'tags' => ['blackpink','blink','tour']],
            ['category_id' => $kpop->id,    'title' => 'SEVENTEEN: Going Global in 2025',             'slug' => 'seventeen-global-2025',                 'excerpt' => 'The self-producing group SEVENTEEN continues their global rise.',                  'content_type' => 'article', 'genre' => 'Idol',    'release_year' => 2025, 'popularity' => 91, 'tags' => ['seventeen','carat','self-produce']],
            // Comics
            ['category_id' => $comics->id,  'title' => 'X-Men: From the Ashes Era Begins',           'slug' => 'x-men-from-the-ashes',                  'excerpt' => 'Marvel relaunches the X-Men with a bold new direction post-Fall of X.',          'content_type' => 'article', 'genre' => 'Superhero','release_year' => 2024,'popularity' => 88, 'tags' => ['marvel','x-men','relaunch']],
            ['category_id' => $comics->id,  'title' => 'Batman: The Long Halloween – A Timeless Noir','slug' => 'batman-long-halloween',                 'excerpt' => 'Jeph Loeb\'s masterpiece remains the definitive Batman mystery.',               'content_type' => 'article', 'genre' => 'Noir',    'release_year' => 1996, 'popularity' => 95, 'tags' => ['dc','batman','classic']],
            // Manga
            ['category_id' => $manga->id,   'title' => 'Chainsaw Man Part 2: Asa Mitaka\'s Arc',    'slug' => 'chainsaw-man-part-2',                   'excerpt' => 'Fujimoto continues with War Devil Asa in a gripping new chapter.',               'content_type' => 'article', 'genre' => 'Dark Fantasy','release_year' => 2022,'popularity' => 93,'tags' => ['dark','chainsaw-man','fujimoto']],
            ['category_id' => $manga->id,   'title' => 'Berserk: The Legacy of Kentaro Miura',       'slug' => 'berserk-legacy-miura',                  'excerpt' => 'Celebrating the dark fantasy that changed manga forever.',                        'content_type' => 'article', 'genre' => 'Dark Fantasy','release_year' => 1989,'popularity' => 99,'tags' => ['classic','dark-fantasy','legacy']],
            // Cosplay
            ['category_id' => $cosplay->id, 'title' => 'Beginner\'s Guide to Armor Crafting',       'slug' => 'beginners-guide-armor-crafting',        'excerpt' => 'EVA foam, Worbla, and resin — your first steps into prop making.',               'content_type' => 'article', 'genre' => 'Tutorial','release_year' => 2024,  'popularity' => 85, 'tags' => ['beginner','eva-foam','tutorial']],
            ['category_id' => $cosplay->id, 'title' => 'Cosplay Contest Winners: Anime Expo 2025',   'slug' => 'cosplay-winners-anime-expo-2025',       'excerpt' => 'The most breathtaking costumes from Anime Expo\'s annual masquerade.',           'content_type' => 'article', 'genre' => 'Event',   'release_year' => 2025, 'popularity' => 82, 'tags' => ['event','winners','showcase']],
        ];

        foreach ($contents as $data) {
            $data['body']   = $data['excerpt'] . ' This is extended placeholder content for the article body. ' . str_repeat('Lorem ipsum dolor sit amet, consectetur adipiscing elit. ', 10);
            $data['status'] = 'published';
            Content::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
