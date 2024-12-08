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


        <div class="content-section rounded-lg mt-6">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <div class="flex items-center justify-between flex-wrap  gap-2">
                <div class="flex flex-row items-center gap-3">
                    <img src="{{ url('images/icons/pdf.png') }}" alt="paper" class="w-12">
                    <div class="flex flex-col">
                        <h2>{{ $paper->book->name }} </h2>
                        <div class="flex items-center space-x-3">
                            <label>{{ $paper->title }}</label>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-slate-500 text-sm text-center md:text-right pr-5">Step 2/4</p>
                </div>
            </div>
            <div class="divider my-3"></div>
            <form action="{{route('user.paper.chapters.store', $paper)}}" method='post' class="mt-4 w-full md:w-4/5 mx-auto" onsubmit="return validate(event)">
                @csrf
                <div class="flex flex-wrap justify-between items-center">
                    <h2 class="mt-4">Which chapters should be included? </h2>
                    <div class="flex items-center space-x-2 mt-3">
                        <p class="text-red-600">Full Book</p>
                        <input type="checkbox" id='check_all' class="custom-input w-4 h-4 rounded">
                    </div>
                </div>
                <div class="mt-4">
                    <div class="grid text-sm">
                        @foreach($tags->sortBy('sr') as $tag)
                        <div class="">
                            <h3>{{ $tag->name }}</h3>
                            @foreach($paper->book->chapters->where('tag_id', $tag->id)->sortBy('sr') as $chapter)
                            <div class="flex items-center odd:bg-slate-100 space-x-3 checkable-row px-2">
                                <div class="flex flex-1 items-center justify-between space-x-2 pr-3">
                                    <div class="text-base font-extrabold ">
                                        <input type="checkbox" id='chapter{{$chapter->id}}' name='chapter_ids_array[]' class="custom-input w-4 h-4 rounded hidden" value="{{ $chapter->id }}">
                                        <i class="bx bx-check"></i>
                                    </div>
                                    <label for='chapter{{$chapter->id}}' class="flex-1 text-sm text-slate-800 py-3 hover:cursor-pointer">{{ $chapter->sr}}. {{ $chapter->title }} </label>

                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach

                    </div>

                    <div class="divider my-5"></div>
                    <div class="flex justify-end my-5">
                        <button type="submit" class="btn btn-teal rounded-md text-sm py-2 px-4" @disabled($paper->book->chapters->count()==0)>Next <i class="bi-arrow-right"></i></button>
                    </div>
            </form>
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