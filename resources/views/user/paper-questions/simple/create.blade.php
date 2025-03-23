@extends('layouts.basic')

@section('header')
<x-headers.user page="New Paper" icon="<i class='bi bi-file-earmark-text'></i>"></x-headers.user>
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
                <a href="{{ route('user.papers.show', $paper) }}">Paper</a>
                <div>/</div>
                <div>Add Q.</div>
            </div>
        </div>


        <div class="content-section mt-6">
            <div class="flex items-center justify-between flex-wrap  gap-2">
                <div class="flex flex-row items-center gap-3">
                    <img src="{{ url('images/icons/pdf.png') }}" alt="paper" class="w-12">
                    <div class="flex flex-col">
                        <h2>{{ $paper->course->name }} </h2>
                        <div class="flex items-center space-x-3">
                            <label>{{ $paper->title }}</label>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-slate-500 text-sm text-center md:text-right md:pr-5">Step 3.2/4</p>
                </div>
            </div>
            <div class="divider my-3"></div>
            <div class="grid gap-6 md:w-3/4 mx-auto  mt-6">
                <h2 class="text-xl">{{ $type->name }}</h2>
                <form id='data-form' action="{{ route('user.paper.question-type.simple-questions.store', [$paper, $type]) }}" method="post">
                    @csrf

                    <input type="hidden" name="chapter_id" id='chapter_id' value="">
                    <input type="text" id='simple' name="type_name" value="simple" hidden>
                    <div class="grid md:grid-cols-3 gap-6 items-center">
                        <div class="">
                            <label>Importance Level</label>
                            <select name="frequency" id="" class="custom-input-borderless text-sm py-1">
                                <option value="1">Normal</option>
                                <option value="2">High</option>
                                <option value="3">Very High</option>
                            </select>
                        </div>

                        <div class="">
                            <label>Marks</label>
                            <input type="number" name="marks" class="custom-input-borderless" min=1 max=100 value="5">
                        </div>
                    </div>

                    <div class="mt-6"></div>
                    <div>
                        <label for="">Question Title</label>
                        <input type="text" name="question_title" value="{{ $type->default_title }}" class="custom-input-borderless" placeholder="Question title here if any">
                    </div>


                </form>

                <!-- Chapters List -->
                <div class="flex flex-col gap-2">
                    <p class="relative p-2 bg-gradient-to-r from-teal-300 to-teal-100 text-sm">Please specify the chapter from which you'd like to add question.</p>
                    @foreach($chapters->sortBy('sr') as $chapter)
                    <!-- <div data-val='{{$chapter->id}}' class="manual-form-submition text-sm even:bg-slate-100  text-slate-800 p-3 hover:cursor-pointer w-full text-left">{{ $chapter->sr}}. &nbsp {{ $chapter->title }} </div> -->
                    <div data-val='{{$chapter->id}}' class="manual-form-submition text-sm bg-slate-100 hover:bg-slate-200 border rounded-md  text-slate-800 p-3 hover:cursor-pointer w-full text-left">{{ $chapter->sr}}. &nbsp {{ $chapter->title }} </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('script')
    <script type="module">
        $(document).ready(function() {

            $('.manual-form-submition').click(function() {
                $('#chapter_id').val($(this).attr('data-val'))
                $('form').submit();
            })

        });
    </script>
    @endsection