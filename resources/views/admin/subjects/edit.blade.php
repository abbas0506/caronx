@extends('layouts.basic')
@section('header')
<x-headers.user page="Config" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='config'></x-sidebars.admin>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="/">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.grades.index')}}">Config</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.subjects.index')}}">Subjects</a>
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
                <h3 class="text-green-600 bg-green-100 px-3 py-1 rounded-full">Edit Subject <i class="bx bx-book"></i></h3>
            </div>

            <!-- page message -->
            <form action="{{route('admin.subjects.update',$subject)}}" method='post' class="grid gap-8 md:w-2/3 mx-auto mt-12" onsubmit="return validate(event)">
                @csrf
                @method('PATCH')
                <div class="w-1/2 md:w-1/3">
                    <label>Display Order</label>
                    <input type="number" name='display_order' class="custom-input-borderless" placeholder="Enter display order" value="{{ $subject->display_order}}" min=0 required>
                </div>
                <div class="">
                    <label>Subject Name (english)</label>
                    <input type="text" name='name_en' class="custom-input-borderless" placeholder="Subject name" value="{{ $subject->name_en }}" required>
                </div>
                <div class="">
                    <label>Subject Name (urdu)</label>
                    <input type="text" name='name_ur' class="custom-input-borderless" placeholder="Subject name" value="{{ $subject->name_ur }}" required>
                </div>

                <div class="">
                    <button type="submit" class="btn btn-green rounded mt-6">Update</button>
                </div>
            </form>


        </div>
    </div>
    @endsection