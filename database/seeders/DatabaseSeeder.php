<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            ContentSeeder::class,
            CharacterSeeder::class,
            MediaItemSeeder::class,
            ArticleSeeder::class,
            MerchandiseSeeder::class,
            EventSeeder::class,
            ChatbotFaqSeeder::class,
        ]);
    }
}
