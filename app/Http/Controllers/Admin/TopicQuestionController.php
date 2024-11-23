<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Topic;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $topic = Topic::with('chapter', 'questions')->findOrFail($id);
        return view('admin.questions.index', compact('topic'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        //
        $topic = Topic::with('chapter')->findOrFail($id);
        $types = Type::all();
        return view('admin.questions.create', compact('topic', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        //
        $request->validate([
            'type_id' => 'required|numeric',
            'statement' => 'required|max:200',
            'answer' => 'required|max:300',
            'difficulty_level' => 'required|numeric',
        ]);

        $topic = Topic::findOrFail($id);
        DB::beginTransaction();

        try {
            $question = $topic->questions()->create([
                'type_id' => $request->type_id,
                'statement' => $request->statement,
                'answer' => $request->answer,
                'difficulty_level' => $request->difficulty_level,
            ]);

            // mcqs or معروضی
            if ($request->type_id == 1) {
                $correct = '';
                if ($request->check_a) $correct = 'a';
                if ($request->check_b) $correct = 'b';
                if ($request->check_c) $correct = 'c';
                if ($request->check_d) $correct = 'd';

                $question->mcq()->create([
                    'choice_a' => $request->choice_a,
                    'choice_b' => $request->choice_b,
                    'choice_c' => $request->choice_c,
                    'choice_d' => $request->choice_d,
                    'correct' => $correct,
                ]);
            } else {
                echo "Invalid question type detected";
            }

            // commit if all ok
            DB::commit();

            return redirect()->route('admin.topic.questions.create', $topic)->with(
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
    public function edit($topicId, $id)
    {
        //
        $topic = Topic::with('chapter')->findOrFail($topicId);
        $question = Question::with('type')->findOrFail($id);
        //dont allow mcq type change
        $types = Type::where('id', '>', 1)->get();
        return view('admin.questions.edit', compact('topic', 'question', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $topicId, $id)
    {
        //
        $request->validate([
            'type_id' => 'required|numeric',
            'statement' => 'required|max:200',
            'answer' => 'required|max:300',
            'difficulty_level' => 'required|numeric',
        ]);

        $topic = Topic::findOrFail($topicId);
        $question = Question::findOrFail($id);
        DB::beginTransaction();

        try {
            // update parent question
            $question->update([
                'type_id' => $request->type_id,
                'statement' => $request->statement,
                'answer' => $request->answer,
                'difficulty_level' => $request->difficulty_level,
            ]);

            // update mcqs
            if ($request->type_id == 1) {
                $correct = '';
                if ($request->check_a) $correct = 'a';
                if ($request->check_b) $correct = 'b';
                if ($request->check_c) $correct = 'c';
                if ($request->check_d) $correct = 'd';

                $question->mcq()->update([
                    'choice_a' => $request->choice_a,
                    'choice_b' => $request->choice_b,
                    'choice_c' => $request->choice_c,
                    'choice_d' => $request->choice_d,
                    'correct' => $correct,
                ]);
            } else {
                echo "Invalid question type detected";
            }

            // commit if all ok
            DB::commit();

            return redirect()->route('admin.topic.questions.index', $topic)->with(
                [
                    'success' => 'Successfully added',
                ]
            );
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($topicId, $id)
    {
        //
        $model = Question::findOrFail($id);
        try {
            $model->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
