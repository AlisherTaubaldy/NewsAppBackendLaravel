<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Post;
use App\Models\PostTranslation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Language::factory()->create([
            'code' => 'kz',
            'name' => 'Kazakh',
        ]);
        Language::factory()->create([
            'code' => 'ru',
            'name' => 'Russian',
        ]);
        Language::factory()->create([
            'code' => 'en',
            'name' => 'English'
        ]);
//
//        Post::factory(20)->create();
//
//        PostTranslation::factory(60)->create();
    }
}
