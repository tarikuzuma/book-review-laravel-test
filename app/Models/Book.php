<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // \App\Models\Book::title('et')->get();
    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', "%" . $title . "%");
    }

    // Query Bulder for filtering by popularity. Popular books are those with the most reviews.
    public function scopePopular(Builder $query): Builder
    {
        return $query->withCount('reviews')
            ->orderByDesc('reviews_count');
            //->limit(20);
    }
    
    // Query Builder for filtering by rating. Highest rated books are those with the highest average rating.
    public function scopeHighestRated(Builder $query): Builder
    {
        return $query->withAvg('reviews','rating')
            ->orderByDesc('reviews_avg_rating');
            //->limit(20);
    }
}
