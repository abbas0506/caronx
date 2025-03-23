<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Paper;
use App\Models\PaperQuestionPart;
use App\Models\Question;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;

class SimpleQuestionController extends Controller
{

    public function create($paperId, $typeId)
    {

        $paper = Paper::findOrFail($paperId);
        if ($paper->topicIdsArray()) {
            //send only type-relevant chapters  
            $chapterIds = Question::where('type_id', $typeId)->whereIn('chapter_id', $paper->topicIdsArray())->pluck('chapter_id')->unique();
            $chapters = Chapter::whereIn('id', $chapterIds)->get();

            $type = Type::findOrFail($typeId);

            return view('user.paper-questions.simple.create', compact('paper', 'chapters', 'type'));
        } else {
            echo "Chapters not selected!";
        }
    }

    public function store(Request $request, $paperId, $typeId)
    {
        //
        $request->validate([
            'question_title' => 'nullable',
            'type_name' => 'required',
            'frequency' => 'required|numeric',
            'chapter_id' => 'required',
        ]);

        try {
            //create test question instance
            $paper = Paper::findOrFail($paperId);
            $question_title = '';
            $paperQuestion = $paper->paperQuestions()->create([
                'question_title' => $request->question_title,
                'type_name' => $request->type_name,
                'frequency' => $request->frequency,
                'marks' => $request->marks,
                'compulsory_parts' => 0,
            ]);
            //randomly select question parts from each chapter and save them
            $i = 0; //for iterating numOfparts
            $threshold = $request->frequency;


            $question = Question::where('type_id', $typeId)
                ->where('chapter_id', $request->chapter_id)
                ->where('frequency', '>=', $threshold)
                ->get()
                ->random(1)
                ->first();


            PaperQuestionPart::create([
                'paper_question_id' => $paperQuestion->id,
                'question_id' => $question->id,
                'marks' => $request->marks,
            ]);

            // echo $question->id;
            return redirect()->route('user.papers.show', $paper)->with('success', 'Question successfully added!');
        } catch (Exception $e) {

            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
