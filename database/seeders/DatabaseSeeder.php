<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Book;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First batch of 33 books with good reviews (rating between 4 and 5)
        Book::factory(33)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);
            Review::factory($numReviews)
                ->state(function () {
                    return [
                        'rating' => random_int(4, 5), // Good reviews with ratings between 4 and 5
                    ];
                })
                ->for($book)
                ->create();
        });

        // Second batch of 33 books with average reviews (keeping average at rating 3)
        Book::factory(33)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);
            Review::factory($numReviews)
                ->state(function () {
                    return [
                        'rating' => 3, // Average reviews with rating 3
                    ];
                })
                ->for($book)
                ->create();
        });

        // Third batch of 34 books with bad reviews (rating between 1 and 2)
        Book::factory(34)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);
            Review::factory($numReviews)
                ->state(function () {
                    return [
                        'rating' => random_int(1, 2), // Bad reviews with ratings between 1 and 2
                    ];
                })
                ->for($book)
                ->create();
        });
    }
}
