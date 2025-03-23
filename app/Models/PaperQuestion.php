<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_id',
        'question_title',
        'type_id',       //question type: mcq, partial, simple etc
        'sr',
        'difficulty_level',        //question frequency
        'marks',
        'compulsory_parts', //number of compulsory parts in partial question
        'number_style',

    ];

    public function  paper()
    {
        return $this->belongsTo(Paper::class);
    }

    public function  paperQuestionParts()
    {
        return $this->hasMany(PaperQuestionPart::class);
    }

    public function compulsoryParts()
    {
        if ($this->display_style == 'mcq' || $this->question_type == 'partial' || $this->question_type == 'partial-x') //mcqs , partial (horizontal or vertical)
            return $this->paperQuestionParts->count() - $this->choices;
        else return 0;
    }
    public function scopeMcqs($query)
    {
        return $query->where('type_name', 'mcq');
    }
}
