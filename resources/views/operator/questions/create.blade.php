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
            <div>New</div>
        </div>

        <div class="divider my-2"></div>

        <div class="md:w-3/4 mx-auto">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <h2>{{ $chapter->book->name }}</h2>
            <label>Ch # {{ $chapter->sr }}. {{ $chapter->title }}</label>



            <form action="{{route('operator.chapter.questions.store', $chapter)}}" method='post' class="mt-6" onsubmit="return validate(event)">
                @csrf
                <div class="grid items-center gap-6 w-full">
                    <div class="md:w-1/2">
                        <label for="">Question Type</label>
                        <select name='type_id' id="type_id" class="custom-input-borderless" onchange="hideOrShowQuestionOptions()" required>
                            <option value="">Select question type</option>
                            @foreach($types->sortBy('sr') as $type)
                            <option value="{{ $type->id }}" @selected($type->id==session('type_id'))>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- add poetry line btn -->
                    <div>
                        <a href="{{ route('operator.chapter.poetry-lines.create', $chapter) }}" class="link text-sm">Click here to add Poetry Q.</a>
                    </div>
                    <div class="">
                        <label for="">Question Statement</label>
                        <textarea type="text" id='statement' name="statement" class="custom-input py-2 mt-2" rows='3' placeholder="Type here"></textarea>
                    </div>

                    <!-- preview -->
                    <div class="border p-6">
                        <span id="math" class="text-left text-slate-400">Preview</span>
                    </div>

                    <!-- MCQs -->
                    <div id="mcq" hidden>
                        <label for="">Choices</label>
                        <div class="grid gap-4 mt-2">
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name='check_a' class="correct w-4 h-4" value='1' checked>
                                <input type="text" name='choice_a' class="custom-input-borderless choice md:w-1/2" placeholder="a.">
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name='check_b' class="correct w-4 h-4" value='1'>
                                <input type="text" name='choice_b' class="custom-input-borderless choice md:w-1/2" placeholder="b.">
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name='check_c' class="correct w-4 h-4" value='1'>
                                <input type="text" name='choice_c' class="custom-input-borderless choice md:w-1/2" placeholder="c.">
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name='check_d' class="correct w-4 h-4" value='1'>
                                <input type="text" name='choice_d' class="custom-input-borderless choice md:w-1/2" placeholder="d.">
                            </div>
                        </div>
                    </div>

                    <!-- Comprehension -->
                    <div id='comprehension' hidden>
                        <label for="">Comprehension Questions</label>
                        <div class="grid gap-4 mt-2">
                            <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Sub Q.">
                            <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Sub Q.">
                            <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Sub Q.">
                            <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Sub Q.">
                            <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Sub Q.">
                            <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Sub Q.">
                        </div>
                    </div>

                    <div class="w-1/4">
                        <label for="">Bise Frequency</label>
                        <input type="number" name="frequency" value="1" min=0 class="custom-input-borderless">
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-green rounded">Create Now</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@section('script')
<script type="module">
    $(document).ready(function() {

        $('#statement').bind('input propertychange', function() {
            $('#math').html($('#statement').val());
            MathJax.typeset();
        });

        $('.choice').bind('input propertychange', function() {
            $('#math').html($(this).val());
            MathJax.typeset();
        });


        $('.correct').change(function() {
            $('.correct').not(this).prop('checked', false);
            $(this).prop('checked', true)
        });

        $('#type_id').change(function() {

            if ($(this).val() == 1 || $(this).val() == 23) {
                //mcq
                $('#mcq').show();
                $('#comprehension').hide()
            } else if ($(this).val() == 19 || $(this).val() == 29) {
                //comprehension
                $('#mcq').hide();
                $('#comprehension').show()
            } else {
                // anyother type: short, long, punctuation etc
                $('#mcq').hide();
                $('#comprehension').hide()
            }

        });
    });
</script>
@endsection