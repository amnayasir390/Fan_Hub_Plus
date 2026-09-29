<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@fanhubplus.com'],
            [
                'name'                   => 'Admin',
                'password'               => Hash::make('password'),
                'role'                   => 'admin',
                'email_verified_at'      => now(),
                'favorite_fandoms'       => ['Anime', 'Gaming', 'Comics'],
                'categories_of_interest' => ['anime', 'gaming', 'comics'],
                'display_preference'     => 'grid',
                'font_size'              => 'medium',
                'dark_mode'              => true,
                'bio'                    => 'Platform administrator and fandom enthusiast.',
            ]
        );

        User::firstOrCreate(
            ['email' => 'fan@fanhubplus.com'],
            [
                'name'                   => 'Alex Fan',
                'password'               => Hash::make('password'),
                'role'                   => 'user',
                'email_verified_at'      => now(),
                'favorite_fandoms'       => ['K-Pop', 'Anime', 'Cosplay'],
                'categories_of_interest' => ['k-pop', 'anime', 'cosplay'],
                'display_preference'     => 'grid',
                'font_size'              => 'medium',
                'dark_mode'              => true,
                'bio'                    => 'Avid anime watcher and K-Pop stan.',
            ]
        );

        User::firstOrCreate(
            ['email' => 'gamer@fanhubplus.com'],
            [
                'name'                   => 'Riley Gamer',
                'password'               => Hash::make('password'),
                'role'                   => 'user',
                'email_verified_at'      => now(),
                'favorite_fandoms'       => ['Gaming', 'Comics', 'Movies'],
                'categories_of_interest' => ['gaming', 'comics', 'movies'],
                'display_preference'     => 'list',
                'font_size'              => 'medium',
                'dark_mode'              => true,
                'bio'                    => 'Hardcore gamer and Marvel fan.',
            ]
        );
    }
}
