<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Character;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    public function run(): void
    {
        $anime   = Category::where('slug', 'anime')->first();
        $gaming  = Category::where('slug', 'gaming')->first();
        $movies  = Category::where('slug', 'movies')->first();
        $comics  = Category::where('slug', 'comics')->first();
        $manga   = Category::where('slug', 'manga')->first();

        $characters = [
            // Anime Characters
            ['category_id' => $anime->id,  'name' => 'Eren Yeager',       'slug' => 'eren-yeager',       'series' => 'Attack on Titan',      'bio' => 'A young soldier who swears to exterminate all Titans, only to become the world\'s greatest threat.', 'image' => 'images/eren-yeager.jpg',              'genre' => 'Action',       'abilities' => ['Titan Shifting','Founding Titan','Attack Titan'], 'popularity' => 98, 'is_featured' => true],
            ['category_id' => $anime->id,  'name' => 'Tanjiro Kamado',    'slug' => 'tanjiro-kamado',    'series' => 'Demon Slayer',          'bio' => 'A kind-hearted demon slayer who seeks to cure his sister Nezuko and avenge his family.',                          'genre' => 'Action',       'abilities' => ['Water Breathing','Hinokami Kagura','Enhanced Smell'], 'popularity' => 96, 'is_featured' => true],
            ['category_id' => $anime->id,  'name' => 'Izuku Midoriya',    'slug' => 'izuku-midoriya',    'series' => 'My Hero Academia',      'bio' => 'Born Quirkless, Izuku inherits the most powerful ability in the world from the greatest hero.',                   'genre' => 'Superhero',    'abilities' => ['One For All','Black Whip','Float'], 'popularity' => 91, 'is_featured' => false],
            ['category_id' => $anime->id,  'name' => 'Satoru Gojo',       'slug' => 'satoru-gojo',       'series' => 'Jujutsu Kaisen',        'bio' => 'The strongest jujutsu sorcerer alive, possessing the rare and limitless Infinity technique.', 'image' => 'images/satoro gojo.jpg',                    'genre' => 'Supernatural', 'abilities' => ['Infinity','Unlimited Void','Hollow Purple'], 'popularity' => 99, 'is_featured' => true],
            ['category_id' => $anime->id,  'name' => 'Monkey D. Luffy',   'slug' => 'monkey-d-luffy',    'series' => 'One Piece',             'bio' => 'A rubber-bodied pirate captain whose dream is to become the King of the Pirates.', 'image' => 'images/One Piece Straw Hat Collection.jpg', 'genre' => 'Adventure',    'abilities' => ['Gear 5','Gomu Gomu no Mi','Haki'], 'popularity' => 97, 'is_featured' => true],
            ['category_id' => $anime->id,  'name' => 'Levi Ackermann',    'slug' => 'levi-ackermann',    'series' => 'Attack on Titan',       'bio' => 'Humanity\'s strongest soldier, feared for his unparalleled combat speed and precision.',                          'genre' => 'Action',       'abilities' => ['ODM Mastery','Ackermann Power','Tactical Genius'], 'popularity' => 97, 'is_featured' => false],
            ['category_id' => $anime->id,  'name' => 'Nezuko Kamado',     'slug' => 'nezuko-kamado',     'series' => 'Demon Slayer',          'bio' => 'Tanjiro\'s demon-transformed sister who fights her bloodlust to protect humans.',                                 'genre' => 'Action',       'abilities' => ['Blood Demon Art','Demon Regeneration','Demon Shrinking'], 'popularity' => 94, 'is_featured' => false],
            ['category_id' => $anime->id,  'name' => 'Naruto Uzumaki',    'slug' => 'naruto-uzumaki',    'series' => 'Naruto',                'bio' => 'A hyperactive ninja who dreams of becoming Hokage and never gives up on his friends.', 'image' => 'images/naruto.jpg',                         'genre' => 'Action',       'abilities' => ['Rasengan','Nine Tails Chakra','Shadow Clone Jutsu'], 'popularity' => 98, 'is_featured' => true],
            // Gaming Characters
            ['category_id' => $gaming->id, 'name' => 'Kratos',            'slug' => 'kratos',            'series' => 'God of War',            'bio' => 'The Ghost of Sparta — a former Greek God of War turned Norse warrior and reluctant father.', 'image' => 'images/Kratos.jpg',                         'genre' => 'Action',       'abilities' => ['Leviathan Axe','Blades of Chaos','Spartan Rage'], 'popularity' => 97, 'is_featured' => true],
            ['category_id' => $gaming->id, 'name' => 'Link',              'slug' => 'link',              'series' => 'The Legend of Zelda',   'bio' => 'The courageous hero destined to wield the Triforce of Courage and defend Hyrule.',                               'genre' => 'Adventure',    'abilities' => ['Master Sword','Ultrahand','Ascend'], 'popularity' => 96, 'is_featured' => true],
            ['category_id' => $gaming->id, 'name' => 'Geralt of Rivia',   'slug' => 'geralt-of-rivia',   'series' => 'The Witcher',           'bio' => 'A mutated monster hunter navigating a morally grey world with silver and steel.',                                 'genre' => 'RPG',          'abilities' => ['Witcher Signs','Silver Sword','Alchemy'], 'popularity' => 94, 'is_featured' => false],
            ['category_id' => $gaming->id, 'name' => 'Master Chief',      'slug' => 'master-chief',      'series' => 'Halo',                  'bio' => 'Spartan-117, the supersoldier who saved humanity from the Covenant and the Flood.',                              'genre' => 'Sci-Fi',       'abilities' => ['MJOLNIR Armor','Combat Training','Energy Shield'], 'popularity' => 93, 'is_featured' => false],
            ['category_id' => $gaming->id, 'name' => 'V (Cyberpunk)',     'slug' => 'v-cyberpunk',       'series' => 'Cyberpunk 2077',         'bio' => 'A mercenary in Night City trying to survive with a relic of a dead rock legend in their head.',                  'genre' => 'RPG',          'abilities' => ['Cybernetic Implants','Hacking','Combat'], 'popularity' => 87, 'is_featured' => false],
            // Movies/Comics
            ['category_id' => $movies->id, 'name' => 'Tony Stark',        'slug' => 'tony-stark',        'series' => 'Marvel Cinematic Universe','bio' => 'Genius, billionaire, philanthropist. Iron Man saved the universe with a snap.',                             'genre' => 'Superhero',    'abilities' => ['Iron Man Armor','Genius Intellect','Arc Reactor'], 'popularity' => 98, 'is_featured' => true],
            ['category_id' => $comics->id, 'name' => 'Spider-Man',        'slug' => 'spider-man',        'series' => 'Marvel Comics',         'bio' => 'Your friendly neighbourhood Spider-Man. With great power comes great responsibility.',                           'genre' => 'Superhero',    'abilities' => ['Web-Slinging','Spider-Sense','Wall-Crawling'], 'popularity' => 99, 'is_featured' => true],
            ['category_id' => $comics->id, 'name' => 'Batman',            'slug' => 'batman',            'series' => 'DC Comics',             'bio' => 'The Dark Knight of Gotham City — the world\'s greatest detective and ultimate vigilante.',                       'genre' => 'Noir',         'abilities' => ['Peak Human Physique','Detective Skills','Gadgets'], 'popularity' => 99, 'is_featured' => true],
            // Manga
            ['category_id' => $manga->id,  'name' => 'Guts',              'slug' => 'guts',              'series' => 'Berserk',               'bio' => 'The Black Swordsman — branded for sacrifice, Guts fights fate itself wielding the massive Dragon Slayer sword.', 'image' => null, 'genre' => 'Dark Fantasy', 'abilities' => ['Dragon Slayer','Berserker Armor','Inhuman Endurance'], 'popularity' => 99, 'is_featured' => true],
            ['category_id' => $manga->id,  'name' => 'Denji',             'slug' => 'denji',             'series' => 'Chainsaw Man',          'bio' => 'A devil hunter fused with the Chainsaw Devil, fighting for simple human pleasures.',                             'genre' => 'Dark Fantasy', 'abilities' => ['Chainsaw Transformation','Regeneration','Devil Powers'], 'popularity' => 92, 'is_featured' => false],
            ['category_id' => $manga->id,  'name' => 'Edward Elric',      'slug' => 'edward-elric',      'series' => 'Fullmetal Alchemist',   'bio' => 'The Fullmetal Alchemist who seeks the Philosopher\'s Stone to restore himself and his brother.',                  'genre' => 'Fantasy',      'abilities' => ['Alchemy','Automail Arm','Combat'], 'popularity' => 96, 'is_featured' => true],
        ];

        foreach ($characters as $data) {
            Character::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
