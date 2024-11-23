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

            <form action="{{route('user.papers.update', $paper)}}" method='post' class="md:w-2/3 mx-auto mt-12">
                @csrf
                @method('PATCH')
                <div class="grid gap-8">
                    <div class="w-1/2">
                        <label>Paper Date: mm/dd/yy</label>
                        <input type="date" name='paper_date' class="custom-input-borderless" value="{{ $paper->paper_date->format('Y-m-d') }}">
                    </div>
                    <div class="">
                        <label>Paper Title</label>
                        <input type="text" name='title' class="custom-input-borderless" placeholder="Paper title" value="{{ $paper->title }}" required>
                    </div>
                    <div class="">
                        <label>Institution Name</label>
                        <input type="text" name='institution' class="custom-input-borderless" placeholder="Institution name" value="{{ $paper->institution }}">
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-green rounded py-2 px-4 mt-6">Update</button>
                    </div>

                </div>
            </form>

        </div>

    </div>
</div>
@endsection