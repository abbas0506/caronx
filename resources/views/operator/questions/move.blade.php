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
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('operator.books.index')}}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('operator.books.chapters.index', $chapter->book)}}">Chapters</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('operator.chapter.questions.index', $chapter)}}">Questions</a>
            <i class="bx bx-chevron-right"></i>
            <div>Move</div>

        </div>

        <div class="grid gap-6">
            <!-- mid panel  -->
            <div class="flex flex-wrap items-center justify-between p-4 border rounded-lg bg-green-100 border-green-200">
                <div>
                    <h2>{{ $chapter->book->name }}</h2>
                    <label>Ch # {{ $chapter->sr }}. {{ $chapter->title }}</label>
                </div>

                <a href="{{route('operator.chapter.questions.index', $chapter)}}" class="btn btn-orange rounded">Back</a>

            </div>

            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif



            <div class="overflow-x-auto md:w-4/5 mx-auto">
                <!-- search -->
                <div class="md:w-1/3 relative">
                    <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
                    <i class="bx bx-search absolute top-2 right-2"></i>
                </div>

                <div class="flex items-center space-x-2 my-4 pl-2">
                    <input type="checkbox" id='check_all' class="custom-input w-4 h-4 rounded">
                    <p class="text-red-600">Select All</p>
                </div>

                <form action="{{route('operator.question-movements.update', $chapter)}}" method='post' class="" onsubmit="return validate(event)">
                    @csrf
                    @method('PATCH')

                    <table class="table-fixed w-full">
                        <thead>
                            <tr>
                                <th class="w-4"></th>
                                <th class="w-8">Sr</th>
                                <th class="w-64">Question</th>
                                <th class="w-16">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chapter->questions->sortBy('type_id') as $question)
                            <tr class="tr checkable-row">
                                <td>
                                    <input type="checkbox" id='question{{$question->id}}' name='question_ids_array[]' class="custom-input w-4 h-4 rounded hidden" value="{{ $question->id }}">
                                    <i class="bx bx-check"></i>
                                </td>
                                <td>{{ $loop->index+1 }}</td>
                                <td class="text-left">{{ $question->statement }}</td>
                                <td>{{ $question->type->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-6 md:w-1/3">
                        <label for="">Move to Chapter #</label>
                        <input type="number" name='chapter_id_to_move' class="custom-input-borderless" value="{{ $chapter->id }}">
                    </div>

                    <div class="divider my-5"></div>
                    <div class="flex justify-end my-5">
                        <button type="submit" class="btn btn-teal rounded py-2 px-4" @disabled($chapter->questions->count()==0)>Next <i class="bi-arrow-right"></i></button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        var str = 0;
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(3).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>

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
                if (!$(this).parents('.checkable-row').hasClass('hidden')) {
                    $(this).prop('checked', true)
                    $(this).parents('.checkable-row').addClass('active')
                }
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