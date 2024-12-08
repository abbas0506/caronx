@extends('layouts.basic')

@section('header')
<x-headers.user page="Grades" icon="<i class='bi bi-file-earmark-text'></i>"></x-headers.user>
@endsection


@section('sidebar')
<x-sidebars.collaborator page='home'></x-sidebars.collaborator>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb">
                <a href="{{ url('/') }}">Home</a>
                <div>/</div>
                <div>Grades</div>
            </div>
        </div>
        <div class="md:w-4/5 mx-auto">
            <h1 class="text-xl md:text-3xl text-center mt-5">Question Approval</h1>
            <p class="text-xl text-center mt-2">{{ Auth::user()->profile->subject->name_en }}</p>
            <img src="{{url('images/icons/online-test-min.png')}}" alt="paper" class="w-24 h-24 mx-auto mt-6">
            <p class="text-slate-600 leading-relaxed mt-6 text-center">We are very lucky to have you in collaboration. Your valuable approvals or feedback will help us build an error free question bank and ultimately provide quality service.</p>
            <div class="h-1 w-24 bg-teal-800 mx-auto mt-6"></div>

            <h3 class="text-lg mt-8 text-center">Grades / Classes</h3>
            <div class="flex items-center justify-center gap-x-4 mt-5">
                @foreach($grades as $grade)
                <a href="{{ route('collaborator.grade.chapters.index', $grade) }}" class="round-tab">{{ $grade->grade_no }}</a>
                @endforeach
            </div>
            <div class="text-center p-3 text-teal-600 mt-8">
                Please click on any of the above grade
            </div>

            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

        </div>
    </div>
</div>
@endsection