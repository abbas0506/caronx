@extends('layouts.basic')
@section('header')
<x-headers.user page="Questions" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.operator page='questions'></x-sidebars.operator>
@endsection

@section('body')

@php
$colors=config('globals.colors');
$activeBook=$book;
$i=0;
@endphp

<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('operator.grade.books.index', $book->grade)}}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <div>Chapters</div>
        </div>


        <div class="p-4 border rounded-lg bg-green-100 border-green-200">
            <div class="flex flex-wrap gap-4 justify-between items-center">
                <div>
                    <h2>{{ $book->name }} </h2>
                    <label><i class="bi-layers"></i> {{ $book->chapters->count() }} chapters &nbsp <i class="bi-question-circle"></i> {{ $book->questions->count() }}</label>

                </div>
                <div>
                    <a href="{{ route('operator.books.chapters.create', $book) }}" class="btn btn-green rounded text-sm">Add Chapter</a>
                </div>

            </div>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif


        <div class="overflow-x-auto">
            <table class="table-fixed borderless w-full mt-3">
                <thead>
                    <tr>
                        <th class="w-12">Sr</th>
                        <th class="w-48">Chapter</th>
                        <th class="w-12"><i class="bi-question-circle"></i></th>
                        <th class="w-24">Desc</th>
                        <th class="w-20">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tags->sortBy('sr') as $tag)
                    <tr>
                        <td class="font-semibold">{{ $tag->name }}</td>
                    </tr>
                    @foreach($book->chapters->where('tag_id', $tag->id)->sortBy('sr') as $chapter)
                    <tr class="tr">
                        <td>{{ $chapter->id}}</td>
                        <td class="text-left"> <a href="{{ route('operator.chapter.questions.index', $chapter) }}" class="link"> {{ $chapter->title }} </a></td>
                        <td class="text-xs">{{ $chapter->questions->count() }}
                            @if($chapter->questions()->today()->count()>0)
                            {{ $chapter->questions()->today()->count() }}<i class="bi-arrow-up text-green-600"></i>
                            @endif
                        </td>
                        <td class="text-xs">
                            {{ $chapter->questions()->mcqs()->count() }}+{{ $chapter->questions()->shorts()->count() }}+{{ $chapter->questions()->longs()->count() }}
                        </td>
                        <td>
                            <div class="flex justify-center items-center space-x-3">
                                <a href="{{route('operator.books.chapters.edit', [$chapter->book, $chapter])}}">
                                    <i class="bx bx-pencil text-green-600"></i>
                                </a>
                                <span class="text-slate-400">|</span>
                                <form action="{{route('operator.books.chapters.destroy',[$book,$chapter])}}" method="POST" onsubmit="return confirmDel(event)">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="bg-transparent p-0 border-0" @disabled($chapter->questions->count())>
                                        <i class="bx bx-trash text-red-600"></i>
                                    </button>
                                </form>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
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