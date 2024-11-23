<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'sr',
    ];

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
    public function topics()
    {
        return $this->hasManyThrough(Topic::class, Chapter::class);
    }
    public function questions()
    {
        return Question::whereRelation('topic.chapter.course', 'id', '=', $this->id)->get();
    }
    // for paper generation
    public function questionTypes()
    {

        $questionTypeIdsArray = $this->questions->pluck('type_id')->unique();
        $types = Type::whereIn('id', $questionTypeIdsArray)->get();
        return $types;
    }
}
