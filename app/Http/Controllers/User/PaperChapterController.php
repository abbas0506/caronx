<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;

class PaperChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $paper = Paper::findOrFail($id);
        $course = $paper->course;
        return view('user.paper-chapters.index', compact('paper', 'course'));
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
    public function store(Request $request, $id)
    {
        //
        $request->validate([
            'chapter_ids_array' => 'required',
        ]);

        try {
            $paper = Paper::findOrFail($id);
            $chapterIdsArray = array();
            $chapterIdsArray = $request->chapter_ids_array;
            $commaSeparatedChapterIds = implode(',', $chapterIdsArray);

            $paper->update([
                'chapter_ids' => $commaSeparatedChapterIds,
            ]);

            session([
                'chapterIdsArray' => $chapterIdsArray,
            ]);

            return redirect()->route('user.papers.show', $paper);
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
        echo "show paper chapters";
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
