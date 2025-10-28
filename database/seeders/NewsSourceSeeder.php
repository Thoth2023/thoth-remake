<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewsSource;

class NewsSourceSeeder extends Seeder
{
    public function run(): void
    {
        $sources = [
            [
                'name' => 'SBC',
                'url' => 'https://www.sbc.org.br/feed/',
                'more_link' => 'https://www.sbc.org.br/noticias',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IEEE',
                'url' => 'https://open.ieee.org/feed/',
                'more_link' => 'https://open.ieee.org/whats-new/',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($sources as $source) {
            NewsSource::updateOrCreate(
                ['name' => $source['name']],
                [
                    'url' => $source['url'],
                    'more_link' => $source['more_link'],
                ]
            );
        }
    }
}
