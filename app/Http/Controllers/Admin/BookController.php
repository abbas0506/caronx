<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Course;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $courses = Course::with('book')->get();
        return view('admin.books.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'sr' => 'required|numeric',
            'course' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $course = Course::create([
                'name' => $request->course,
            ]);

            $course->book()->create([
                'name' => $request->name,
                'sr' => $request->sr,
            ]);
            DB::commit();
            return redirect()->route('admin.books.index')->with('success', 'Successfully added');;
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
        $courses = Course::all();
        $book = Book::findOrFail($id);
        return view('admin.books.edit', compact('courses', 'book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'sr' => 'required|numeric',
            'course' => 'required',
        ]);
        $book = Book::findOrFail($id);
        $course = Course::findOrFail($book->course_id);
        DB::beginTransaction();
        try {
            $course->update([
                'name' => $request->course,
            ]);

            $course->book()->update([
                'name' => $request->name,
                'sr' => $request->sr,
            ]);
            DB::commit();
            return redirect()->route('admin.books.index')->with('success', 'Successfully added');;
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $book = Book::findOrFail($id);
        $course = Course::findOrFail($book->course_id);
        try {
            $course->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
