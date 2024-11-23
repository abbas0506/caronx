<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PoetryLineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($chapterId)
    {
        //
        $types = Type::whereIn('id', [11, 25])->get();
        $chapter = Chapter::findOrFail($chapterId);
        return view('operator.poetry-lines.create', compact('chapter', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $chapterId)
    {
        //
        $request->validate([
            'type_id' => 'required|numeric',
            'line_a' => 'required',
            'line_b' => 'required',
        ]);

        $chapter = Chapter::findOrFail($chapterId);
        DB::beginTransaction();

        try {
            $sr = $chapter->questions->where('type_id', $request->type_id)->count() + 1;
            $question = $chapter->questions()->create([
                'user_id' => Auth::user()->id,
                'type_id' => $request->type_id,
                'statement' => ($chapter->course->subject->name_en == 'English' ? 'verse' : 'شعر') . " " . $sr,
            ]);
            $question = $question->poetryLines()->create([
                'line_a' => $request->line_a,
                'line_b' => $request->line_b,
                'sr' => $sr,
            ]);

            // commit if all ok
            DB::commit();

            return redirect()->route('operator.chapter.poetry-lines.create', [$chapter])->with(
                [
                    'type_id' => $request->type_id,
                    'success' => 'Successfully added',
                ]
            );
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
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
