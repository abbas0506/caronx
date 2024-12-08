@extends('layouts.basic')
@section('header')
<x-headers.user page="Q. Bank" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
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
            <a href="{{route('admin.course.chapters.index',$topic->chapter->course)}}">Courses</a>
            <i class="bx bx-chevron-right"></i>
            <div>Qs</div>
        </div>

        <div class="bg-gradient-to-r from-teal-100 to-teal-50 rounded p-4 mt-8">
            <h2>{{ $topic->chapter->sr }}. {{ $topic->chapter->title }}</h2>
            <p class="pl-5 mt-3">{{ $topic->chapter->sr}}.{{ $topic->sr}} {{ $topic->name }} <span class="text-sm ml-4"><i class="bi-arrow-up"></i>{{ $topic->questions()->today()->count() }}</span> </p>
        </div>
        <!-- search -->
        <div class="flex flex-wrap items-center justify-between p-4">
            <div class="relative md:w-1/3 my-4">
                <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
                <i class="bx bx-search absolute top-2 right-2"></i>
            </div>

            <div class="flex items-center flex-wrap justify-between gap-x-6">
                <!-- search -->
                <a href="{{route('admin.topic.questions.create',$topic)}}" class="btn btn-teal rounded-md">New Q.</a>
            </div>
        </div>
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        @php $sr=1; @endphp

        <div class="overflow-x-auto">
            <table class="table-fixed borderless w-full mt-3">
                <thead>
                    <tr class="tr">
                        <th class="w-8">Sr</th>
                        <th class="w-64">Question</th>
                        <th class="w-16">Type</th>
                        <th class="w-16">Difficulty</th>
                        <th class="w-32">Figure</th>
                        <th class="w-12">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($topic->questions->sortByDesc('updated_at') as $question)
                    <tr class="tr">
                        <td>{{$sr++}}</td>
                        <td class="text-left">
                            <a href="{{ route('admin.topic.questions.show',[$topic,$question]) }}" class="link">{{ $question->statement }}</a>
                            @if($question->mcq)
                            <ul class="grid md:grid-cols-4 gap-2">
                                <li @if($question->mcq?->correct=='a') class='font-bold'@endif>a) {{ $question->mcq?->choice_a  }}</li>
                                <li @if($question->mcq?->correct=='b') class='font-bold'@endif>b) {{ $question->mcq?->choice_b  }}</li>
                                <li @if($question->mcq?->correct=='c') class='font-bold'@endif>c) {{ $question->mcq?->choice_c  }}</li>
                                <li @if($question->mcq?->correct=='d') class='font-bold'@endif>d) {{ $question->mcq?->choice_d  }}</li>
                            </ul>
                            @endif
                            <p>Ans. {{ $question->answer }}</p>
                        </td>
                        <td>{{ $question->type->name }}</td>
                        <td>{{ $question->difficulty_level==1?'Low':($question->difficulty_level==2? 'High':'Very High') }}</td>
                        <td><img src="{{ asset('/images/thumbnails/'.$question->image) }}" alt="" class="mx-auto"></td>
                        <td>
                            <div class="flex justify-center items-center space-x-2">
                                <a href="{{route('admin.topic.questions.edit', [$topic, $question])}}">
                                    <i class="bx bx-pencil text-green-600"></i>
                                </a>
                                <form action="{{route('admin.topic.questions.destroy', [$topic, $question])}}" method="POST" onsubmit="return confirmDel(event)">
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