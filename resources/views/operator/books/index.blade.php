@extends('layouts.basic')
@section('header')
<x-headers.user page="Questions" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.operator page='questions'></x-sidebars.operator>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb">
                <a href="{{ url('/') }}">Home</a>
                <div>/</div>
                <div>Q.Bank</div>
                <div>/</div>
                <div>Books</div>
            </div>
        </div>
        <div class="md:w-4/5 mx-auto">
            <h1 class="text-xl md:text-3xl text-center mt-5">Question Bank</h1>
            <img src="{{url('images/icons/paper-3.png')}}" alt="paper" class="w-24 mx-auto mt-3">
            <p class="text-slate-600 leading-relaxed mt-6 text-center">Here you can explore question bank thoroughly. <br> Just click on any of the following grades</p>
            <div class="h-1 w-24 bg-teal-800 mx-auto mt-6"></div>

            <h3 class="text-lg mt-8 text-center">Grades / Classes</h3>
            <div class="flex items-center justify-center gap-x-4 mt-5">
                @foreach($grades as $grade)
                <div data-bound='div-{{$grade->id}}' class="round-tab">{{ $grade->grade_no }}</div>
                @endforeach
            </div>

            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            @foreach($grades as $grade)
            <div id="div-{{$grade->id}}" class="fold hidden my-5">
                <div class="grid grid-cols-1 md:w-3/4 mx-auto">

                    @foreach($grade->books as $book)
                    <a href="{{ route('operator.books.chapters.index', $book) }}" class="flex justify-between items-center odd:bg-slate-100 p-2">
                        <span>{{$book->subject->name_en}}</span>
                        <span class="text-xs">
                            <i class="bi-layers"></i> {{ $book->chapters->count() }} &nbsp
                            <i class="bi-question-circle"></i> {{ $book->questions->count() }}
                        </span>

                    </a>
                    @endforeach


                </div>
            </div>
            @endforeach

        </div>
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
                scrollTop: 200
            }, 1000); // 1000 milliseconds = 1 second for the scroll duration

        })
    </script>
    @endsection