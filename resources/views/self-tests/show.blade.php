@extends('layouts.basic')

@section('header')
<x-header></x-header>
@endsection

@section('body')
<style>
    .option label {
        cursor: pointer;
    }

    .question .tick,
    .question .cross {
        display: none;
    }


    .question.solved .radio {
        display: none;
    }

    .question.solved .rejected label {
        color: red;
        font-weight: bold;
        text-decoration-style: solid;
        text-decoration: line-through;
        text-decoration-color: red;
    }

    .question.solved .correct-option label {
        color: green;
        font-weight: bold;
    }

    .question.solved.correctly-answered .tick {
        display: block;
    }

    .question.solved.correctly-answered .cross {
        display: none;
    }

    .question.solved .cross {
        display: block;
    }
</style>

<div class="w-full md:w-2/3 mx-auto text-center mt-32 px-5">

    <div class="grid md:grid-cols-2 items-end gap-4">
        <div class="flex flex-col md:flex-row gap-3 items-center md:items-end">
            <img src="{{url('images/icons/mcqs-1.jpg')}}" alt="mcqs" class="w-24">
            <div class="flex flex-col">
                <div class="flex text-left space-x-3">
                    <h2>{{ $book->name }} </h2>
                </div>
                <p class="text-center md:text-left text-sm text-slate-600">@if(count($chapterNos)>1)Chapters @else Chapter @endif : {{ $chapterNos->implode(',') }}</p>
            </div>
        </div>
        <h3 class="text-red-600 text-center md:text-right">Max Marks: {{ session('mcqs_count') }}</h3>
    </div>
    <div class="divider my-3"></div>
    <!-- score card -->
    <div id='score_card' class="scorecard hidden">
        <div><i class="bi-award text-4xl"></i></div>
        <h1 class="text-xl mt-4" id='test_message'>Score Card</h1>
        <h2 class="" id='test_score'>Your Score: 2/3 (66%)</h2>
    </div>

    <div class="leading-relaxed mt-6 text-left bg-gradient-to-b from-teal-100 to-teal-50 border border-teal-100 text-slate-600 p-5">
        <ul class="list-disc list-inline text-left text-sm pl-4">
            <li>All questions are compulsory</li>
            <li>Once you finish the test, system will display your score and mistakes</li>
        </ul>
    </div>

    <input type="text" id="mcqs_count" value="{{session('mcqs_count')}}" hidden>


    <!-- questions -->
    <div class="grid gap-8 mt-8">
        @foreach($questions as $question)
        <div class="question">
            <!-- statement -->
            <p class="mb-3 text-left  text-teal-600">Question # {{ $loop->index+1 }}.</p>
            <div class="flex justify-between items-center bg-gradient-to-r from-blue-100 to-white py-2 px-6 text-left">
                <h2 class="">{{$question->statement}}</h2>
                <div class="">
                    <img src="{{url('images/icons/cross.png')}}" alt="cross" class="cross w-6">
                    <img src="{{url('images/icons/tick.png')}}" alt="tick" class="tick w-6">
                </div>
            </div>
            <!-- answers / choices -->
            <div class="answer grid gap-2 p-6 shadow-lg bg-gradient-to-r from-teal-50 to-white">
                <label class="text-left mb-2 underline underline-offset-4">Your Answer?</label>
                <div class="option flex space-x-3 items-center @if($question->mcq->correct=='a') correct-option @endif">
                    <input type="radio" id='radioa-{{$question->id}}' class="radio w-4 h-4">
                    <label for="radioa-{{$question->id}}">{{$question->mcq->choice_a}}</label>
                </div>

                <div class="option flex space-x-3 items-center @if($question->mcq->correct=='b') correct-option @endif">
                    <input type="radio" id='radiob-{{$question->id}}' class="radio w-4 h-4">
                    <label for="radiob-{{$question->id}}">{{$question->mcq->choice_b}}</label>
                </div>

                <div class="option flex space-x-3 items-center @if($question->mcq->correct=='c') correct-option @endif">
                    <input type="radio" id='radioc-{{$question->id}}' class="radio w-4 h-4">
                    <label for="radioc-{{$question->id}}">{{$question->mcq->choice_c}}</label>
                </div>
                <div class="option flex space-x-3 items-center @if($question->mcq->correct=='d') correct-option @endif">
                    <input type="radio" id="radiod-{{$question->id}}" class="radio w-4 h-4">
                    <label for="radiod-{{$question->id}}">{{$question->mcq->choice_d}}</label>
                </div>
            </div>
        </div>

        @endforeach

        <div class="flex justify-end">
            <a id='quit' href="{{ url('/') }}" class="btn btn-blue rounded-md py-3 px-4 text-sm mr-3"> Cancel Now</a>
            <button id='finishQuizButton' type="submit" class="btn btn-red rounded-md py-3 px-4 text-sm"> Finsh Test</button>
            <a id='tryOnceMore' href="{{ route('self-tests.show', $book) }}" class="hidden btn btn-green rounded-md px-4 py-3 text-sm"> Try Once More</a>
        </div>
    </div>
    <div class="my-8"></div>
</div>
@endsection

@section('script')
<script type="module">
    $('.radio').change(function() {
        var selectedOption = $(this)
        $(this).parent().parent().children().find('.radio').each(function() {
            if ($(this) != selectedOption)
                $(this).prop('checked', false);
        })
        selectedOption.prop('checked', true)
    });

    $('#finishQuizButton').click(function() {
        var correctAnswers = 0;
        var numOfMcqs = $('#mcqs_count').val();
        var unAnswered = numOfMcqs;
        $('.answer').each(function() {
            $(this).children().find('.radio:checked').each(function() {
                unAnswered -= 1
                if ($(this).parent().hasClass('correct-option')) {
                    $(this).parent().addClass('accepted')
                    $(this).parents('.question').addClass('correctly-answered')
                    correctAnswers += 1;
                } else
                    $(this).parent().addClass('rejected')
            })
        })
        if (unAnswered > 0) {
            Swal.fire({
                icon: "warning",
                title: unAnswered + " questions left",
                text: "Please complete the quiz!",
            });
        } else {
            var scorePercentage = parseFloat(correctAnswers / numOfMcqs * 100).toFixed(0);
            var text = '';
            if (scorePercentage < 60) text = "Best of luck next time!"
            else if (scorePercentage < 75) text = "Good effort..."
            else if (scorePercentage < 90) text = "Outstanding marks!"
            else text = "Brilliant!"

            var test_score = "Your score: " + correctAnswers + " out of " + numOfMcqs + " ( " + scorePercentage + "% )";
            $('#test_message').html(text);
            $('#test_score').html(test_score);

            if (scorePercentage < 33)
                $('#score_card').addClass('failure');
            else
                $('#score_card').addClass('success');

            $('#score_card').show();

            $('html, body').animate({
                scrollTop: 100
            }, 1000); // 1000 milliseconds = 1 second for the scroll duration

            // Swal.fire({
            //     icon: "success",
            //     title: scorePercentage + "%",
            //     // parseFloat(numOfMcqs / correctAnswers).toFixed(1) 
            //     text: text,
            // });
            // display correct asnswers
            $('.question').each(function() {
                $(this).addClass('solved')
                $('#finishQuizButton').addClass('hidden');
                $('#tryOnceMore').removeClass('hidden');
            });
        }

    })
</script>
@endsection