<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Paper;
use App\Models\PaperQuestion;
use App\Models\Question;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaperQuestionExtensionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id, $paperQuestionId)
    {
        //list the extendable types
        $paper = Paper::findOrFail($id);
        $paperQuestion = PaperQuestion::findOrFail($paperQuestionId);
        // get distinct question types from selected chapters
        $questionTypeIds = DB::table('questions')
            ->select('type_id')
            ->distinct()
            ->whereIn('chapter_id', $paper->topicIdsArray())
            ->whereNotIn('type_id', [1, 2, 23, 24]) //other than mcq, short
            ->pluck('type_id');

        $questionTypes = Type::whereIn('id', $questionTypeIds)->get();
        return view('user.paper-questions.extension.index', compact('paper', 'paperQuestion', 'questionTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id, $typeId)
    {
        //
        $paperQuestion = PaperQuestion::findOrFail($id);
        $type = Type::findOrFail($typeId);
        $paper = $paperQuestion->paper;

        // $typeId = 0;
        // if ($paperQuestion->type_name == 'mcq' || $paperQuestion->type_name == 'partial' || $paperQuestion->type_name == 'partial-x') {
        //     $typeId = $paperQuestion->paperQuestionParts->first()->question->type_id;
        // }

        //send paper chapter only which have long data type
        $chaptersIdsArray = $paper->topicIdsArray();

        $chapterIdsConcerned = DB::table('questions')
            ->select('chapter_id')
            ->distinct()
            ->whereIn('chapter_id', $paper->topicIdsArray())
            ->where('type_id', $type->id) //concerned type only
            ->pluck('chapter_id');

        // $questionTypeIds = DB::table('questions')
        //     ->select('type_id')
        //     ->distinct()
        //     ->whereIn('chapter_id', $paper->topicIdsArray())
        //     ->whereNotIn('type_id', [1, 2, 23, 24]) //other than mcq, short
        //     ->pluck('type_id');

        // $questionTypes = Type::whereIn('id', $questionTypeIds)->get();

        // $chapterIdsHavingLong = DB::table('questions')
        //     ->select('chapter_id')
        //     ->distinct()
        //     ->whereIn('chapter_id', $paper->topicIdsArray())
        //     ->whereNotIn('type_id', [1, 2, 23, 24]) //other than mcq, short
        //     ->pluck('chapter_id');


        $chapters = Chapter::whereIn('id', $chapterIdsConcerned)->get();
        return view('user.paper-questions.extension.create', compact('paperQuestion', 'paper', 'chapters', 'typeId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id, $typeId)
    {
        //
        $request->validate([
            'type_name' => 'required',
            'frequency' => 'required|numeric',
            'chapter_id' => 'required',
        ]);

        try {
            $paperQuestion = PaperQuestion::findOrFail($id);
            $type = Type::findOrFail($typeId);
            //randomly select question parts from each chapter and save them

            $threshold = $request->frequency;

            $question = Question::where('type_id', $type->id)
                ->where('chapter_id', $request->chapter_id)
                ->where('frequency', '>=', $threshold)
                ->get()
                ->random(1)
                ->first();

            $paperQuestion->paperQuestionParts()->create([
                'paper_question_id' => $paperQuestion->id,
                'question_id' => $question->id,
                'marks' => $request->marks,
            ]);

            $previousMakrs = $paperQuestion->marks;
            // if ($paperQuestion->type_name == 'simple-and') {
            $paperQuestion->update([
                'type_name' => $request->type_name,
                'marks' => $request->type_name == 'simple-and' ? $previousMakrs + $request->marks : $previousMakrs,
            ]);
            // }
            // echo $question->id;
            return redirect()->route('user.papers.show', $paperQuestion->paper)->with('success', 'Question successfully added!');
        } catch (Exception $e) {

            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
