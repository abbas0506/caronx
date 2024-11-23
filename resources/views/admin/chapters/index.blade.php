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
            <div>TOI</div>
        </div>


        <div class="text-sm md:w-4/5 mx-auto mt-6">

            <h2 class="bg-gradient-to-r from-teal-100 to-teal-50 p-4 my-8 rounded"><i class="bi-book"></i> &nbsp{{ $book->name }}</h2>

            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            @foreach($book->chapters->sortBy('sr') as $chapter)
            <div class="flex items-center odd:bg-slate-100 space-x-3">
                <a href="#" class="flex flex-1 items-center justify-between p-3 space-x-2">
                    <div class="flex-1">{{ $chapter->sr}}. &nbsp {{ $chapter->title }}</div>
                    <div class="text-xs">
                        @if($chapter->questions()->today()->count()>0)
                        {{ $chapter->questions()->today()->count() }}<i class="bi-arrow-up"></i>
                        @endif
                    </div>
                    <div class="text-xs text-slate-400">({{ $chapter->questions->count() }})</div>
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
            <div class="px-8 leading-relaxed">
                @foreach($chapter->topics->sortBy('sr') as $topic)
                <div class="flex items-center gap-x-2">
                    <div class="w-16">{{ $chapter->sr }}.{{ $topic->sr }}</div>
                    <a href="{{ route('admin.topic.questions.index', $topic) }}" class="link flex-1">{{ $topic->name }}</a>
                    <div class="text-slate-400 text-xs">({{ $topic->questions->count() }})</div>
                    <div class="flex items-center space-x-2">
                        <a href="{{route('admin.chapter.topics.edit', [$chapter, $topic])}}" class="text-green-600">
                            <i class="bx bx-pencil"></i>
                        </a>
                        <form action="{{route('admin.chapter.topics.destroy',[$chapter,$topic])}}" method="POST" onsubmit="return confirmDel(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-transparent p-0 border-0" @disabled($topic->questions()->count())>
                                <i class="bx bx-x text-red-600"></i>
                            </button>
                        </form>
                    </div>

                </div>
                @endforeach
                <div class="flex items-center">
                    <div class="w-16">{{ $chapter->sr }}.{{ $chapter->topics->max('sr')+1 }}</div>
                    <a href="{{ route('admin.chapter.topics.create', $chapter) }}" class="text-slate-400 hover:text-slate-600 hover:cursor-pointer">+ New Topic</a>
                </div>

            </div>
            @endforeach
            <div class="flex items-center bg-slate-100 space-x-3 p-3 mt-1">
                <div class="">{{ $book->chapters->max('sr')+1 }}.</div>
                <a href="{{ route('admin.book.chapters.create', $book) }}" class="text-slate-400 hover:text-slate-600 hover:cursor-pointer">+ New Chapter</a>
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