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
            <a href="{{route('admin.types.index')}}">Q. Types</a>
            <i class="bx bx-chevron-right"></i>
            <div>New</div>
        </div>


        <div class="md:w-3/4 mx-auto mt-12">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <form action="{{route('admin.types.store')}}" method='post'>
                @csrf
                <div class="grid gap-6">
                    <h2 class="text-green-600">New Type <i class="bi-box"></i></h2>
                    <div class="md:w-1/4">
                        <label for="">Sr</label>
                        <input type="number" id='' name='sr' class="custom-input-borderless" placeholder="Question Type" value="1">
                    </div>
                    <div>
                        <label for="">Type Name</label>
                        <input type="text" id='' name='name' class="custom-input-borderless" placeholder="Question Type" value="">
                    </div>
                    <div class="md:w-1/4">
                        <label for="">Default Style</label>
                        <select name="display_style" id="" class="custom-input-borderless">
                            <option value="mcq">MCQ</option>
                            <option value="partial">Partial</option>
                            <option value="partial-x">Partial-x</option>
                            <option value="simple">Simple</option>
                            <option value="simple-or">Simple-or</option>
                            <option value="simple-and">Simple-and</option>
                            <option value="stanza">Stanza</option>
                            <option value="comprehension">Comprehension</option>
                        </select>
                    </div>

                    <div>
                        <label for="">Default Title</label>
                        <input type="text" id='' name='default_title' class="custom-input-borderless" placeholder="Default title" value="">
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn-teal rounded">Create Now</button>
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