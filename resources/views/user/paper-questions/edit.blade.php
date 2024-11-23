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
                <a href="{{ route('user.papers.show', $paper) }}">Q. Paper</a>
                <div>/</div>
                <div>Edit</div>
            </div>
        </div>


        <div class="content-section rounded-lg mt-2">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <form action="{{route('user.paper.questions.update', [$paper, $paperQuestion])}}" method='post' class="md:w-2/3 mx-auto mt-12">
                @csrf
                @method('PATCH')
                <div class="grid gap-8">
                    <div class="">
                        <label>Question Title</label>
                        <input type="text" name='question_title' class="custom-input-borderless" placeholder="Enter question title" value="{{ $paperQuestion->question_title }}">
                    </div>
                    <div class="md:w-1/2">
                        <label>Marks</label>
                        <input type="number" name='marks' class="custom-input-borderless" placeholder="Marks" value="{{ $paperQuestion->marks }}">
                    </div>
                    <div class="md:w-1/2">
                        <label>Compulsory Parts</label>
                        <input type="number" name='compulsory_parts' class="custom-input-borderless" placeholder="Compulsory parts" value="{{ $paperQuestion->compulsory_parts }}">
                    </div>

                    <div>
                        <button type="submit" class="btn btn-green rounded mt-6">Update</button>
                    </div>

                </div>
            </form>

        </div>

    </div>
</div>
@endsection