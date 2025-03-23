@extends('layouts.basic')
@section('header')
<x-headers.user page="Questions" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.operator page='questions'></x-sidebars.operator>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('operator.books.index')}}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('operator.books.chapters.index', $chapter->course)}}">Chapters</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('operator.chapter.questions.index', $chapter)}}">Questions</a>
            <i class="bx bx-chevron-right"></i>
            <div>Edit Q.</div>
        </div>

        <div class="divider"></div>

        <div class="md:w-3/4 mx-auto mt-8">

            <h2>{{ $question->chapter->course->name }}</h2>
            <label>Ch # {{ $question->chapter->sr }}. {{ $question->chapter->title }}</label>

            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif
            <form action="{{route('operator.chapter.questions.update', [$chapter, $question])}}" method='post' class="grid gap-6 mt-12" onsubmit="return validate(event)">
                @csrf
                @method('PATCH')

                <input type="hidden" id='course_id' value="{{ $chapter->course->id }}">
                <div class="">
                    <label>Question Type</label>
                    <p>{{ $question->type->name }}</p>
                </div>

                <div class="">
                    <label for="">Question Statement</label>
                    <textarea type="text" id='statement' name="statement" class="custom-input py-2 mt-2" rows='3' placeholder="Type here">{{ $question->statement }}</textarea>
                </div>

                <!-- preview -->
                <div class="col-span-full border p-6">
                    <!-- <span id="math" class="text-left no-line-break text-slate-400">Preview</span> -->
                    <span id="math" class="text-left text-slate-400">Preview</span>
                </div>

                <!-- MCQs -->
                @if($question->type_id == 1)
                <div id='mcq'>
                    <label for="">Choices</label>
                    <div class="grid gap-4 mt-2">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name='check_a' class="correct w-4 h-4" value='1' @checked($question->mcq->correct=='a')>
                            <input type="text" name='choice_a' class="custom-input-borderless choice md:w-1/2" placeholder="a." value="{{ $question->mcq->choice_a }}">
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name='check_b' class="correct w-4 h-4" value='1' @checked($question->mcq->correct=='b')>
                            <input type="text" name='choice_b' class="custom-input-borderless choice md:w-1/2" placeholder="b." value="{{ $question->mcq->choice_b }}">
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name='check_c' class="correct w-4 h-4" value='1' @checked($question->mcq->correct=='c')>
                            <input type="text" name='choice_c' class="custom-input-borderless choice md:w-1/2" placeholder="c." value="{{ $question->mcq->choice_c }}">
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name='check_d' class="correct w-4 h-4" value='1' @checked($question->mcq->correct=='d')>
                            <input type="text" name='choice_d' class="custom-input-borderless choice md:w-1/2" placeholder="d." value="{{ $question->mcq->choice_d }}">
                        </div>
                    </div>
                </div>

                <!-- poetry lines -->
                @elseif(in_array($question->type_id,[11,25]))
                <div class="md:w-1/3">
                    <label for="">Sr</label>
                    <input type="text" name='sr' class="custom-input-borderless" placeholder="Sr" value="{{ $question->poetryLines->first()->sr }}">
                </div>

                <div>
                    <label for="">Poetry Line</label>
                    <div class="grid gap-4 md:grid-cols-2 mt-2">
                        <input type="text" name='line_a' class="custom-input-borderless" placeholder="Line A" value="{{ $question->poetryLines->first()->line_a }}">
                        <input type="text" name='line_b' class="custom-input-borderless" placeholder="Line B" value="{{ $question->poetryLines->first()->line_b }}">
                    </div>
                </div>


                <!-- comprehension questions-->
                @elseif(in_array($question->type_id,[19,29]))
                <div class="">
                    <label for="">Comprehension Questions</label>
                    <div class="grid gap-4 mt-2">
                        @foreach($question->comprehensions as $comprehension)
                        <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Q." value="{{ $comprehension->sub_question }}">
                        <input type="hidden" name='sub_question_ids[]' value="{{ $comprehension->id }}">
                        @endforeach

                    </div>
                </div>
                @endif



                <div class="md:w-1/3">
                    <label>Conceptual?</label>
                    <select name="is_conceptual" id="" class="custom-input-borderless">
                        <option value="1" @selected(session('is_conceptual'))>Yes</option>
                        <option value="0" @selected(!session('is_conceptual'))>No</option>
                    </select>
                </div>

                <div class="md:w-1/3">
                    <label for="">Bise Frequency</label>
                    <input type="number" name="frequency" value="1" min=0 class="custom-input-borderless">
                </div>

                <input type="hidden" name='sr' value="{{ $chapter->sr }}">
                <div class="text-right col-span-full">
                    <button type="submit" class="btn btn-green">Update Now</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
@section('script')
<script type="module">
    $(document).ready(function() {

        $('#statement').bind('input propertychange', function() {
            $('#math').html($('#statement').val());
            MathJax.typeset();
        });

        $('.choice').bind('input propertychange', function() {
            $('#math').html($(this).val());
            MathJax.typeset();
        });


        $('.correct').change(function() {
            $('.correct').not(this).prop('checked', false);
            $(this).prop('checked', true)
        });
    });
</script>
@endsection