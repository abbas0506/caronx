<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ChapterTopicController;
use App\Http\Controllers\Admin\CourseChapterController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\TopicQuestionController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\SelfTestController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\BaseQuestionController;
use App\Http\Controllers\User\DashboardController as TeacherDashboardController;
use App\Http\Controllers\User\LatexPdfController;
use App\Http\Controllers\User\PaperChapterController;
use App\Http\Controllers\User\PaperController as TeacherPaperController;
use App\Http\Controllers\User\PaperKeyController;
use App\Http\Controllers\User\PaperQuestionController as UserPaperQuestionController;
use App\Http\Controllers\User\PaperQuestionExtensionController;
use App\Http\Controllers\User\PaperQuestionPartController;
use App\Http\Controllers\User\PartialQuestionController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SimplePdfController;
use App\Http\Controllers\User\SimpleQuestionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('index');
    // if (Auth::check()) {
    //     return redirect(session('role'));
    // } else {
    //     return view('index');
    // }
});


Route::view('about', 'about');
Route::view('services', 'services');
Route::view('team', 'team');
Route::view('blogs', 'blogs');
Route::view('login', 'login')->name('login');

Route::resource('signup', SignupController::class);
Route::view('signup-success', 'signup-success');

Route::view('forgot', 'forgot');
Route::post('forgot', [AuthController::class, 'forgot']);

Route::get('login/as', function () {
    $year = date('Y');
    return view('login_as', compact('year'));
});

Route::get('switch/as/{role}', [UserController::class, 'switchAs']);

Route::post('login', [AuthController::class, 'login']);

Route::post('login/as', [AuthController::class, 'loginAs'])->name('login.as');
Route::get('signout', [AuthController::class, 'signout'])->name('signout');

Route::resource('passwords', PasswordController::class);

Route::resource('self-tests', SelfTestController::class);
Route::get('findSimilarQuestions', [AjaxController::class, 'findSimilarQuestions']);


Route::middleware(['auth'])->group(function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['role:admin']], function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::resource('users', UserController::class);
        Route::resource('packages', PackageController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('course.chapters', CourseChapterController::class);
        Route::resource('chapter.topics', ChapterTopicController::class);
        Route::resource('types', TypeController::class);

        Route::resource('topic.questions', TopicQuestionController::class);
        Route::view('change/password', 'admin.change_password');
        Route::post('change/password', [AuthController::class, 'changePassword'])->name('change.password');
    });

    Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['role:user']], function () {
        Route::get('/', [TeacherDashboardController::class, 'index']);
        Route::resource('papers', TeacherPaperController::class);
        Route::resource('paper.chapters', PaperChapterController::class);
        Route::resource('paper.questions', UserPaperQuestionController::class);
        Route::resource('paper-question-parts', PaperQuestionPartController::class);

        Route::resource('paper.question-type.partial-questions', PartialQuestionController::class);
        Route::resource('paper.question-type.simple-questions', SimpleQuestionController::class);
        Route::resource('paper.base-questions', BaseQuestionController::class);

        Route::resource('paper-question.type.extensions', PaperQuestionExtensionController::class);

        Route::resource('papers.latex-pdf', LatexPdfController::class);
        Route::resource('papers.simple-pdf', SimplePdfController::class);

        Route::resource('accounts', AccountController::class);
        Route::resource('profiles', ProfileController::class);

        Route::get('paper-question-parts/{part}/refresh', [PaperQuestionPartController::class, 'refresh'])->name('paper-question-parts.refresh');

        Route::get('papers/{paper}/key', [PaperKeyController::class, 'show'])->name('papers.keys.show');
        Route::get('papers/{paper}/key/pdf', [PaperKeyController::class, 'pdf'])->name('papers.keys.pdf');
    });
});

Route::get('/test-api', function () {
    $res = "Divide & Conquer";
    $res = App\Helpers\Helper::parseTex($res);
    return response()->json($res);
});
