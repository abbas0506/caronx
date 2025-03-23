<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Grade;
use App\Models\Question;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;

class SelfTestController extends Controller
{
    //
    public function index()
    {
        //
        $grades = Grade::all();
        $subjects = Subject::all();
        return view('self-tests.index', compact('grades', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'course_id' => 'required|numeric',
            'mcqs_count' => 'required|numeric',
            'topic_ids_array' => 'required',
        ]);


        try {
            // $test = Test::create($request->all());
            $topicIdsArray = array();
            $topicIdsArray = $request->topic_ids_array;
            session([
                'topicIdsArray' => $topicIdsArray,
                'mcqs_count' => $request->mcqs_count,

            ]);
            return redirect()->route('self-tests.show', $request->course_id);
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
        $book = Book::findOrFail($id);

        $topicIdsArray = session('topicIdsArray');

        $mcqs_count = session('mcqs_count');

        try {
            $questions = Question::whereIn('chapter_id', $topicIdsArray)
                ->where('type_id', 1)
                ->get()
                ->random($mcqs_count);
            $chapterNos = Chapter::whereIn('id', $topicIdsArray)->pluck('sr');
            return view('self-tests.show', compact('book', 'chapterNos', 'questions'));
        } catch (Exception $ex) {

            return redirect()->back()->withErrors($ex->getMessage());
        }


        // echo $questions;

        // $chapters = Chapter::whereIn('id', $topicIdsArray)->get();
        // $questions = collect();
        // foreach ($topicIdsArray as $chapterNo) {
        //     $questionsFromThisChapter = Question::where('question_type', 'mcq')
        //         ->where('sr', $chapterNo)
        //         ->get()
        //         ->random(
        //             round(20 / sizeOf($topicIdsArray), 0)
        //         );

        //     foreach ($questionsFromThisChapter as $question)
        //         $questions->add($question);
        // }
        // echo $questions;

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $book = Book::findOrFail($id);
        // $chapters = Chapter::where('subject_id', $id)
        //     ->whereHas('questions')
        //     ->get();
        return view('self-tests.edit', compact('book'));
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
