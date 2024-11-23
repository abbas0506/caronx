@extends('layouts.basic')

@section('header')
<x-header></x-header>
@endsection

@section('body')
<section>
    <div class="w-screen h-screen bg-white">
        <div class="p-5 md:w-3/4 mx-auto flex flex-col justify-center items-center text-center h-full">
            <img src="{{ asset('/images/bg/exam-min.png') }}" alt="bg" class="w-36 md:w-48 md:mt-16">
            <p class="text-2xl md:text-4xl mt-6 font-medium text-slate-800">We Make Exams <span class="text-teal-600">Easy</span> </p>
            <p class="text-slate-600 mt-5 text-sm md:text-xl leading-relaxed font-normal">We empower educators and
                students with easy to use and interactive tools that make exams easy for them. We have a vast question
                bank covering all major subjects from grade 9 to 12. </p>
            <div class="flex flex-col md:flex-row items-center justify-center gap-2 mt-8 w-full">
                <a href="{{ url('login') }}" class="w-64">
                    <button class="btn btn-teal rounded py-3 w-full">Generate Question Paper</button>
                </a>
                <a href="{{ route('self-tests.index') }}" class="w-64">
                    <button class="bg-orange-200 hover:bg-orange-300 text-slate-800 rounded p-3 w-full">Start
                        Self-Test</button>
                </a>
            </div>

        </div>

    </div>

</section>

<!-- features section -->
<section id='features' class="mt-12 px-4 md:px-24" data-aos="fade-up" data-aos-duration="1000">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12 md:w-3/4 mx-auto">
        <div class="feature-box hover:border-pink-300 hover:bg-pink-50" data-aos="fade-up" data-aos-duration="1000">
            <div class="flex items-center justify-center bg-pink-100 rounded-full w-16 h-16">
                <i class="bi-mortarboard text-2xl text-pink-400"></i>
            </div>
            <h3 class="mt-3 text-lg">Students</h3>
            <p class="text-sm text-center">Our online self-assessment service helps you prepare for your exams in a very
                short time.</p>
        </div>

        <div class="feature-box hover:border-orange-300 hover:bg-orange-50" data-aos="fade-up" data-aos-duration="1000">
            <div class="flex items-center justify-center bg-orange-100 rounded-full w-16 h-16">
                <i class="bi-person text-2xl text-orange-400"></i>
            </div>
            <h3 class="mt-3 text-lg">Teachers</h3>
            <p class="text-sm text-center">Our custom paper generation service saves your effort, time and printing
                cost.</p>
        </div>
    </div>
</section>

<!-- distinction -->
<section class="mt-24 md:px-24">
    <div class="grid md:grid-cols-2 place-items-center" data-aos="fade-up" data-aos-duration="500">
        <div class="order-2 md:order-1 p-5">
            <h2 class="text-xl md:text-2xl text-center md:text-left">Self Assessment</h2>
            <div class="h-1 mx-auto md:ml-0 w-24 bg-teal-800 mt-3 mb-6"></div>
            <ul class="list-disc list-inside leading-relaxed text-sm md:text-base">
                <li>100% free, No signup required</li>
                <li>Online & fully automated</li>
                <li>Multi-chapter selection</li>
                <li>Instant result on screen </li>
                <li>Mistakes highlights </li>
            </ul>
            <div class="mt-3">
                <a href="{{ route('self-tests.index') }}" class="rounded-full link">Start Now <i
                        class="bi-arrow-right"></i></a>
            </div>

        </div>
        <div class="order-first md:order-2  bg-slate-100 w-full h-full flex justify-center p-5">
            <img src="{{ url('images/small/online-test-min.png') }}" alt="selftest" class="w-60">
        </div>

        <!-- row 2 -->
        <div class="order-4 p-5">
            <h2 class="text-xl md:text-2xl text-center md:text-left">Paper Generation</h2>
            <div class="h-1 mx-auto md:ml-0 w-24 bg-teal-800 mt-3 mb-6"></div>
            <ul class="list-disc list-inside leading-relaxed text-sm md:text-base">
                <li>Fully automated, simple & easy</li>
                <li>Multi chapter selection</li>
                <li>Fully customized</li>
                <li>PDF format</li>
                <li>Font specification, page setting</li>
                <li>Multiple papers per sheet</li>
                <li>Link sharing on whatsapp (soon)</li>
            </ul>
            <div class="mt-3">
                <a href="{{ url('login') }}" class="rounded-full link">Start Now <i class="bi-arrow-right"></i></a>
            </div>

        </div>
        <div class="order-3 bg-teal-100 w-full h-full flex justify-center items-center p-5">
            <img src="{{ url('images/small/pdf-0.png') }}" alt="selftest" class="w-60">
        </div>
    </div>
</section>

<!-- testimonial section -->
<section class="testimonials pt-0">
    <div class="mt-24 px-4 md:px-16 md:w-3/4 mx-auto">
        <h2 class="text-3xl text-center">Our Team</h2>
        <p class="text-gray-600 text-center mt-8">
            Our software development team comprises of highly skilled and dedicated professionals who are 24/7 ready to
            support our clients. We are also in collaboration with supject experts in order to ensure the quality of
            question bank.
        </p>
        <div class="h-1 w-24 bg-teal-800 mx-auto mt-6"></div>
    </div>
    <div class="testimonials-carousel swiper w-full md:w-3/4 mx-auto mt-12">
        <div class="swiper-wrapper">
            <div class="testimonial-item swiper-slide">
                <img src="{{ asset('images/small/developers.png') }}" class="testimonial-img" alt="developers">
                <h3>Developers</h3>
                <h4>Web & Android</h4>
                <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    "We provide both web as well as android solution to our valuable clients. Our teams is contnuously
                    working on this app to make it user-friendly as much as possible and keep it up to date with the
                    upcoming demands."
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
            </div>

            <div class="testimonial-item swiper-slide">
                <img src="{{ asset('images/small/collaborations-min.png') }}" class="testimonial-img"
                    alt="collaboration">
                <h3>Collaborators</h3>
                <h4>Public & Private Sector</h4>
                <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    We have great collaboration with subject experts from public as well as private sector. It is due to
                    their collobation that have succeeded to build an authentic question bank
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
            </div>

        </div>
        <div class="swiper-pagination"></div>
    </div>

</section><!-- End Ttstimonials Section -->

<section>
    <div class="relative overflow-x-clip md:px-24">
        <div class="flex items-center justify-center h-40 gap-x-8">
            <h1 class="text-teal-400 text-6xl" data-aos="zoom-in" data-aos-duration="1000"><i
                    class="bi bi-telephone"></i></h1>
            <div data-aos="zoom-in" data-aos-duration="1000" class="text-md font-semibold tracking-wider">
                <p>+923004103160</p>
                <p>+923000373004</p>
            </div>
            <div class="absolute h-80 w-80 scale-150 -z-10 rounded-full bg-teal-50"></div>
        </div>

    </div>
</section>

<a href="{{ url('https://wa.me/+923000373004') }}"
    class="flex justify-center items-center text-teal-600 text-5xl fixed right-8 bottom-8"><i
        class="bi-whatsapp"></i></a>
@endsection
@section('footer')
<!-- footer -->
<x-footer></x-footer>
@endsection