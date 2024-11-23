@extends('layouts.basic')
@section('header')
<x-headers.user page="Q. Bank" icon="<i class='bi bi-question-circle'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='books'></x-sidebars.admin>
@endsection

@section('body')

<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.books.index',)}}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <div>Chapters</div>
        </div>

        <!-- <div class="p-4 border rounded-lg bg-green-100 border-green-200 mt-6"> -->
        <div class="flex flex-wrap gap-4 bg-orange-50 justify-between items-center p-4">
            <h2 class="text-green-600">{{ $book->name }}</h2>
            <a href="{{ route('admin.book.chapters.create', $book) }}" class="btn btn-green rounded text-sm">Add Chapter</a>
        </div>
        <!-- </div> -->

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="text-sm">
            @foreach($book->chapters->sortBy('sr') as $chapter)
            <div class="flex items-center odd:bg-slate-100 space-x-3">
                <a href="{{route('admin.chapter.questions.index', $chapter)}}" class="flex flex-1 items-center justify-between p-3 space-x-2">
                    <div class="flex-1">{{ $chapter->sr}}. &nbsp {{ $chapter->title }}</div>
                    <div class="text-xs">
                        @if($chapter->questions()->today()->count()>0)
                        {{ $chapter->questions()->today()->count() }}<i class="bi-arrow-up"></i>
                        @endif
                    </div>
                    <div class="text-xs">
                        {{ $chapter->questions()->mcqs()->count() }}+{{ $chapter->questions()->shorts()->count() }}+{{ $chapter->questions()->longs()->count() }} <i class="bi-question-circle"></i>
                    </div>
                </a>
                <div class="flex items-center space-x-3 p-2 rounded">
                    <a href="{{route('admin.book.chapters.edit', [$chapter->book, $chapter])}}" class="text-green-600">
                        <i class="bx bx-pencil"></i>
                    </a>
                    <form action="{{route('admin.book.chapters.destroy',[$book,$chapter])}}" method="POST" onsubmit="return confirmDel(event)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-transparent p-0 border-0" @disabled($chapter->questions()->count())>
                            <i class="bx bx-trash text-red-600"></i>
                        </button>
                    </form>
                </div>
            </div>
            <ul class="pl-16">
                @foreach($chapter->topics->sortBy('sr') as $topic)
                <li><a href="">{{ $topic->name }}</a></li>
                @endforeach
                <li><a href="{{ route('admin.chapter.topics.create', $chapter) }}" class="link">Add New Topic</a></li>
            </ul>
            @endforeach


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