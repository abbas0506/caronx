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
            <a href="{{route('operator.grade.books.index', $book->grade)}}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('operator.books.chapters.index', $book)}}">Chapters</a>
            <i class="bx bx-chevron-right"></i>
            <div>New</div>
        </div>



        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="container-light bg-slate-100">
            <div class="flex items-center">
                <h3 class="bg-green-800 text-white px-3 py-1 rounded-full">New Chapter</h3>
            </div>
            <div class="flex justify-center items-center mt-8">
                <!-- page message -->
                <form action="{{route('operator.books.chapters.store', $book)}}" method='post' class="md:w-2/3">
                    @csrf

                    <div class="grid gap-6">
                        <div>
                            <h2>{{ $book->name }}</h2>
                        </div>
                        <div>
                            <label>Chapter Title</label>
                            <input type="text" name='title' class="custom-input-borderless" placeholder="Enter chapter title" value="" required>
                        </div>
                        <div class="md:w-1/2">
                            <label>Chapter No.</label>
                            <input type="number" name="sr" value="{{ $book->chapters->count() + 1 }}" class="custom-input-borderless" min=1>
                        </div>
                        <div class="md:w-1/2">
                            <label>Tag</label>
                            <select name="tag_id" class="custom-input-borderless" required>
                                <option value="">Select ...</option>
                                @foreach($tags->sortBy('sr') as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-green rounded mt-6">Create</button>
                        </div>

                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection