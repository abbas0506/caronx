@extends('layouts.basic')

@section('header')
<x-header></x-header>
@endsection
@section('body')
<div class="w-full md:w-2/3 mx-auto text-center mt-32 px-5">

    <h1 class="text-2xl">SELF TEST</h1>
    <img src="{{url('images/icons/mcqs-1.jpg')}}" alt="mcqs" class="w-24 mx-auto">
    <p class="text-slate-600 leading-relaxed mt-6">Welcome to our Free Self-Testing Tool, designed to help students enhance their exam preparation and identify the areas of weakness </p>
    <div class="h-1 w-24 bg-teal-800 mx-auto mt-6"></div>

    <h3 class="text-lg mt-8">Select a Grade</h3>
    <div class="flex items-center justify-center gap-x-4 mt-5">
        @foreach($grades as $grade)
        <div data-bound='div-{{$grade->id}}' class="round-tab">{{ $grade->grade_no }}</div>
        @endforeach
    </div>



    @foreach($grades as $grade)
    <div id="div-{{$grade->id}}" class="fold hidden my-5">
        <div id='message' class="flex justify-center items-center text-center p-3 bg-teal-100 rounded-md mt-8 relative">
            Please select a subject
            <div class="absolute w-4 h-4 transform rotate-45 -bottom-2 left-5 bg-teal-100"></div>
        </div>

        @foreach($grade->books as $book)
        <a href="{{route('self-tests.edit',$book)}}" class="flex p-3 border-b">{{$book->subject->name_en}}</a>
        @endforeach
    </div>
    @endforeach


</div>
@endsection

@section('script')
<script type="module">
    $('.round-tab').click(function() {
        $('.round-tab').removeClass('active')
        $(this).addClass('active');
        $('#messageBeforeGradeSelection').hide();
        $('.fold').hide();
        $('#' + $(this).attr('data-bound')).show()

        $('html, body').animate({
            scrollTop: 300
        }, 1000); // 1000 milliseconds = 1 second for the scroll duration


    })
</script>
@endsection