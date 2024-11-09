@extends('layouts.basic')
@section('header')
<x-headers.user page="Q. Bank" icon="<i class='bi bi-question-circle'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='qbank'></x-sidebars.admin>
@endsection

@section('body')

<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.qbank-books.index',)}}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.qbank-books.chapters.index',$book)}}">Chapters</a>
            <i class="bx bx-chevron-right"></i>
            <div>Edit</div>
        </div>

        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif


        <div class="container bg-slate-100 py-6">
            <div class="flex justify-center items-center mt-8">
                <!-- page message -->
                <form action="{{route('admin.qbank-books.chapters.update', [$book, $chapter])}}" method='post' class="md:w-2/3">
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <h2>{{ $chapter->book->name }}</h2>
                        </div>
                        <div>
                            <label>Sr</label>
                            <input type="number" name="sr" value="{{ $chapter->sr }}" class="custom-input-borderless" min=1>
                        </div>
                        <div class="md:col-span-2">
                            <label>Chapter Title</label>
                            <input type="text" name='title' class="custom-input-borderless" placeholder="Enter chapter title" value="{{ $chapter->title }}" required>
                        </div>
                        <div>
                            <label>Tag</label>
                            <select name="tag_id" class="custom-input-borderless" required>
                                <option value="">Select ...</option>
                                @foreach($tags->sortBy('sr') as $tag)
                                <option value="{{ $tag->id }}" @selected($tag->id==$chapter->tag_id)>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit" class="btn-green rounded mt-6">Update</button>
                        </div>

                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection