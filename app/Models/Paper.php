<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use function PHPUnit\Framework\isEmpty;

class Paper extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'title',
        'institution',
        'paper_date',
        'is_printed',
        'topic_ids', //comma separted list of source chapters
    ];

    protected $casts = [
        'paper_date' => 'date',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function paperQuestions()
    {
        return $this->hasMany(PaperQuestion::class);
    }
    public function paperQuestionParts()
    {
        return $this->hasManyThrough(PaperQuestionPart::class, PaperQuestion::class);
    }

    public function topicIdsArray()
    {
        return explode(',', $this->topic_ids);
    }

    public function suggestedTime()
    {
        $sumOfMarks = $this->paperQuestions->sum('marks');
        $m = round($sumOfMarks * 2, 0);   //2 time the total marks
        $hr = intdiv($m, 60);

        if ($hr > 0)
            return $hr . "h " . $m % 60 . "m";
        else
            return $m . "m";
    }
}
