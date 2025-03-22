@extends('layouts.basic')

@section('header')
<x-headers.user page="New Paper" icon="<i class='bi bi-emoji-smile'></i>"></x-headers.user>
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
                <div>New Paper</div>
                <div>/</div>
                <div>Chapters</div>
            </div>
        </div>

        <div class="text-sm md:w-4/5 mx-auto mt-6">
            <h2 class="border-2 border-blue-300 p-4 my-8 rounded"><i class="bi-book"></i> &nbsp{{ $course->name }}</h2>

            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            @foreach($course->chapters->sortBy('sr') as $chapter)

            <div class="bg-white p-3">{{ $chapter->sr}}. &nbsp {{ $chapter->title }}</div>
            <div class="pl-8 pr-2 leading-relaxed">
                @foreach($chapter->topics->sortBy('sr') as $topic)
                <div class="flex items-center odd:bg-slate-100 space-x-3 checkable-row px-2">
                    <div class="text-base font-extrabold ">
                        <input type="checkbox" id='chapter{{$chapter->id}}' name='chapter_ids_array[]' class="custom-input w-4 h-4 rounded hidden" value="{{ $chapter->id }}">
                        <i class="bx bx-check"></i>
                    </div>
                    <div class="w-16">{{ $chapter->sr }}.{{ $topic->sr }}</div>
                    <div class="flex-1">{{ $topic->name }}</div>

                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="module">
    $('.checkable-row input').change(function() {
        if ($(this).prop('checked'))
            $(this).parents('.checkable-row').addClass('active')
        else
            $(this).parents('.checkable-row').removeClass('active')
    })

    $('#check_all').change(function() {
        if ($(this).prop('checked')) {
            $('.checkable-row input').each(function() {
                $(this).prop('checked', true)
                $(this).parents('.checkable-row').addClass('active')
            })
        } else {
            $('.checkable-row input').each(function() {
                $(this).prop('checked', false)
                $(this).parents('.checkable-row').removeClass('active')
            })
        }
    })
</script>
@endsection