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
            <a href="{{route('admin.course.chapters.index',$topic->chapter->course)}}">Course</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.topic.questions.index',$topic)}}">Qs</a>
            <i class="bx bx-chevron-right"></i>
            <div>Edit Q.</div>
        </div>

        <div class="divider my-1"></div>

        <div class="md:w-3/4 mx-auto mt-8">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif


            <div class="flex items-center justify-between bg-gradient-to-r from-teal-100 to-teal-50 rounded p-4 mt-8">
                <div>
                    <h2>{{ $topic->chapter->sr }}. {{ $topic->chapter->title }}</h2>
                    <p class="pl-5">{{ $topic->chapter->sr}}.{{ $topic->sr}} {{ $topic->name }}</p>
                </div>
                <a href="{{ route('admin.topic.questions.index', $topic) }}" class="w-12 h-12 bg-teal-200 flex items-center justify-center rounded-full">
                    <i class="bi-x-lg"></i>
                </a>
            </div>


            <form action="{{route('admin.topic.questions.update', [$topic, $question])}}" method='post' enctype="multipart/form-data" class="mt-6">
                @csrf
                @method('patch')
                <div class="grid items-center gap-6 w-full">
                    <div class="md:w-1/2">
                        <label for="">Question Type</label>
                        @if($question->type_id==1)
                        <h2>{{ $question->type->name }}</h2>
                        <input type="text" name="type_id" value="{{ $question->type_id }}" hidden>
                        @else
                        <select name='type_id' id="type_id" class="custom-input-borderless" onchange="hideOrShowQuestionOptions()" required>
                            <option value="">Select question type</option>
                            @foreach($types->sortBy('sr') as $type)
                            <option value="{{ $type->id }}" @selected($type->id==$question->type_id)>{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                    <div class="w-1/2">
                        <label for="">Difficulty Level</label>
                        <select name="difficulty_level" class="custom-input-borderless">
                            <option value="1" @selected($question->difficulty_level==1)>Low</option>
                            <option value="2" @selected($question->difficulty_level==2)>High</option>
                            <option value="3" @selected($question->difficulty_level==3)>Very High</option>
                        </select>
                    </div>

                    <div class="">
                        <label for="">Question Statement</label>
                        <textarea type="text" id='statement' name="statement" class="custom-input py-2 mt-2" rows='2' placeholder="Type here">{{ $question->statement }}</textarea>
                    </div>

                    <!-- preview -->
                    <div class="border p-6">
                        <span id="math" class="text-left text-slate-400">Preview</span>
                    </div>

                    <!-- MCQs -->
                    @if($question->mcq)
                    <div id='mcq'>
                        <label for="">Choices</label>
                        <div class="grid gap-4 mt-2">
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name='check_a' class="correct w-4 h-4" value='1' @checked($question->mcq->correct=='a')>
                                <input type="text" name='choice_a' class="custom-input-borderless choice md:w-1/2" placeholder="a." value="{{ $question->mcq->choice_a }}">
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name='check_b' class="correct w-4 h-4" value='1' @checked($question->mcq->correct=='b')>
                                <input type="text" name='choice_b' class="custom-input-borderless choice md:w-1/2" placeholder="b." value="{{ $question->mcq->choice_b }}">
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name='check_c' class="correct w-4 h-4" value='1' @checked($question->mcq->correct=='c')>
                                <input type="text" name='choice_c' class="custom-input-borderless choice md:w-1/2" placeholder="c." value="{{ $question->mcq->choice_c }}">
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name='check_d' class="correct w-4 h-4" value='1' @checked($question->mcq->correct=='d')>
                                <input type="text" name='choice_d' class="custom-input-borderless choice md:w-1/2" placeholder="d." value="{{ $question->mcq->choice_d }}">
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="">
                        <label for="">Answer.</label>
                        <textarea type="text" id='answer' name="answer" class="custom-input py-2 mt-2" rows='3' placeholder="Type here">{{ $question->answer }}</textarea>
                    </div>
                    <div class="grid md:grid-cols-2 place-items-center">
                        <div>
                            <label for="">Image</label>
                            <img src="{{ asset('images/uploads/'.$question->image) }}" alt="">
                        </div>
                        <div>
                            <div>
                                <label for="" class="mt-6">Replacing Image</label>
                                <input type="file" id='pic' name='image' placeholder="Image" class='custom-input py-2' onchange='preview_pic()' accept="image/*">
                            </div>

                            <div class="flex flex-col justify-center items-center">
                                <img src="{{asset('images/no-image.png')}}" alt="" id='preview_img' class="w-60">
                            </div>
                        </div>
                    </div>


                    <div class="text-right">
                        <button type="submit" class="btn btn-green rounded">Update Now</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!-- simpla js -->
    <script>
        function preview_pic() {
            const [file] = pic.files
            if (file) {
                preview_img.src = URL.createObjectURL(file)
            }
        }
    </script>
</div>
@endsection

@section('script')
<script type="module">
    $(document).ready(function() {

        $('#statement').bind('input propertychange', function() {
            $('#math').html($('#statement').val());
            MathJax.typeset();
        });
        $('#answer').bind('input propertychange', function() {
            $('#math').html($('#answer').val());
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

            if ($(this).val() == 1)
                $('#mcq').show();
            else
                $('#mcq').hide();

        });
    });
</script>
@endsection