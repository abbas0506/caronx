@extends('layouts.basic')

@section('header')
<x-header></x-header>
@endsection

@section('body')
<section>
    <div class="w-screen h-screen bg-white">
        <div class="p-5 md:w-3/4 mx-auto flex flex-col justify-center items-center text-center h-full">
            <img src="{{ asset('/images/bg/quiz.png') }}" alt="bg" class="w-48 md:w-64 md:mt-16">
            <p class="text-2xl md:text-4xl mt-6 font-medium text-slate-800">Be 21<sup>st</sup> Century <span class="text-teal-600">Student</span> </p>
            <p class="text-slate-600 mt-5 text-sm md:text-xl leading-relaxed font-normal">Unlock the power of true understanding with our platform. Dive beyond surface-level knowledge and master concepts at their core, ensuring long-term success in your studies and beyond</p>
            <div class="flex flex-col md:flex-row items-center justify-center gap-2 mt-8 w-full">
                <!-- <a href="{{ url('login') }}" class="w-64">
                    <button class="btn btn-teal rounded py-3 w-full">Generate Question Paper</button>
                </a> -->
                <a href="{{ route('self-tests.index') }}" class="w-64">
                    <button class="btn-teal rounded p-3 w-full">Start Self-Test</button>
                </a>
            </div>

        </div>

    </div>

</section>

<a href="{{ url('https://wa.me/+923000373004') }}"
    class="flex justify-center items-center text-teal-600 text-4xl fixed right-8 bottom-8"><i
        class="bi-whatsapp"></i></a>
@endsection
@section('footer')
<!-- footer -->
<x-footer></x-footer>
@endsection