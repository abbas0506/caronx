<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'title', //title
        'sr',

    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function  topics()
    {
        return $this->hasMany(Topic::class);
    }
    public function questions()
    {
        return $this->hasManyThrough(Question::class, Topic::class);
    }
}
