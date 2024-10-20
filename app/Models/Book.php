<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Define a one-to-many relationship between Book and Review.
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Scope a query to search books by title.
     * Usage: \App\Models\Book::title('example')->get();
     *
     * @param Builder $query
     * @param string $title
     * @return Builder
     */
    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', "%" . $title . "%");
    }

    /**
     * Scope a query to filter popular books based on the number of reviews.
     * Optionally filter by a date range using 'created_at' on reviews.
     *
     * @param Builder $query
     * @param mixed|null $from Start date for filtering (optional)
     * @param mixed|null $to End date for filtering (optional)
     * @return Builder
     */
    public function scopePopular(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withCount(['reviews' => function (Builder $query) use ($from, $to) {
            $this->dateRangeFilter($query, $from, $to);
        }])
        ->orderByDesc('reviews_count');
    }

    /**
     * Scope a query to filter books by the highest average rating.
     * Optionally filter by a date range using 'created_at' on reviews.
     *
     * @param Builder $query
     * @param mixed|null $from Start date for filtering (optional)
     * @param mixed|null $to End date for filtering (optional)
     * @return Builder
     */
    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withAvg(['reviews' => function (Builder $query) use ($from, $to) {
            $this->dateRangeFilter($query, $from, $to);
        }], 'rating')
        ->orderByDesc('reviews_avg_rating');
    }

    /**
     * Scope a query to filter books by a minimum number of reviews.
     * This can be used to exclude books with very few reviews.
     *
     * @param Builder $query
     * @param int $minReviews Minimum number of reviews required
     * @return Builder
     */
    public function scopeMinReviews(Builder $query, int $minReviews): Builder
    {
        return $query->having('reviews_count', '>=', $minReviews);
    }

    /**
     * Filter a query by a date range based on 'created_at'.
     *
     * @param Builder $query
     * @param mixed|null $from Start date for filtering (optional)
     * @param mixed|null $to End date for filtering (optional)
     * @return void
     */
    private function dateRangeFilter(Builder $query, $from = null, $to = null)
    {
        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    }
}
