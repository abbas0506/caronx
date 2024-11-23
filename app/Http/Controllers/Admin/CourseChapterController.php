<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Course;
use Exception;
use Illuminate\Http\Request;

class CourseChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($courseId)
    {
        //
        $course = Course::findOrFail($courseId);
        return view('admin.chapters.index', compact('course'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($courseId)
    {
        //
        $course = Course::findOrFail($courseId);
        return view('admin.chapters.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $courseId)
    {
        //
        $request->validate([
            'title' => 'required',
            'sr' => 'required|numeric',
        ]);

        $course = Course::findOrFail($courseId);
        try {

            $course->chapters()->create($request->all());
            return redirect()->route('admin.course.chapters.index', $course)->with('success', 'Successfully added');;
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
    public function edit($courseId, string $id)
    {
        //
        $course = Course::findOrFail($courseId);
        $chapter = Chapter::findOrFail($id);
        return view('admin.chapters.edit', compact('course', 'chapter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $courseId, $chapterId)
    {
        //
        $request->validate([
            'title' => 'required',
            'sr' => 'required|numeric',
        ]);

        $chapter = Chapter::findOrFail($chapterId);

        try {
            $chapter->update($request->all());
            return redirect()->route('admin.course.chapters.index', $chapter->course_id)->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($courseId, string $id)
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
