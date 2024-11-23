@extends('layouts.basic')

@section('header')
<x-headers.user page="questions" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.operator page='questions'></x-sidebars.admin>
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
                <div>Edit</div>
            </div>

            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <div class="container-light">
                <div class="flex items-center">
                    <h3 class="text-green-600 bg-green-100 px-3 py-1 rounded-full">Edit Chapter <i class="bx bx-pencil"></i></h3>
                </div>
                <div class="flex justify-center items-center mt-12">
                    <!-- page message -->
                    <form action="{{route('operator.books.chapters.update', [$book, $chapter])}}" method='post' class="md:w-2/3">
                        @csrf
                        @method('PATCH')
                        <div class="grid gap-6">
                            <div>
                                <h2>{{ $chapter->book->name }}</h2>
                            </div>
                            <div>
                                <label>Chapter Title</label>
                                <input type="text" name='title' class="custom-input-borderless" placeholder="Enter chapter title" value="{{ $chapter->title }}" required>
                            </div>
                            <div class="md:w-1/2">
                                <label>Chapter No.</label>
                                <input type="number" name="sr" value="{{ $chapter->sr }}" class="custom-input-borderless" min=1>
                            </div>
                            <div class="md:w-1/2">
                                <label>Tag Name</label>
                                <p>{{ $chapter->tag->name }} </p>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-green rounded mt-6">Create</button>
                            </div>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    @endsection