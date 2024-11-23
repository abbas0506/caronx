@extends('layouts.basic')
@section('header')
<x-headers.user page="Questions" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.collaborator page='questions'></x-sidebars.collaborator>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('collaborator.grades.index')}}">Grades</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('collaborator.grade.chapters.index', $chapter->course->grade)}}">Chapters</a>
            <i class="bx bx-chevron-right"></i>
            <div>Questions</div>

        </div>


        <div class="md:w-4/5 mx-auto mt-4">
            <!-- mid panel  -->
            <div class="flex flex-wrap justify-between items-center py-4 border-b border-slate-400 border-dashed">
                <div>
                    <h2 class="text-teal-600">{{ $chapter->course->name }}</h2>
                    <label>Ch # {{ $chapter->sr }}. {{ $chapter->title }}</label>
                </div>
                <div class="flex">
                    <img src="{{ url('images/small/payment.png') }}" alt="wallet" class="w-8 h-8">
                    <p class="text-sm">{{ Auth::user()->coins() }}</p>
                </div>
            </div>

            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <!-- search -->
            <div class="flex flex-wrap justify-between items-center">
                <div class="flex items-center gap-3 my-3">
                    <p class="tab active" data-bound='div-waiting4'>Waiting for</p>
                    <p class="tab" data-bound='div-approved'>Approved ({{ $chapter->questions()->approved()->count() }})</p>
                </div>
                <div class="md:w-1/3 relative">
                    <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
                    <i class="bx bx-search absolute top-2 right-2"></i>
                </div>
            </div>
            <!-- waiting for approval -->
            <div class="overflow-x-auto fold" id='div-waiting4'>
                <table class="table-fixed borderless w-full mt-3">
                    <thead>
                        <tr class="tr">
                            <th class="w-8">Sr</th>
                            <th class="w-48">Question</th>
                            <th class="w-20">Type</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($chapter->questions()->notApproved()->get()->sortBy('type_id') as $question)
                        <tr class="tr">
                            <td>{{ $loop->index+1 }}</td>
                            <td class="text-left"><a href="{{ route('collaborator.chapter.questions.edit',[$chapter,$question]) }}" class="link">{{ $question->statement }}</a></td>
                            <td>{{ $question->type->name }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <!-- Approved questions -->
            <!-- waiting for approval -->
            <div class="overflow-x-auto hidden fold" id='div-approved'>
                <table class="table-fixed borderless w-full mt-3">
                    <thead>
                        <tr class="tr">
                            <th class="w-8">Sr</th>
                            <th class="w-48">Question</th>
                            <th class="w-20">Type</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($chapter->questions()->approved()->get()->sortByDesc('updated_at') as $question)
                        <tr class="tr">
                            <td>{{ $loop->index+1 }}</td>
                            <td class="text-left"><a href="{{ route('collaborator.chapter.questions.edit',[$chapter,$question]) }}" class="link">{{ $question->statement }}</a></td>
                            <td>{{ $question->type->name }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
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

@section('script')
<script type="module">
    $('.tab').click(function() {
        $('.tab').removeClass('active')
        $(this).addClass('active');
        $('.fold').hide();
        $('#' + $(this).attr('data-bound')).show()

    });
</script>
@endsection