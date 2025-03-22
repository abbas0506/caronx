<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Paper;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Event\Code\Test;

class PaperController extends Controller
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
    public function create()
    {
        //
        $courses = Course::all();
        return view('user.papers.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'course_id' => 'required|numeric',
            'title' => 'required',
        ]);

        $request->merge([
            'institution' => Auth::user()->profile?->institution,
            'paper_date' => date('Y/m/d'),
        ]);

        try {
            $user = Auth::user();
            $paper = $user->papers()->create($request->all());

            return redirect()->route('user.paper.chapters.index', $paper);
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
        $paper = Paper::findOrFail($id);
        return view('user.papers.show', compact('paper'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $paper = Paper::findOrFail($id);
        return view('user.papers.edit', compact('paper'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'title' => 'required',
            // 'paper_date' => 'date',
            'institution' => 'nullable',
        ]);

        try {
            $paper = Paper::findOrFail($id);
            $paper->update($request->all());
            return redirect()->route('user.papers.show', $paper)->with('success', 'Successfully updated!');;
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
