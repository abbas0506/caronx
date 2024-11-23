@extends('layouts.basic')
@section('header')
<x-headers.user page="Q. Bank" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='books'></x-sidebars.admin>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.courses.index',)}}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.course.chapters.index',$chapter->course)}}">Chapters</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.chapter.questions.index',$chapter)}}">Questions</a>
            <i class="bx bx-chevron-right"></i>
            <div>Show</div>
        </div>

        <div class="md:w-4/5 mx-auto mt-8">
            <h2>{{ $question->chapter->course->name }}</h2>
            <label>Ch # {{ $question->chapter->sr }}. {{ $question->chapter->title }}</label>

            <div class="grid gap-6 mt-6">
                <div class="">
                    <label for="">Question Statement</label>
                    <div class="custom-input-borderless">{{ $question->statement }}</div>
                </div>
                <!-- MCQs or معروضی -->
                @if(in_array($question->type_id,[1,23]))
                <div class="text-sm">
                    <label for="">Choices</label>
                    <div class="grid gap-6 mt-2">
                        <div class="text-sm md:w-1/2">a. &nbsp{{ $question->mcq->choice_a }}</div>
                        <div class="text-sm md:w-1/2">b. &nbsp{{ $question->mcq->choice_b }}</div>
                        <div class="text-sm md:w-1/2">c. &nbsp{{ $question->mcq->choice_c }}</div>
                        <div class="text-sm md:w-1/2">d. &nbsp{{ $question->mcq->choice_d }}</div>
                    </div>
                </div>
                @elseif(in_array($question->type_id,[11,25]))
                <!-- poetry -->
                <div class="text-sm">
                    <label for="">Parahrasing: Poetry lines</label>
                    <div class="grid gap-2 mt-2">
                        @foreach($question->poetryLines as $poetryLine)
                        <div class="text-sm">{{ $poetryLine->line_a }}</div>
                        <div class="text-sm">{{ $poetryLine->line_b }}</div>
                        @endforeach
                    </div>
                </div>
                <!-- Comprehension or عبارت سے سوالات -->
                @elseif(in_array($question->type_id,[19,29]))
                <div class="text-sm">
                    <label for="">Sub Questions</label>
                    <div class="grid gap-2 mt-2">
                        @foreach($question->comprehensions as $comprehension)
                        <div class="text-sm">{{ Roman::lowercase($loop->index+1) }} &nbsp {{ $comprehension->sub_question }}</div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="">
                    <label>Conceptual?</label>
                    <div>@if($question->is_conceptual) Yes @else No @endif</div>
                </div>

                <div class="">
                    <label for="">Bise Frequency</label>
                    <div>{{ $question->frequency }}</div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection