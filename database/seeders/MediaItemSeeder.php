<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MediaItem;
use Illuminate\Database\Seeder;

class MediaItemSeeder extends Seeder
{
    public function run(): void
    {
        $anime   = Category::where('slug', 'anime')->first();
        $gaming  = Category::where('slug', 'gaming')->first();
        $movies  = Category::where('slug', 'movies')->first();
        $kpop    = Category::where('slug', 'k-pop')->first();
        $cosplay = Category::where('slug', 'cosplay')->first();
        $tvShows = Category::where('slug', 'tv-shows')->first();

        $mediaItems = [
            // Anime Videos
            ['category_id' => $anime->id,   'title' => 'Demon Slayer – Mugen Train Clip',       'media_type' => 'trailer', 'url' => 'https://www.youtube.com/watch?v=6vMuWuWlW4I', 'description' => 'The breathtaking Mugen Train scene featuring Flame Hashira Rengoku.',     'tags' => ['demon-slayer','rengoku','fire'],   'is_featured' => true],
            ['category_id' => $anime->id,   'title' => 'Attack on Titan Opening – Guren no Yumiya', 'media_type' => 'video', 'url' => 'https://www.youtube.com/watch?v=CID-sYQNCew', 'description' => 'The iconic first opening that launched a generation of anime fans.',      'tags' => ['aot','opening','iconic'],          'is_featured' => true],
            ['category_id' => $anime->id,   'title' => 'Jujutsu Kaisen – Gojo vs Sukuna Trailer','media_type' => 'trailer', 'url' => 'https://www.youtube.com/watch?v=pkKu9hLT-t8', 'description' => 'Official trailer for the most anticipated clash in JJK history.',        'tags' => ['jjk','gojo','sukuna'],            'is_featured' => true],
            ['category_id' => $anime->id,   'title' => 'One Piece – Gear 5 Awakening Scene',    'media_type' => 'video',   'url' => 'https://www.youtube.com/watch?v=EsiBphMpqsM', 'description' => 'Luffy\'s legendary transformation that broke the internet.',              'tags' => ['one-piece','gear-5','luffy'],      'is_featured' => true],
            // Gaming Trailers
            ['category_id' => $gaming->id,  'title' => 'Elden Ring – Official Launch Trailer',  'media_type' => 'trailer', 'url' => 'https://www.youtube.com/watch?v=E3Huy2cdih0', 'description' => 'Behold the Lands Between in the official launch trailer.',              'tags' => ['elden-ring','fromsoftware','rpg'], 'is_featured' => true],
            ['category_id' => $gaming->id,  'title' => 'God of War Ragnarök – Gameplay Reveal', 'media_type' => 'trailer', 'url' => 'https://www.youtube.com/watch?v=EE-4GvjKcfs', 'description' => 'Kratos and Atreus face new Norse gods in explosive gameplay.',          'tags' => ['god-of-war','kratos','ps5'],       'is_featured' => true],
            ['category_id' => $gaming->id,  'title' => 'Zelda: Tears of the Kingdom – Trailer', 'media_type' => 'trailer', 'url' => 'https://www.youtube.com/watch?v=uHGShqcAHlQ', 'description' => 'Link takes to the skies above Hyrule in this stunning reveal.',        'tags' => ['zelda','nintendo','open-world'],   'is_featured' => false],
            ['category_id' => $gaming->id,  'title' => 'Baldur\'s Gate 3 – Official Gameplay',  'media_type' => 'video',   'url' => 'https://www.youtube.com/watch?v=og5xnFl9mXA', 'description' => 'Deep dive into the mechanics and story of the year\'s best RPG.',     'tags' => ['bg3','rpg','larian'],              'is_featured' => false],
            // Movie Trailers
            ['category_id' => $movies->id,  'title' => 'Dune Part Two – Official Trailer',      'media_type' => 'trailer', 'url' => 'https://www.youtube.com/watch?v=Way9Dexny3w', 'description' => 'Paul Atreides leads the Fremen against the Harkonnen empire.',         'tags' => ['dune','sci-fi','villeneuve'],      'is_featured' => true],
            ['category_id' => $movies->id,  'title' => 'Spider-Verse 2 – Official Trailer',     'media_type' => 'trailer', 'url' => 'https://www.youtube.com/watch?v=cqGjhVJWtEg', 'description' => 'Miles Morales leaps into the Spider-Society multiverse.',              'tags' => ['spider-man','animated','marvel'],  'is_featured' => true],
            // K-Pop
            ['category_id' => $kpop->id,    'title' => 'BTS – Dynamite Official MV',            'media_type' => 'video',   'url' => 'https://www.youtube.com/watch?v=gdZLi9oWNZg', 'description' => 'BTS\' smash English-language hit that conquered global charts.',       'tags' => ['bts','dynamite','mv'],            'is_featured' => true],
            ['category_id' => $kpop->id,    'title' => 'BLACKPINK – Pink Venom MV',             'media_type' => 'video',   'url' => 'https://www.youtube.com/watch?v=tyrany_kWjKQ','description' => 'BLACKPINK returns with fierce energy in Pink Venom.',                  'tags' => ['blackpink','mv','blink'],          'is_featured' => true],
            ['category_id' => $kpop->id,    'title' => 'SEVENTEEN – HOT Official MV',           'media_type' => 'video',   'url' => 'https://www.youtube.com/watch?v=pWMVTc1rrSw', 'description' => 'SEVENTEEN\'s powerful comeback with synchronized choreography.',       'tags' => ['seventeen','carat','mv'],          'is_featured' => false],
            // TV Shows
            ['category_id' => $tvShows->id, 'title' => 'House of the Dragon S2 – Trailer',      'media_type' => 'trailer', 'url' => 'https://www.youtube.com/watch?v=DotnJ7tTA34', 'description' => 'Dragons clash as the Dance of Dragons begins.',                       'tags' => ['hotd','hbo','dragons'],           'is_featured' => true],
            ['category_id' => $tvShows->id, 'title' => 'Arcane Season 2 – Official Trailer',    'media_type' => 'trailer', 'url' => 'https://www.youtube.com/watch?v=yzrGByHW8HI', 'description' => 'Vi, Jinx and Jayce return in the explosive second season.',            'tags' => ['arcane','netflix','lol'],          'is_featured' => true],
            // Cosplay Audio
            ['category_id' => $cosplay->id, 'title' => 'Cosplay Tips Podcast – Episode 12',     'media_type' => 'audio',   'url' => 'https://www.soundcloud.com/cosplay-podcast/ep12', 'description' => 'Professional cosplayers share tips on advanced wig styling.',     'tags' => ['podcast','wigs','tips'],          'is_featured' => false],
        ];

        foreach ($mediaItems as $data) {
            MediaItem::firstOrCreate(
                ['title' => $data['title'], 'category_id' => $data['category_id']],
                $data
            );
        }
    }
}
