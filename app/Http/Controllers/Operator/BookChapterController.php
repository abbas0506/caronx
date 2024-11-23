<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Grade;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;

class BookChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($bookId)
    {
        //
        $grades = Grade::all();
        $book = Book::findOrFail($bookId);
        $tagIds = $book->chapters->pluck('tag_id')->unique();
        $tags = Tag::whereIn('id', $tagIds)->get();

        return view('operator.chapters.index', compact('grades', 'book', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($bookId)
    {
        //
        $book = Book::findOrFail($bookId);
        $tags = Tag::all();
        return view('operator.chapters.create', compact('book', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $bookId)
    {
        //
        $request->validate([
            'title' => 'required',
            'sr' => 'required|numeric',
            'tag_id' => 'required|numeric',
        ]);

        $book = Book::findOrFail($bookId);
        try {
            // 
            $book->chapters()->create($request->all());
            return redirect()->route('operator.books.chapters.index', $book)->with('success', 'Successfully added');;
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
    public function edit($bookId, string $id)
    {
        //
        $book = Book::findOrFail($bookId);
        $chapter = Chapter::findOrFail($id);
        return view('operator.chapters.edit', compact('book', 'chapter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $bookId, $chapterId)
    {
        //
        $request->validate([
            'title' => 'required',
            'sr' => 'required|numeric',
        ]);

        $chapter = Chapter::findOrFail($chapterId);

        try {
            $chapter->update($request->all());
            return redirect()->route('operator.books.chapters.index', $chapter->course_id)->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bookId, string $id)
    {
        //
        $chapter = Chapter::findOrFail($id);
        try {
            $chapter->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
