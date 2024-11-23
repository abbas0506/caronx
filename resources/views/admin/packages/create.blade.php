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
            <a href="{{route('admin.packages.index')}}">Packages</a>
            <i class="bx bx-chevron-right"></i>
            <div>New</div>
        </div>

        <div class="flex flex-wrap items-center gap-3 text-slate-600 mt-6">
            <p class="tab active">Packages</p>
            <a href="{{ route('admin.types.index') }}" class="tab">Q. Types</a>
            <a href="{{ route('admin.tags.index') }}" class="tab">Tags</a>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif


        <div class="p-8 bg-white">
            <form action="{{route('admin.packages.store')}}" method='post' class="">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <h2 class="md:col-span-2 text-green-600">New Package <i class="bi-box"></i></h2>
                    <div class="md:col-span-2">
                        <label for="">Package Name</label>
                        <input type="text" id='' name='name' class="custom-input-borderless" placeholder="Package name" value="">
                    </div>

                    <div>
                        <label for="">Coins</label>
                        <input type="number" id='' name='coins' class="custom-input-borderless" placeholder="Coins" value="">
                    </div>
                    <div>
                        <label for="">Price</label>
                        <input type="number" id='' name='price' class="custom-input-borderless" placeholder="Price" value="">
                    </div>
                    <div>
                        <label for="">Duration</label>
                        <input type="number" id='' name='duration' class="custom-input-borderless" placeholder="Validity duration" value="">
                    </div>


                    <div class="md:col-span-2 text-right">
                        <button type="submit" class="btn btn-teal rounded">Create Now</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="module">

</script>
@endsection