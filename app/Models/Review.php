<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['review', 'rating']; // Lets you specify which attributes are mass-assignable
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    protected static function booted()
    {
        static::updated(fn(Review $review) => cache()->forget('book:' . $review->book_id));
        static::deleted(fn(Review $review) => cache()->forget('book:' . $review->book_id));

        // Reset the cache when a new review is created
        static::created(fn(Review $review) => cache()->forget('book:' . $review->book_id));
    }
}
