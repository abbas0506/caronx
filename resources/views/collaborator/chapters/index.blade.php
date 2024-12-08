@extends('layouts.basic')

@section('header')
<x-headers.user page="Chapters" icon="<i class='bi bi-emoji-smile'></i>"></x-headers.user>
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
                <a href="{{route('collaborator.grades.index')}}">Grades</a>
                <div>/</div>
                <div>Chapters</div>
            </div>
        </div>


        <div class="content-section rounded-lg mt-2">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <div class="md:w-4/5 mx-auto">
                <h1 class="text-xl md:text-3xl text-center mt-5">Question Approval</h1>
                <p class="text-xl text-center mt-2">{{ $book->name }}</p>
                <img src="{{url('images/icons/online-test-min.png')}}" alt="paper" class="w-24 h-24 mx-auto mt-6">
                <p class="text-slate-600 leading-relaxed mt-6 text-center">We are very lucky to have you in collaboration. Your valuable approvals or feedback will help us build an error free question bank and ultimately provide quality service.</p>
                <div class="h-1 w-24 bg-teal-800 mx-auto mt-6"></div>



                <div class="divider my-3"></div>


                <div class="mt-4">
                    <div class="grid text-sm">
                        @foreach($tags->sortBy('sr') as $tag)
                        <div class="">
                            <h3 class="my-2">{{ $tag->name }}</h3>
                            @foreach($book->chapters->where('tag_id', $tag->id)->sortBy('sr') as $chapter)
                            <div class="grid odd:bg-slate-100">
                                <a href="{{ route('collaborator.chapter.questions.index',$chapter) }}" class="p-2 hover:pointer w-full">{{ $chapter->sr}}. &nbsp {{ $chapter->title }}</a>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection