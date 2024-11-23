@extends('layouts.basic')
@section('title', 'Services')
@section('header')
<x-header></x-header>
@endsection

@section('body')
<div class="flex flex-col justify-center items-center w-screen px-5 md:px-24">
    <div class="text-center mt-32">
        <h1 class="text-3xl">SERVICES</h1>
        <p class="text-slate-600 mt-6 leading-relaxed md:w-2/3 mx-auto">This is an integrated application that provides
            all in one solution for examining students and tracking their performance through statistical as well as
            graphical analysis</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16">
        <div class="feature-box border-green-300 bg-green-50 relative" data-aos="fade-up" data-aos-duration="1500">
            <!-- <div class="flex items-center justify-center bg-pink-100 rounded-full w-16 h-16">
                                                <i class="bi-book text-2xl text-pink-400"></i>
                                            </div> -->
            <h3 class="text-lg">Self Testing</h3>
            <p class="text-sm text-center mt-2">Fully customized MCQs test from selected chapters and instant score</p>
            <a href="{{ route('self-tests.index') }}" class="text-sm rounded-full mt-4 btn btn-green">Start Now</a>
        </div>

        <div class="feature-box border-orange-300 bg-orange-50" data-aos="fade-up" data-aos-duration="1500">
            <!-- <div class="flex items-center justify-center bg-orange-100 rounded-full w-16 h-16">
                                                <i class="bi-laptop text-2xl text-orange-400"></i>
                                            </div> -->
            <h3 class="text-lg">Paper Generation</h3>
            <p class="text-sm text-center mt-2">Highly flexible paper generation saves your time, effort and printing
                cost.</p>
            <a href="{{ route('papers.index') }}" class="text-sm rounded-full mt-4 btn btn-orange">Go Free</a>
        </div>

        <div class="feature-box border-cyan-200 bg-cyan-50" data-aos="fade-up" data-aos-duration="1500">
            <!-- <div class="flex items-center justify-center bg-cyan-100 rounded-full w-16 h-16">
                                                <i class="bi bi-palette text-2xl text-cyan-400"></i>
                                            </div> -->
            <h3 class="text-lg">Performance Analysis</h3>
            <p class="text-sm text-center mt-2">State of the art visual analysis of your students' academic performance
            </p>
            <!-- <a href="" class="text-sm rounded-full mt-4 bg-black py-1 px-3 text-teal-300">Get Started</a> -->
            <a href="" class="text-sm rounded-full mt-4 btn btn-cyan">Get Started</a>
        </div>

    </div>

</div>

</section>
@endsection