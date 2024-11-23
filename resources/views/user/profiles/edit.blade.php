@extends('layouts.basic')

@section('header')
<x-headers.user page="Profile" icon="<i class='bx bx-user-circle'></i>"></x-headers.user>
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
                <div>Profile</div>
                <div>/</div>
                <div>Edit</div>
            </div>
        </div>


        <div class="content-section rounded-lg mt-12 w-full md:w-3/4 mx-auto">
            <!-- page message -->
            @if ($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <form action="{{route('user.profiles.update', $user)}}" method='post' class="grid gap-4">
                @csrf
                @method('PATCH')
                <div>
                    <label>Name</label>
                    <p>{{ $user->name }}</p>
                </div>

                <div>
                    <label>Email</label>
                    <p>{{ $user->email }}</p>
                </div>


                <div>
                    <label for="">Institution</label>
                    <input type="text" name="institution" value="{{ $user->profile?->institution}}" class="custom-input-borderless" placeholder="Instution name">
                </div>
                <div>
                    <label for="">Subject</label>
                    <select name="subject_id" id="" class="custom-input-borderless">
                        <option value="">(blank)</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" @selected($user->profile?->subject_id==$subject->id)>{{ $subject->name_en }}</option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label for="">Phone</label>
                    <input type="text" name="phone" value="{{ $user->profile?->phone}}" class="custom-input-borderless" placeholder="Phone">
                </div>
                <div class="mt-8">
                    <button type="submit" class="btn btn-teal">Update Now</button>
                </div>

            </form>

        </div>
        @endsection

        @section('script')
        <script type="module">
            $('document').ready(function() {

                $('.confirm-del').click(function(event) {
                    var form = $(this).closest("form");
                    // var name = $(this).data("name");
                    event.preventDefault();
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
                            //submit corresponding form
                            form.submit();
                        }
                    });
                });

            });
        </script>
        @endsection