@extends('layouts.basic')
@section('header')
<x-headers.user page="Questions" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.operator page='questions'></x-sidebars.operator>
@endsection

@php
$colors=config('globals.colors');
$i=0;
$activeChapter=$chapter;
@endphp

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('operator.books.index')}}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('operator.books.chapters.index', $chapter->course)}}">Chapters</a>
            <i class="bx bx-chevron-right"></i>
            <div>Ch. {{ $chapter->sr }}</div>

        </div>


        <div class="gridgap-6">
            <!-- mid panel  -->
            <div class="flex flex-wrap items-center justify-between p-4 border rounded-lg bg-green-100 border-green-200">
                <div>
                    <h2>{{ $chapter->course->name }}</h2>
                    <label>Ch # {{ $chapter->sr }}. {{ $chapter->title }}</label>
                </div>

                <a href="{{route('operator.chapter.questions.create', $chapter)}}" class="btn btn-green rounded">New Q.</a>

            </div>

            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <!-- search -->
            <div class="md:w-1/3 relative my-4">
                <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
                <i class="bx bx-search absolute top-2 right-2"></i>
            </div>
            <div class="flex items-center gap-6">

                <a href="{{route('operator.type-changes.edit', $chapter)}}" class="btn btn-blue">Change Q.Type</a>
                <a href="{{route('operator.question-movements.edit', $chapter)}}" class="btn btn-orange">Move to Chapter</a>
            </div>

            <div class="overflow-x-auto">
                <table class="table-fixed borderless w-full mt-3">
                    <thead>
                        <tr class="tr">
                            <th class="w-8">Sr</th>
                            <th class="w-48">Question</th>
                            <th class="w-20">Type</th>
                            <th class="w-12">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($chapter->questions->sortByDesc('updated_at') as $question)
                        <tr class="tr">
                            <td>{{ $loop->index+1 }}</td>
                            <td class="text-left"><a href="{{ route('operator.chapter.questions.show',[$chapter,$question]) }}" class="link">{{ $question->statement }}</a></td>
                            <td>{{ $question->type->name }}</td>
                            <td>
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{route('operator.chapter.questions.edit', [$chapter, $question])}}">
                                        <i class="bx bx-pencil text-green-600"></i>
                                    </a>
                                    <form action="{{route('operator.chapter.questions.destroy', [$chapter->id, $question])}}" method="POST" onsubmit="return confirmDel(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-transparent p-0 border-0">
                                            <i class="bx bx-trash text-red-600"></i>
                                        </button>
                                    </form>
                                </div>

                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    function confirmDel(event) {
        event.preventDefault(); // prevent form submit
        var form = event.target; // storing the form

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                form.submit();
            }
        })
    }

    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        var str = 0;
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>

@endsection