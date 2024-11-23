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
            <a href="/">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.courses.index')}}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <div>New</div>
        </div>

        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="container-light">

            <form action="{{route('admin.courses.store')}}" method='post' class="grid gap-8 mt-6 w-full md:w-2/3 mx-auto">
                @csrf
                <div class="md:w-1/2">
                    <label>Sr</label>
                    <input type="number" name="sr" value="{{ $sr }}" class="custom-input-borderless" placeholder="Sr" value="" required>
                </div>
                <div>
                    <label>Course Name</label>
                    <input type="text" name='name' class="custom-input-borderless" placeholder="Course Title" value="" required>
                </div>

                <div>
                    <button type="submit" class="btn btn-blue mt-6">Create</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection