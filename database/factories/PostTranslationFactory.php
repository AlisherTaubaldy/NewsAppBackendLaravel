<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostTranslation>
 */
class PostTranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => $this->faker->numberBetween(1, 100), // Adjust range based on your data
            'lang_id' => 2, // Adjust range based on your languages
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(2),
            'imageUrl' => $this->faker->imageUrl(640, 480), // Adjust image dimensions if needed
            'link' => $this->faker->url,
            'seo_title' => $this->faker->sentence(4),
            'seo_description' => $this->faker->paragraph(1),
            'seo_keywords' => implode(',', $this->faker->words(5)), // Comma-separated keywords
        ];
    }
}
