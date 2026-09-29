<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $anime   = Category::where('slug', 'anime')->first();
        $gaming  = Category::where('slug', 'gaming')->first();
        $movies  = Category::where('slug', 'movies')->first();
        $kpop    = Category::where('slug', 'k-pop')->first();
        $cosplay = Category::where('slug', 'cosplay')->first();
        $comics  = Category::where('slug', 'comics')->first();

        $events = [
            ['category_id' => $anime->id,   'title' => 'Anime Expo 2026',                   'event_type' => 'convention',  'start_date' => '2026-07-02 09:00:00', 'end_date' => '2026-07-05 22:00:00', 'venue' => 'Los Angeles Convention Center', 'city' => 'Los Angeles',   'country' => 'USA',     'latitude' => 34.0430,  'longitude' => -118.2673, 'ticket_link' => 'https://www.anime-expo.org', 'is_featured' => true,  'description' => 'The largest anime convention in North America with over 100,000 attendees.'],
            ['category_id' => $gaming->id,  'title' => 'PAX West 2026',                     'event_type' => 'convention',  'start_date' => '2026-08-28 10:00:00', 'end_date' => '2026-08-31 18:00:00', 'venue' => 'Washington State Convention Center', 'city' => 'Seattle',     'country' => 'USA',     'latitude' => 47.6109,  'longitude' => -122.3317, 'ticket_link' => 'https://west.paxsite.com',   'is_featured' => true,  'description' => 'One of the world\'s premier gaming festivals celebrating all aspects of gaming culture.'],
            ['category_id' => $comics->id,  'title' => 'San Diego Comic-Con 2026',          'event_type' => 'convention',  'start_date' => '2026-07-23 09:00:00', 'end_date' => '2026-07-26 19:00:00', 'venue' => 'San Diego Convention Center',   'city' => 'San Diego',     'country' => 'USA',     'latitude' => 32.7066,  'longitude' => -117.1628, 'ticket_link' => 'https://comic-con.org',      'is_featured' => true,  'description' => 'The most iconic pop culture convention on the planet.'],
            ['category_id' => $kpop->id,    'title' => 'KCON 2026 LA',                      'event_type' => 'convention',  'start_date' => '2026-08-01 12:00:00', 'end_date' => '2026-08-03 23:00:00', 'venue' => 'BMO Stadium',                   'city' => 'Los Angeles',   'country' => 'USA',     'latitude' => 34.0120,  'longitude' => -118.2850, 'ticket_link' => 'https://www.kconusa.com',    'is_featured' => true,  'description' => 'The world\'s largest K-Pop convention with fan meets, stages, and panels.'],
            ['category_id' => $cosplay->id, 'title' => 'Cosplay Championships UK 2026',     'event_type' => 'convention',  'start_date' => '2026-10-15 10:00:00', 'end_date' => '2026-10-16 18:00:00', 'venue' => 'NEC Birmingham',                'city' => 'Birmingham',    'country' => 'UK',      'latitude' => 52.4508,  'longitude' => -1.7240,   'ticket_link' => 'https://www.mcmcomiccon.com','is_featured' => false, 'description' => 'The UK\'s biggest cosplay competition and pop culture event.'],
            ['category_id' => $anime->id,   'title' => 'MCM London Comic Con Spring 2026',  'event_type' => 'convention',  'start_date' => '2026-05-22 09:00:00', 'end_date' => '2026-05-24 18:00:00', 'venue' => 'ExCeL London',                  'city' => 'London',        'country' => 'UK',      'latitude' => 51.5074,  'longitude' => 0.0347,    'ticket_link' => 'https://www.mcmcomiccon.com','is_featured' => false, 'description' => 'London\'s biggest pop culture event covering anime, gaming, and comics.'],
            ['category_id' => $gaming->id,  'title' => 'EGX 2026 London',                   'event_type' => 'convention',  'start_date' => '2026-09-24 10:00:00', 'end_date' => '2026-09-27 18:00:00', 'venue' => 'ExCeL London',                  'city' => 'London',        'country' => 'UK',      'latitude' => 51.5074,  'longitude' => 0.0347,    'ticket_link' => 'https://www.egx.net',        'is_featured' => false, 'description' => 'The UK\'s biggest gaming event, with hands-on previews and esports.'],
            ['category_id' => $movies->id,  'title' => 'Avengers: Secret Wars – World Premiere','event_type' => 'premiere', 'start_date' => '2026-05-01 19:00:00', 'end_date' => '2026-05-01 23:00:00', 'venue' => 'Dolby Theatre',                'city' => 'Los Angeles',   'country' => 'USA',     'latitude' => 34.1017,  'longitude' => -118.3394, 'ticket_link' => null,                         'is_featured' => true,  'description' => 'Red carpet world premiere of the MCU\'s most anticipated event film.'],
            ['category_id' => $anime->id,   'title' => 'AnimeJapan 2026',                   'event_type' => 'convention',  'start_date' => '2026-03-21 10:00:00', 'end_date' => '2026-03-24 18:00:00', 'venue' => 'Tokyo Big Sight',               'city' => 'Tokyo',         'country' => 'Japan',   'latitude' => 35.6298,  'longitude' => 139.7940,  'ticket_link' => 'https://www.anime-japan.jp', 'is_featured' => false, 'description' => 'Japan\'s premier anime event with over 200 exhibitors and live stages.'],
            ['category_id' => $cosplay->id, 'title' => 'Cosplay Meetup – Sydney Anime Fest','event_type' => 'meetup',      'start_date' => '2026-11-07 11:00:00', 'end_date' => '2026-11-07 18:00:00', 'venue' => 'Sydney Showground',             'city' => 'Sydney',        'country' => 'Australia','latitude' => -33.8471, 'longitude' => 151.0696, 'ticket_link' => 'https://www.supanova.com.au','is_featured' => false, 'description' => 'Australia\'s biggest anime and cosplay community gathering.'],
            ['category_id' => $kpop->id,    'title' => 'SEVENTEEN World Tour – Singapore',  'event_type' => 'convention',  'start_date' => '2026-10-03 19:30:00', 'end_date' => '2026-10-03 22:30:00', 'venue' => 'Singapore Indoor Stadium',      'city' => 'Singapore',     'country' => 'Singapore','latitude' => 1.3003,   'longitude' => 103.8752,  'ticket_link' => 'https://www.ticketmaster.sg','is_featured' => true,  'description' => 'SEVENTEEN\'s world tour stop in Singapore – a night of hits and fan service.'],
        ];

        foreach ($events as $data) {
            Event::firstOrCreate(
                ['title' => $data['title'], 'start_date' => $data['start_date']],
                $data
            );
        }
    }
}
