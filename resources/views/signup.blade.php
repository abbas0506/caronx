@extends('layouts.basic')
@section('title', 'Signup')
@section('body')

<div class="grid grid-cols-1 md:grid-cols-2 md:h-screen place-items-center bg-white p-5">

    <div><img src="{{ url('images/small/signup.png') }}" alt="signup" class=""></div>
    <div class="grid place-items-center w-full md:w-1/2 mx-auto">

        <h2 class="text-4xl font-bold">NEW USER</h2>
        <label for="">https://www.exampixel.com</label>

        <form action="{{ route('signup.store') }}" method="post" class="w-full mt-8">
            @csrf

            <!-- page message -->
            @if ($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif


            <div class="grid gap-2">
                <div class="flex items-center w-full relative">
                    <i class="bi bi-person absolute left-2 text-slate-600"></i>
                    <input type="text" id="name" name="name" class="w-full custom-input px-8"
                        placeholder="Your name">
                </div>
                <div class="flex items-center w-full relative">
                    <i class="bi bi-at absolute left-2 text-slate-600"></i>
                    <input type="text" id="email" name="email" class="w-full custom-input px-8"
                        placeholder="Email address">
                </div>
                <div>
                    <label for="" class="text-red-600">{{$numA}} + {{$numB}} = ?</label>
                    <input type="text" name="secret_code" class="custom-input" placeholder="Your answer">
                    <input type="hidden" name="num_a" value="{{ $numA }}">
                    <input type="hidden" name="num_b" value="{{ $numB }}">

                </div>

                <button type="submit" class="w-full mt-6 btn btn-teal p-2">Sign Up</button>
            </div>

        </form>
        <div class="text-center text-sm mt-3">
            I have an account?<a href="{{ url('login') }}" class="font-bold ml-2 link">Login</a>
        </div>
    </div>
</div>




@endsection

@section('script')
<script type="module">
    $(document).ready(function() {
        $('.bi-eye-slash').click(function() {
            $('#password').prop({
                type: "text"
            });
            $('.eye-slash').hide()
            $('.eye').show();
        })
        $('.bi-eye').click(function() {
            $('#password').prop({
                type: "password"
            });
            $('.eye-slash').show()
            $('.eye').hide();
        })

    });
</script>

@endsection