<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Merchandise;
use Illuminate\Database\Seeder;

class MerchandiseSeeder extends Seeder
{
    public function run(): void
    {
        $anime   = Category::where('slug', 'anime')->first();
        $gaming  = Category::where('slug', 'gaming')->first();
        $movies  = Category::where('slug', 'movies')->first();
        $kpop    = Category::where('slug', 'k-pop')->first();
        $comics  = Category::where('slug', 'comics')->first();
        $cosplay = Category::where('slug', 'cosplay')->first();

        $items = [
            ['category_id' => $anime->id,   'name' => 'Attack on Titan Scout Regiment Cloak',        'slug' => 'aot-scout-cloak',             'description' => 'Official replica of the iconic Scout Regiment cloak worn by Eren and Levi.', 'image' => 'images/Attack on Titan Scout Regiment Cloak.jpg', 'price' => 89.99,  'badge' => 'Limited Edition', 'status' => 'available',  'release_date' => '2024-03-15', 'is_featured' => true,  'popularity' => 95],
            ['category_id' => $anime->id,   'name' => 'Demon Slayer Nichirin Blade Replica',          'slug' => 'demon-slayer-nichirin-blade',  'description' => 'Hand-painted replica of Tanjiro\'s water-breathing Nichirin sword.', 'image' => 'images/Demon Slayer Nichirin Blade.jpg', 'price' => 149.99, 'badge' => 'Collectible',     'status' => 'available',  'release_date' => '2024-05-01', 'is_featured' => true,  'popularity' => 92],
            ['category_id' => $anime->id,   'name' => 'Jujutsu Kaisen Gojo Blindfold Set',           'slug' => 'jjk-gojo-blindfold-set',      'description' => 'Officially licensed Satoru Gojo blindfold and accessories set.',                      'price' => 34.99,  'badge' => null,              'status' => 'available',  'release_date' => '2024-02-10', 'is_featured' => false, 'popularity' => 85],
            ['category_id' => $anime->id,   'name' => 'One Piece Straw Hat Collection',              'slug' => 'one-piece-straw-hat',         'description' => 'Luffy\'s iconic straw hat — premium quality with authentic materials.', 'image' => 'images/One Piece Straw Hat Collection.jpg', 'price' => 59.99,  'badge' => 'Pre-Order',       'status' => 'pre-order',  'release_date' => '2025-01-20', 'is_featured' => true,  'popularity' => 90],
            ['category_id' => $gaming->id,  'name' => 'Elden Ring Tarnished Edition Art Book',       'slug' => 'elden-ring-art-book',         'description' => '300-page hardcover art book featuring exclusive FromSoftware concept art.', 'image' => 'images/Elden Ring Tarnished Edition Art Book.jpg', 'price' => 79.99,  'badge' => 'Limited Edition', 'status' => 'available',  'release_date' => '2024-01-10', 'is_featured' => true,  'popularity' => 94],
            ['category_id' => $gaming->id,  'name' => 'God of War Leviathan Axe Replica',            'slug' => 'gow-leviathan-axe',           'description' => '1:1 scale die-cast metal Leviathan Axe from God of War.',                             'price' => 299.99, 'badge' => 'Collectible',     'status' => 'available',  'release_date' => '2024-06-15', 'is_featured' => true,  'popularity' => 97],
            ['category_id' => $gaming->id,  'name' => 'Zelda Tears of the Kingdom Collector\'s Set', 'slug' => 'zelda-totk-collectors',       'description' => 'Collector\'s edition with steelbook, art prints, and exclusive figurine.',             'price' => 129.99, 'badge' => 'Collectible',     'status' => 'sold-out',   'release_date' => '2023-05-12', 'is_featured' => false, 'popularity' => 98],
            ['category_id' => $movies->id,  'name' => 'Dune Fremen Stillsuit Model',                 'slug' => 'dune-fremen-stillsuit',       'description' => 'Detailed 12-inch figure wearing the iconic Fremen stillsuit from Dune Part Two.',     'price' => 69.99,  'badge' => null,              'status' => 'available',  'release_date' => '2024-04-20', 'is_featured' => false, 'popularity' => 82],
            ['category_id' => $movies->id,  'name' => 'Spider-Verse Miles Morales Figure',           'slug' => 'spider-verse-miles-figure',   'description' => 'Premium 10-inch articulated figure of Miles Morales in his Spider-Verse suit.',       'price' => 54.99,  'badge' => null,              'status' => 'available',  'release_date' => '2024-03-01', 'is_featured' => true,  'popularity' => 91],
            ['category_id' => $kpop->id,    'name' => 'BTS PROOF Anthology Album',                   'slug' => 'bts-proof-anthology',         'description' => 'BTS PROOF – the anthology album celebrating a decade of Bangtan with exclusive photobooks.','price' => 49.99, 'badge' => null,             'status' => 'available',  'release_date' => '2022-06-10', 'is_featured' => true,  'popularity' => 99],
            ['category_id' => $kpop->id,    'name' => 'BLACKPINK Official Lightstick Ver.2',         'slug' => 'blackpink-lightstick-v2',     'description' => 'The official BLACKPINK Bong Bong lightstick, now in Version 2 with app connectivity.', 'price' => 39.99,  'badge' => null,              'status' => 'available',  'release_date' => '2023-08-05', 'is_featured' => false, 'popularity' => 95],
            ['category_id' => $kpop->id,    'name' => 'SEVENTEEN Power of Love Weverse Album',       'slug' => 'seventeen-power-of-love',     'description' => 'Limited digital Weverse album with exclusive digital photocard.',                      'price' => 19.99,  'badge' => 'Limited Edition', 'status' => 'available',  'release_date' => '2021-11-22', 'is_featured' => false, 'popularity' => 87],
            ['category_id' => $comics->id,  'name' => 'Marvel X-Men #1 Facsimile Reprint',           'slug' => 'xmen-1-facsimile',            'description' => 'High quality facsimile reprint of the first-ever X-Men comic from 1963.',              'price' => 9.99,   'badge' => 'Collectible',     'status' => 'available',  'release_date' => '2024-07-01', 'is_featured' => false, 'popularity' => 80],
            ['category_id' => $comics->id,  'name' => 'Batman The Long Halloween Deluxe Edition',    'slug' => 'batman-long-halloween-deluxe','description' => 'Deluxe hardcover edition of Jeph Loeb\'s noir masterpiece with bonus commentary.',     'price' => 49.99,  'badge' => null,              'status' => 'available',  'release_date' => '2023-09-01', 'is_featured' => true,  'popularity' => 93],
            ['category_id' => $cosplay->id, 'name' => 'Professional EVA Foam Crafting Kit',          'slug' => 'eva-foam-crafting-kit',       'description' => 'Everything you need to start crafting armor: sheets, contact cement, heat gun.',     'price' => 89.99,  'badge' => null,              'status' => 'available',  'release_date' => '2024-01-05', 'is_featured' => true,  'popularity' => 83],
            ['category_id' => $anime->id,   'name' => 'My Hero Academia All Might Figure',           'slug' => 'mha-all-might-figure',        'description' => 'Premium statue of All Might in his muscular hero form, 15-inch scale.',               'price' => 119.99, 'badge' => 'Pre-Order',       'status' => 'pre-order',  'release_date' => '2025-03-10', 'is_featured' => false, 'popularity' => 86],
        ];

        foreach ($items as $data) {
            Merchandise::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
