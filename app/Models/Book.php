<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'course_id',
        'sr',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
    // public function questions()
    // {
    //     return $this->hasManyThrough(Question::class, Chapter::class);
    // }

    public function questionTypes()
    {

        $questionTypeIdsArray = $this->questions->pluck('type_id')->unique();
        $types = Type::whereIn('id', $questionTypeIdsArray)->get();
        return $types;
    }
}
