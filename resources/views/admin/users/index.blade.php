@extends('layouts.basic')

@section('header')
<x-headers.user page="Users" icon="<i class='bi bi-person-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='users'></x-sidebars.admin>
@endsection

@section('body')

<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('admin')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <div>Users</div>
        </div>

        <div class="flex flex-wrap items-center justify-between w-full mt-6">
            <div class="flex flex-wrap items-center gap-3 text-slate-600 text-sm">
                <p class="tab active">All Users ({{ $users->count() }})</p>
                <a href="" class="tab">Collaborators</a>
                <a href="" class="tab">New Requests for Collaboration</a>
            </div>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="container-light overflow-x-auto px-0">
            <div class="flex items-center justify-between mb-4">
                <div class="flex relative w-full md:w-1/3">
                    <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
                    <i class="bx bx-search absolute top-2 right-2"></i>
                </div>
                <!-- <div class=""> -->
                <a href="{{route('admin.users.create')}}" class="fixed w-12 h-12 bottom-4 right-4 rounded-full btn btn-blue flex items-center justify-center"><i class="bi bi-person-add text-xl"></i></a>
                <!-- </div> -->
            </div>
            <table class="table-fixed w-full text-sm">
                <thead>
                    <tr>
                        <th class="w-8">Sr</th>
                        <th class="w-48">User Name</th>
                        <th class="w-12">Papers</th>
                        <th class="w-24">Last Paper</th>
                        <th class="w-48">Role</th>
                        <th class="w-16">Status</th>
                        <th class="w-16">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)

                    <tr class="text-sm tr">
                        <td>{{$user->id}}</td>
                        <td class="text-left px-3">
                            {{$user->name}}
                            <br>
                            {{ $user->email }}
                        </td>
                        <td>{{ $user->papers->count() }}</td>
                        <td><label>{{ optional($user->papers->last())->updated_at?->addHours(5)}}</label>
                        </td>
                        <td class="text-left px-3">
                            <div class="grid divide-x-0">
                                @foreach($user->roles as $role)
                                {{ $role->name }} @if(!$loop->last) | @endif
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <a href="{{route('admin.users.edit', $user)}}" class="flex justify-center">
                                @if($user->is_active)
                                <i class="bi bi-toggle2-on text-teal-600 text-lg"></i>
                                @else
                                <i class="bi bi-toggle2-off text-red-600 text-lg"></i>
                                @endif
                            </a>
                        </td>
                        <td>
                            <div class="flex justify-center items-center space-x-2">
                                <a href="{{route('admin.users.edit', $user)}}" class="flex justify-center text-teal-600"><i class="bx bx-pencil"></i></a>
                                <form action="{{route('admin.users.destroy',$user)}}" method="POST" onsubmit="return confirmDel(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600"><i class="bi bi-trash3 text-xs"></i></button>
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
@endsection

@section('script')
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
</script>
@endsection