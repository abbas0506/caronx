@extends('layouts.basic')
@section('title', 'Signup Success')
@section('body')
<div class="grid h-screen place-items-center bg-white p-5">
    <div class="grid gap-4 w-full md:w-1/2 mx-auto text-center">
        <div><i class="bi-emoji-smile text-6xl text-teal-600"></i></div>
        <h1 class="text-teal-600 text-2xl">Account has been successfully created !</h1>
        <p class="text-lg">Password has been sent to your email. Please, check your <span class="text-red-600 font-semibold underline underline-offset-2">inbox</span> or <span class="text-red-600 underline underline-offset-2 font-semibold">spam</span> folder </p>
        <div class="mt-6">
            <a href="{{ url('login') }}" class="btn btn-teal px-4 py-3 text-sm rounded-lg">Login Now</a>
        </div>
    </div>
</div>
@endsection