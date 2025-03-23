<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Paper;
use App\Models\PaperQuestionPart;
use App\Models\Question;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaperQuestionPartController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        DB::beginTransaction();
        try {

            $paperQuestionPart = PaperQuestionPart::findOrFail($id);
            $paperQuestion = $paperQuestionPart->paperQuestion;
            //delete only if it is last
            if ($paperQuestion->paperQuestionParts->count() > 1) {

                if ($paperQuestion->type_name == 'simple-and') {
                    $marks = $paperQuestion->marks - $paperQuestionPart->marks;
                    $paperQuestion->update([
                        'marks' => $marks,
                    ]);
                }
                //if remaining part parts may become smaller than compulsory parts
                elseif ($paperQuestion->paperQuestionParts->count() <= $paperQuestion->compulsory_parts) {
                    // decrese by 1
                    $newCompulsoryCount = $paperQuestion->paperQuestionParts->count() - 1;
                    if (in_array($paperQuestion->type_id, [1, 2])) {

                        $typeId = $paperQuestion->paperQuestionParts->first()->question->type_id;
                        $type = Type::findOrFail($typeId);
                        $question_title = $type->default_title;

                        if ($typeId == 1) { //mcq
                            $marks = $newCompulsoryCount;
                        } elseif ($typeId == 2) { //short
                            $marks = $newCompulsoryCount * 2;
                        }

                        $paperQuestion->update([
                            'compulsory_parts' => $newCompulsoryCount,
                            'marks' => $marks,
                            'question_title' => $question_title,
                        ]);
                    }
                }
                $paperQuestionPart->delete();
                DB::commit();
                return redirect()->back()->with('success', 'Successfully deleted!');
            } else {
                echo "Question can't be deleted!";
            }
            // readjust the compulsory parts and question marks

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }


    public function refresh($paperQuestionPartId)
    {
        $paperQuestionPart = PaperQuestionPart::findOrFail($paperQuestionPartId);

        $alreadyIncludedQuestionIds = $paperQuestionPart->paperQuestion->paper->paperQuestionParts->pluck('question_id');

        $replacingQuestion = Question::where('topic_id', $paperQuestionPart->question->topic_id)
            ->where('type_id', $paperQuestionPart->question->type_id)
            ->whereNotIn('id', $alreadyIncludedQuestionIds)
            ->get()
            ->random(1)
            ->first();

        try {
            $paperQuestionPart->update([
                'question_id' => $replacingQuestion->id,
            ]);
            return redirect()->back();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
