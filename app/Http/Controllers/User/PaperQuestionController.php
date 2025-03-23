<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Models\PaperQuestion;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class PaperQuestionController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */
    public function index() {}

    public function create($id)
    {
        $paper = Paper::findOrFail($id);
        // get distinct question types from selected chapters
        $questionTypeIds = DB::table('questions')
            ->select('type_id')
            ->distinct()
            ->whereIn('topic_id', $paper->topicIdsArray())
            ->pluck('type_id');

        $questionTypes = Type::whereIn('id', $questionTypeIds)->get();
        return view('user.paper-questions.create', compact('paper', 'questionTypes'));
    }

    public function edit($paperId, $paperQuestionId)
    {
        $paper = Paper::findOrFail($paperId);
        $paperQuestion = PaperQuestion::findOrFail($paperQuestionId);

        return view('user.paper-questions.edit', compact('paper', 'paperQuestion'));
    }

    public function update(Request $request, $paperId, $paperQuestionId)
    {

        $request->validate([
            'question_title' => 'nullable',
            'marks' => 'required|numeric',
            'compulsory_parts' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            //create test question instance
            $paperQuestion = PaperQuestion::findOrFail($paperQuestionId);
            $paperQuestion->update($request->all());

            DB::commit();
            return redirect()->route('user.papers.show', $paperQuestion->paper)->with('success', 'Question successfully added!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    public function destroy(string $paperId, $paperQuestionId)
    {
        //
        try {
            $paperQuestion = PaperQuestion::findOrFail($paperQuestionId);
            $paperQuestion->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
