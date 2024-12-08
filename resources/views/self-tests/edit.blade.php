@extends('layouts.basic')

@section('header')
<x-header></x-header>
@endsection

@section('body')
<div class="w-full md:w-2/3 mx-auto text-center mt-32 px-5">

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <form id='start-test-form' action="{{route('self-tests.store')}}" method='post' onsubmit="return validate(event)">
        @csrf

        <div class="grid place-content-center gap-4">
            <img src="{{url('images/icons/mcqs-1.jpg')}}" alt="mcqs" class="w-24 md:w-32 mx-auto">
            <h2>{{ $book->name }} </h2>
            <div class="w-32">
                <label for="" class="text-red-600">How many MCQs?</label>
                <input type="number" name="mcqs_count" class="custom-input-borderless text-center" min=1 max=50 value="20">
            </div>
        </div>

        <div class="leading-relaxed mt-6 text-left bg-gradient-to-b from-teal-100 to-teal-50 border border-teal-100 text-slate-600 p-5">
            <ul class="list-disc list-inline text-left text-sm pl-4">
                <li>Set the number of MCQs for test</li>
                <li>Select chapter(s) and click on <b>Start Now</b></li>
            </ul>
        </div>

        <div class="mt-3">
            @foreach($book->chapters->sortBy('sr') as $chapter)
            <div class="flex items-center justify-between space-x-2 border-b">
                <label for="chapter{{$chapter->id}}" class="hover:cursor-pointer text-sm text-slate-600 text-left py-3 flex-1">{{$chapter->sr}}. &nbsp {{$chapter->title}}</label>
                <input type="checkbox" id='chapter{{$chapter->id}}' name='chapter_ids_array[]' class="custom-input w-4 h-4" value="{{ $chapter->id }}">
            </div>
            @endforeach
        </div>
        <div class="flex items-center justify-center gap-4 my-8">
            <input type="hidden" name="book_id" value="{{ $book->id }}">
            <a href="{{ route('self-tests.index') }}" class="hover:bg-slate-100 py-3 px-4 text-sm rounded-md border">Cancel Test</a>
            <button type="submit" class="btn btn-teal py-3 px-4 text-sm rounded-md" @disabled($book->chapters->count()==0)> Start Now</button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script type="module">
    $('document').ready(function() {
        $('#start-test-form').submit(function(e) {
            var anyChecked = 0
            $('.custom-input').each(function() {
                if ($(this).is(':checked'))
                    anyChecked++;
            })
            if (anyChecked == 0) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select a chapter',
                    showConfirmButton: false,
                    timer: 1000,
                })

            }
        })
    })
</script>
@endsection