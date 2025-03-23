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

        <form action="{{route('user.paper.topics.store', $paper)}}" method='post' class="mt-4 w-full md:w-4/5 mx-auto" onsubmit="return validate(event)">
            @csrf
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
                            <input type="checkbox" id='topic{{$topic->id}}' name='topic_ids_array[]' class="custom-input w-4 h-4 rounded hidden" value="{{ $topic->id }}">
                            <i class="bx bx-check"></i>
                        </div>
                        <div class="w-16">{{ $chapter->sr }}.{{ $topic->sr }}</div>
                        <div class="flex-1">{{ $topic->name }}</div>

                    </div>
                    @endforeach
                </div>
                @endforeach
                <div class="divider my-5"></div>
                <div class="flex justify-end my-5">
                    <button type="submit" class="btn-teal rounded-md text-sm py-2 px-4" @disabled($course->chapters->count()==0)>Next <i class="bi-arrow-right"></i></button>
                </div>

            </div>
        </form>
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