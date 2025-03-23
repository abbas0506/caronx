@extends('layouts.basic')

@section('header')
<x-headers.user page="Welcome back!" icon="<i class='bi bi-emoji-smile'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.user page='paper'></x-sidebars.user>
@endsection

@section('body')

<div class="responsive-container">
    <div class="container">
        <h1>Answer Key</h1>
        <div class="bread-crumb">
            <a href="/">Home</a>
            <div>/</div>
            <div>Answer key</div>
        </div>

        <div class="content-section">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            @if($paper->paperQuestions()->mcqs()->count()>0)
            <div class="flex justify-end w-full">
                <div class="flex w-12 h-12 items-center justify-center rounded-full bg-orange-100 hover:bg-orange-200">
                    <a href="{{ route('user.papers.keys.pdf',$paper) }}" target="_blank"><i class="bi-printer"></i></a>
                </div>
            </div>
            @endif

            <div class="flex justify-between mt-4">
                <div>
                    <label>{{ $paper->title }}</label>
                    <h2>{{ $paper->course->name }}</h2>
                </div>
                <div class="flex flex-col justify-center">
                    <div class="flex items-center">
                        <label>Dated: &nbsp</label>
                        <label>{{$paper->paper_date->format('d/m/Y')}}</label>
                    </div>
                </div>
            </div>
            <div class="divider my-3"></div>

            @if($paper->paperQuestions()->mcqs()->count()>0)
            <table class="table-auto borderless mx-auto">
                <thead>
                    <tr>
                        <th class="w-20">Q.</th>
                        <th class="w-32">Answer</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paper->paperQuestions()->mcqs()->get() as $paperQuestion)

                    @foreach($paperQuestion->paperQuestionParts as $paperQuestionPart)

                    <tr class="tr">
                        <td>{{ $loop->index+1 }}.</td>
                        <td>{{ ucfirst($paperQuestionPart->question->mcq->correct)}}</td>
                    </tr>

                    @endforeach
                    @endforeach
                </tbody>
            </table>

            @else
            <div class="h-full flex flex-col justify-center items-center">
                <h3>Currently test is empty!</h3>
                <label for="">Please select one of the following options to add question</label>
            </div>
            @endif

        </div>
    </div>
    @endsection