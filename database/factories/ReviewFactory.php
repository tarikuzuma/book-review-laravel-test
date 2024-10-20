<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => null, 
            'review' => fake() -> paragraph(2),
            'rating' => fake() -> numberBetween(1, 5),
            'created_at' => fake() -> dateTimeBetween('-2 years', 'now'),
            'updated_at' => function (array $attributes) {
                return $attributes['created_at']; // same as created_at
            }, 
        ];
    }

    // Define a state named "good"
    public function good()
    {
        return function (array $attributes) {
            return [
                'rating' => fake() -> numberBetween(4, 5),
            ];
        };
    }

    // Define a state named "bad"
    public function bad()
    {
        return function (array $attributes) {
            return [
                'rating' => fake() -> numberBetween(1, 3),
            ];
        };
    }


    
}

