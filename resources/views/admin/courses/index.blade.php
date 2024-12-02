@extends('layouts.basic')

@section('header')
<x-headers.user page="Q.Bank" icon="<i class='bi bi-question-circle'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='books'></x-sidebars.admin>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb">
                <a href="{{ url('/') }}">Home</a>
                <div>/</div>
                <div>Q.Bank</div>
                <div>/</div>
                <div>Books</div>
            </div>
        </div>
        <div class="md:w-4/5 mx-auto">
            <h3 class="text-lg mt-8 text-center">Courses</h3>
            <p class="text-slate-600 leading-relaxed mt-6 text-center text-sm">Here is the most recent list of available books. If you dont see any book here, create new</p>
            <div class="h-1 w-24 bg-teal-800 mx-auto mt-6"></div>
            <div class="text-center mt-6">
                <a href="{{ route('admin.courses.create') }}" class="text-xs px-4 py-2 btn btn-blue rounded-full">Create Course</a>
            </div>

            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <div class="grid mt-6 md:w-2/3 mx-auto gap-2">
                @foreach($courses as $course)
                <div class="p-4 rounded bg-slate-100  relative">
                    <a href="{{ route('admin.course.chapters.index', $course) }}" class="link">{{ $course->name }} <span class="text-slate-400 text-xs">({{ $course->questions()->count() }})</span></a>
                    <div class="absolute top-2 -right-6">
                        <a href="{{route('admin.courses.edit', $course)}}" class="text-green-600">
                            <i class="bx bx-pencil"></i>
                        </a>
                        <form action="{{route('admin.courses.destroy',$course)}}" method="POST" onsubmit="return confirmDel(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-transparent p-0 border-0">
                                <i class="bx bx-trash text-red-600"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

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