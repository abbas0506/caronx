<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;

class LatexPdfController extends Controller
{
    //
    public function create($id)
    {
        // simple pdf
        $paper = Paper::findOrFail($id);
        return view('user.pdf.latex.create', compact('paper'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $paperId)
    {

        $paper = Paper::findOrFail($paperId);
        $orientation = $request->orientation;
        $pageSize = $request->page_size;
        $rows = $request->rows;
        $cols = $request->cols;
        $paper = Paper::findOrFail($paperId);
        $fontSize = $request->font_size;
        if ($paper->course->subject->text_direction == 'R') {
            App::setLocale('ur');
        }
        $data = view('user.pdf.latex.preview', compact('paper', 'orientation', 'pageSize', 'rows', 'cols', 'fontSize', 'paper'))->render();
        // store the latex file
        $data =  preg_replace('/\\\begin\{parts\}\s*\\\end\{parts\}/', '', $data);
        Storage::disk('local')->put('paper.tex', $data);
        try {
            $res =  Http::timeout(8)->attach('file', $data, 'paper.tex')
                ->post('http://16.171.40.228/latex-to-pdf');
            if ($res->failed() && auth()->user()->email === 'mazeemrehan@gmail.com') {
                return response()->file(storage_path('app/paper.tex'));
            }
            if ($res->failed()) {
                return $res->body();
            }
            Storage::disk('local')->delete('paper.pdf');
            $output = Storage::disk('local')->put('paper.pdf', $res->body());

            $user = Auth::user();
            $paper->update([
                'is_printed' => true,
            ]);
            return response()->file(storage_path('app/paper.pdf'));
        } catch (\Exception $e) {
            if (auth()->user()->email === 'mazeemrehan@gmail.com') {
                return response()->file(storage_path('app/paper.tex'));
            }
            return $e->getMessage();
        }
    }
}
