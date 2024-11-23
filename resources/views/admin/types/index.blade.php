@extends('layouts.basic')
@section('header')
<x-headers.user page="Config" icon="<i class='bi bi-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='config'></x-sidebars.admin>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.subjects.index')}}">Config</a>
            <i class="bx bx-chevron-right"></i>
            <div>Types</div>
        </div>


        <div class="flex flex-wrap items-center gap-3 text-slate-600 mt-6">
            <a href="{{ route('admin.subjects.index') }}" class="tab">Subjects</a>
            <a href="{{ route('admin.grades.index') }}" class="tab">Grades & Books</a>
            <p class="tab active">Q. Types</p>
            <a href="{{ route('admin.tags.index') }}" class="tab">Chapter Tags</a>
            <a href="{{ route('admin.packages.index') }}" class="tab">Packages</a>
        </div>



        <a href="{{route('admin.types.create')}}" class="fixed bottom-6 right-6 btn btn-green w-10 h-10 flex justify-center items-center rounded-full text-xs">New</a>
        <div class="container-light">

            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <div class="flex items-center">
                <h3 class="text-green-600 bg-green-100 px-3 py-1 rounded-full">Question Types</h3>
            </div>
            <div class="overflow-x-auto w-full mt-6">
                <table class="table-fixed w-full sm">
                    <thead>
                        <tr>
                            <th class="w-8">Sr</th>
                            <th class="w-32">Question Type</th>
                            <th class="w-12">Display Style</th>
                            <th class="w-64">Default Title</th>
                            <th class="w-12">Actions</th>
                        </tr>
                    <tbody>
                        @php $sr=1; @endphp
                        @foreach($types->sortBy('sr') as $type)
                        <tr class="text-sm tr">
                            <td>{{ $type->sr }}</td>
                            <td class="text-left">{{ $type->name }}</td>
                            <td>{{ $type->display_style }}</td>
                            <td class="text-left">{{ $type->default_title }}</td>
                            <td>
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{route('admin.types.edit', $type)}}" class="flex justify-center text-teal-600"><i class="bx bx-pencil"></i></a>
                                    <form action="{{route('admin.types.destroy',$type)}}" method="POST" onsubmit="return confirmDel(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600"><i class="bi bi-trash3 text-xs"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </thead>
                </table>
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