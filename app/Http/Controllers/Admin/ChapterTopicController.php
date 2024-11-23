<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Topic;
use Exception;
use Illuminate\Http\Request;

class ChapterTopicController extends Controller
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
    public function create($id)
    {
        //
        $chapter = Chapter::findOrFail($id);
        return view('admin.topics.create', compact('chapter'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'sr' => 'required|numeric',
        ]);

        $chapter = Chapter::findOrFail($id);
        try {

            $chapter->topics()->create($request->all());
            return redirect()->route('admin.book.chapters.index', $chapter->book)->with('success', 'Successfully added');;
        } catch (Exception $ex) {
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
    public function edit($chapterId, $id)
    {
        //
        $chapter = Chapter::findOrFail($chapterId);
        $topic = Topic::findOrFail($id);
        return view('admin.topics.edit', compact('chapter', 'topic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $chapterId, $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'sr' => 'required|numeric',
        ]);

        $chapter = Chapter::findOrFail($chapterId);

        try {
            $chapter->topics()->findOrFail($id)->update($request->all());
            return redirect()->route('admin.book.chapters.index', $chapter->book_id)->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($chapterId, string $id,)
    {
        //
        $model = Topic::findOrFail($id);
        try {
            $model->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
