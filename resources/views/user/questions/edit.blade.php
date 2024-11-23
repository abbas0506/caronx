@extends('layouts.basic')

@section('header')
<x-headers.user page="Q. Paper" icon="<i class='bi bi-file-earmark-text'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.user page='paper'></x-sidebars.user>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb">
                <a href="{{ url('/') }}">Home</a>
                <div>/</div>
                <a href="{{ route('user.papers.show', $paper) }}">Paper</a>
                <div>/</div>
                <div>Edit Q.</div>
            </div>
        </div>
        <div class="divider"></div>

        <div class="md:w-3/4 mx-auto mt-8">

            <h2>{{ $question->chapter->book->name }}</h2>
            <label>Ch # {{ $question->chapter->sr }}. {{ $question->chapter->title }}</label>

            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <form action="{{route('user.paper.base-questions.update', [$paper, $question])}}" method='post' class="grid gap-6 mt-12" onsubmit="return validate(event)">
                @csrf
                @method('PATCH')

                <input type="hidden" id='book_id' value="{{ $question->chapter->book->id }}">
                <div class="md:w-1/3">
                    <label>Question Type</label>
                    <select name="type_id" id="" class="custom-input-borderless">
                        @foreach($types->sortBy('sr') as $type)
                        <option value="{{ $type->id }}" @selected($type->id==$question->type_id)>{{ $type->name }}</option>
                        @endforeach
                    </select>
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

                <div class="">
                    @if($question->similarQuestions())
                    <h3>Similar Questions ({{ $question->similarQuestions()->count() }})</h3>

                    @foreach($question->similarQuestions() as $similar)
                    <p class="text-xs">{{ $loop->index+1 }}. &nbsp {{ $similar->statement }}</p>
                    @endforeach
                    @else
                    <h3>Similar Questions (0)</h3>
                    @endif
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

                <div class="divider"></div>
                <div class="text-center col-span-full mb-6">
                    <button type="submit" class="btn btn-blue px-4 py-2 rounded">Update / Approve Now</button>
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