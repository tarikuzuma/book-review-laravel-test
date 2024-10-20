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
}
