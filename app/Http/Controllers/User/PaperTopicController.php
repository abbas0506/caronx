<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use Exception;
use Illuminate\Http\Request;

class PaperTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $paper = Paper::findOrFail($id);
        $course = $paper->course;
        return view('user.paper-topics.index', compact('paper', 'course'));
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
            'topic_ids_array' => 'required',
        ]);

        try {
            $paper = Paper::findOrFail($id);
            $topicIdsArray = array();
            $topicIdsArray = $request->topic_ids_array;
            $commaSeparatedTopicIds = implode(',', $topicIdsArray);

            $paper->update([
                'topic_ids' => $commaSeparatedTopicIds,
            ]);

            session([
                'topicIdsArray' => $topicIdsArray,
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
