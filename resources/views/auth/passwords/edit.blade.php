@extends('layouts.basic')
@section('body')

<div class="grid grid-cols-1 md:grid-cols-2 md:h-screen place-items-center bg-white p-5">
    <div><img src="{{ url('images/icons/key.png') }}" alt="signup" class="md:w-full"></div>
    <div class="grid place-items-center">
        <div class="">
            <!-- <img class="w-36 md:w-40 mx-auto" alt="logo" src="{{asset('images/logo/exampixel-0.png')}}"> -->
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif
            <form action="{{route('passwords.update', Auth::user()->id)}}" method="post" class="grid gap-4 mt-4 w-full mx-auto" onsubmit="return validate(event)">
                @csrf
                @method('PATCH')

                <input type="text" id="current" name="current" class="custom-input-borderless py-1" placeholder="Current password" required>
                <input type="password" id="new" name="new" class="custom-input-borderless py-1" placeholder="New password" required>
                <input type="password" id="confirmpw" class="custom-input-borderless py-1" placeholder="Confirm password" required>

                <div class="flex flex-wrap justify-center gap-4 mt-4">
                    <a href="{{url(session('role'))}}" class="btn btn-blue text-center rounded-sm py-1">Cancel</a>
                    <button type="submit" class="btn btn-red rounded-sm py-1">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script lang="javascript">
    function validate(event) {
        var validated = true;
        if ($('#new').val() != $('#confirmpw').val()) {
            validated = false;
            event.preventDefault();
            Toast.fire({
                icon: 'warning',
                title: 'Confirm password not matched',
            })

        }

        return validated;
    }
</script>
@endsection