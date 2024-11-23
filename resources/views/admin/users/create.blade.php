@extends('layouts.basic')

@section('header')
<x-headers.user page="Users" icon="<i class='bi bi-person-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='users'></x-sidebars.admin>
@endsection

@section('page-content')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('admin')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.users.index')}}">Users</a>
            <i class="bx bx-chevron-right"></i>
            <div>Create</div>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif
        <div class="p-8 bg-white">
            <form action="{{route('admin.users.store')}}" method='post' class="">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <h2 class="md:col-span-2 text-green-600">New User <i class="bi-person-add"></i></h2>
                    <div class="md:col-span-2">
                        <label for="">User Name</label>
                        <input type="text" id='' name='name' class="custom-input-borderless" placeholder="User name" value="">
                    </div>

                    <div>
                        <label for="">Email</label>
                        <input type="text" id='' name='email' class="custom-input-borderless" placeholder="User email" value="">
                    </div>
                    <div>
                        <label for="">Phone</label>
                        <input type="text" id='' name='phone' class="custom-input-borderless" placeholder="Contact number" value="">
                    </div>
                    <div>
                        <label for="">Subject</label>
                        <select id='' name='subject_id' class="custom-input-borderless">
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name_en }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h2 class="md:col-span-2">Role(s)</h2>
                    <div class="grid gap-2">
                        @foreach($roles as $role)
                        <div class="flex checkable-row">
                            <label for="role{{$role->id}}" class="text-base hover:cursor-pointer text-slate-800 text-left py-1 flex-1">{{ ucfirst($role->name) }}</label>
                            <input type="checkbox" id='role{{$role->id}}' name='role_names_array[]' class="custom-input w-4 h-4 rounded" value="{{$role->name}}" @checked($loop->last)>
                            <i class="bx bx-check"></i>
                        </div>
                        @endforeach
                    </div>

                    <div class="md:col-span-2 text-right">
                        <button type="submit" class="btn btn-green rounded">Create User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="module">
    $('.checkable-row input').change(function() {
        if ($(this).prop('checked'))
            $(this).parents('.checkable-row').addClass('active')
        else
            $(this).parents('.checkable-row').removeClass('active')
    })

    $('#check_all').change(function() {
        if ($(this).prop('checked')) {
            $('.checkable-row input').each(function() {
                $(this).prop('checked', true)
                $(this).parents('.checkable-row').addClass('active')
            })
        } else {
            $('.checkable-row input').each(function() {
                $(this).prop('checked', false)
                $(this).parents('.checkable-row').removeClass('active')
            })
        }
    })
</script>
@endsection