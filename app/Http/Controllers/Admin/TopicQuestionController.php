<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Topic;
use App\Models\Type;
use Exception;
use Illuminate\Support\Facades\File;

// use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Laravel\Facades\Image;

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
            'statement' => 'required|max:500',
            'answer' => 'nullable|max:500',
            'difficulty_level' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

            if ($request->hasFile('image')) {
                $image = Image::read($request->file('image'));

                // $imageName = $question->id . '.' . $request->image->extension();
                $imageName = $question->id . '.png';

                $uploadPath = public_path('images/uploads/');
                $image->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $image->save($uploadPath . $imageName);

                $thumbnailPath = public_path('images/thumbnails/');
                // Resize the image (optional)
                $image->resize(50, 50);
                $image->save($thumbnailPath . $imageName);

                $question->update([
                    'image' => $imageName,
                ]);
            }

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
            'statement' => 'required|max:500',
            'answer' => 'nullable|max:500',
            'difficulty_level' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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


            if ($request->hasFile('image')) {
                $image = Image::read($request->file('image'));
                $uploadPath = public_path('images/uploads/');
                $thumbnailPath = public_path('images/thumbnails/');

                // replace old image
                if ($question->image) {
                    // delete the associated image and its thumbnail
                    File::delete($uploadPath . $question->image);
                    File::delete($thumbnailPath . $question->image);
                }
                //save new image
                $imageName = $question->id . str()->random(2) . '.png';

                $image->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $image->save($uploadPath . $imageName);

                // Resize the image (optional)
                $image->resize(50, 50);
                $image->save($thumbnailPath . $imageName);

                $question->update([
                    'image' => $imageName,
                ]);
            }


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
        $question = Question::findOrFail($id);
        try {

            $uploadPath = public_path('images/uploads/');
            $thumbnailPath = public_path('images/thumbnails/');
            // delete the associated image and its thumbnail
            File::delete($uploadPath . $question->image);
            File::delete($thumbnailPath . $question->image);
            // delete question itself
            $question->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
