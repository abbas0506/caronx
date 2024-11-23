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
            <div>Pacakges</div>
        </div>


        <div class="flex flex-wrap items-center gap-3 text-slate-600 mt-6">
            <a href="{{ route('admin.subjects.index') }}" class="tab">Subjects</a>
            <a href="{{ route('admin.grades.index') }}" class="tab">Grades & Books</a>
            <a href="{{ route('admin.types.index') }}" class="tab">Q. Types</a>
            <a href="{{ route('admin.tags.index') }}" class="tab">Chapter Tags</a>
            <p class="tab active">Packages</p>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <!-- fixed button for new grade -->
        <a href="{{route('admin.packages.create')}}" class="fixed bottom-6 right-6 btn btn-green w-14 h-14 flex justify-center items-center rounded-full text-sm">New</a>

        <div class="overflow-x-auto w-full mt-6">
            <div class="flex items-center">
                <h3 class="text-green-600 bg-green-100 px-3 py-1 rounded-full">Packages <i class="bi-box"></i></h3>
            </div>
            <table class="table-fixed w-full sm mt-6">
                <thead>
                    <tr>
                        <th class="w-16">Sr</th>
                        <th class="w-48">Pacakge Name</th>
                        <th class="w-16">Coins</th>
                        <th class="w-16">Price</th>
                        <th class="w-24">Validity</th>
                        <th class="w-16">Actions</th>
                    </tr>
                <tbody>
                    @php $sr=1; @endphp
                    @foreach($packages as $package)
                    <tr class="text-sm tr">
                        <td>{{$sr++}}</td>
                        <td>{{ $package->name }}</td>
                        <td>{{ $package->coins }}</td>
                        <td>{{ $package->price}}</td>
                        <td>{{ $package->duration }} days</td>
                        <td>
                            <div class="flex justify-center items-center space-x-2">
                                <a href="{{route('admin.packages.edit', $package)}}" class="flex justify-center text-teal-600"><i class="bx bx-pencil"></i></a>
                                <form action="{{route('admin.packages.destroy',$package)}}" method="POST" onsubmit="return confirmDel(event)">
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