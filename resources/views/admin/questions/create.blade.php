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
            <div>Create Q.</div>
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
                    <p class="pl-5 mt-1">{{ $topic->chapter->sr}}.{{ $topic->sr}} {{ $topic->name }} <span class="text-sm ml-4"><i class="bi-arrow-up"></i>{{ $topic->questions()->today()->count() }}</span></p>
                </div>
                <a href="{{ route('admin.topic.questions.index', $topic) }}" class="w-12 h-12 bg-teal-200 flex items-center justify-center rounded-full">
                    <i class="bi-x-lg"></i>
                </a>
            </div>

            <form action="{{route('admin.topic.questions.store', $topic)}}" method='post' class="mt-6" enctype="multipart/form-data">
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
                    <div class="w-1/2">
                        <label for="">Difficulty Level</label>
                        <select name="difficulty_level" class="custom-input-borderless">
                            <option value="1">Low</option>
                            <option value="2">High</option>
                            <option value="3">Very High</option>
                        </select>
                    </div>
                    <div class="">
                        <label for="">Question Statement</label>
                        <textarea type="text" id='statement' name="statement" class="custom-input py-2 mt-2" rows='2' placeholder="Type here"></textarea>
                    </div>

                    <!-- preview -->
                    <div class="border p-6">
                        <span id="math" class="text-left text-slate-400">Preview</span>
                    </div>

                    <!-- MCQs -->
                    <div id="mcq" @if(session("type_id")!=1) hidden @endif>
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

                    <div class="">
                        <label for="">Answer.</label>
                        <textarea type="text" id='answer' name="answer" class="custom-input py-2 mt-2" rows='3' placeholder="Type here"></textarea>
                    </div>

                    <div>
                        <label for="" class="mt-6">Image</label>
                        <input type="file" id='pic' name='image' placeholder="Image" class='custom-input py-2' onchange='preview_pic()' accept="image/*">
                    </div>

                    <div class="flex flex-col justify-center items-center">
                        <img src="{{asset('images/no-image.png')}}" alt="" id='preview_img' class="w-60">
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-green rounded">Create Now</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    function preview_pic() {
        const [file] = pic.files
        if (file) {
            preview_img.src = URL.createObjectURL(file)
        }
    }
</script>
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
            // if mcq, show mcq options
            if ($(this).val() == 1)
                $('#mcq').show();
            else
                $('#mcq').hide();
        });
    });
</script>
@endsection