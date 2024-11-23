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
                <div>New Paper</div>
            </div>
        </div>
        <div class="md:w-4/5 mx-auto">
            <h1 class="text-xl md:text-2xl text-center mt-5">Paper Generation</h1>
            <img src="{{url('images/small/paper.png')}}" alt="paper" class="w-24 mx-auto mt-6">
            <p class="text-slate-600 leading-relaxed mt-6 text-center text-xs md:text-sm">Welcome to our Automated Question Paper Generation Tool, designed to offer you a simple yet highly flexible interface for creating custom question papers tailored to your specific needs.</p>
            <div class="h-1 w-24 bg-teal-800 mx-auto mt-6"></div>
            <p class="text-center mt-4 text-slate-500 text-sm">Step 1/4</p>
            <h3 class="text-lg mt-2 text-center">Select a Grade</h3>
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
            <form action="{{ route('user.papers.store') }}" id="div-{{$grade->id}}" class="fold hidden my-5" method="post">
                @csrf
                <div class="grid grid-cols-1 md:w-2/3 mx-auto gap-4">
                    <div>
                        <label for="">Select a subject</label>
                        <select name="book_id" id="" class="custom-input-borderless py-1 rounded">
                            @foreach($grade->books as $book)
                            <option value="{{ $book->id }}">{{$book->subject->name_en}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="">Paper Title</label>
                        <input type="text" name="title" class="custom-input-borderless" placeholder="Series Test" required>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-teal rounded-md text-sm py-2 px-4">Next <i class="bi-arrow-right"></i></button>
                    </div>
                </div>
            </form>
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