<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$counts = [
    'users'        => \App\Models\User::count(),
    'categories'   => \App\Models\Category::count(),
    'content'      => \App\Models\Content::count(),
    'characters'   => \App\Models\Character::count(),
    'articles'     => \App\Models\Article::count(),
    'media_items'  => \App\Models\MediaItem::count(),
    'merchandise'  => \App\Models\Merchandise::count(),
    'events'       => \App\Models\Event::count(),
    'chatbot_faqs' => \App\Models\ChatbotFaq::count(),
];

foreach ($counts as $k => $v) {
    echo "$k: $v\n";
}

$admin = \App\Models\User::where('role','admin')->first();
echo $admin ? "admin: {$admin->email}\n" : "no admin user found\n";
