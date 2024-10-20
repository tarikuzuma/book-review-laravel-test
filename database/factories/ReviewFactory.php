<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class; // Ensure this is set to your model

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => null, // This will be automatically handled by ->for(Book::class) in the seeder
            'review' => $this->faker->paragraph(2), // Use $this->faker for consistency
            'rating' => $this->faker->numberBetween(1, 5), // Default rating between 1 and 5
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => function (array $attributes) {
                return $attributes['created_at']; // Use the same value as created_at
            },
        ];
    }

    /**
     * Define the "good" state.
     */
    public function good()
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => $this->faker->numberBetween(4, 5),
            ];
        });
    }

    /**
     * Define the "bad" state.
     */
    public function bad()
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => $this->faker->numberBetween(1, 3),
            ];
        });
    }
}
