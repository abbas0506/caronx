@extends('layouts.basic')

@section('header')
<x-headers.user page="Welcome back!" icon="<i class='bi bi-emoji-smile'></i>"></x-headers.user>
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
                <a href="{{ route('user.papers.show', $paper) }}">Paper</a>
                <div>/</div>
                <div>PDF</div>
            </div>
        </div>


        <div class="content-section rounded-lg mt-6">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <div class="flex items-center justify-between flex-wrap  gap-2">
                <div class="flex flex-row items-center gap-3">
                    <img src="{{ url('images/icons/pdf.png') }}" alt="paper" class="w-12">
                    <div class="flex flex-col">
                        <h2>{{ $paper->book->name }} </h2>
                        <div class="flex items-center space-x-3">
                            <label>{{ $paper->title }}</label>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-slate-500 text-sm md:text-right md:pr-5">Step 4/4</p>
                </div>
            </div>


            @if($paper->paperQuestions->count())
            <div class="divider my-3"></div>
            <h2 class="text-center"><i class="bi-gear"></i> Print Setting </h2>
            <p class="text-center my-3 text-sm text-gray-500">Choosing appropriate setting may save your printing cost</p>
            <div class="divider my-3"></div>
            @endif
            @if($paper->paperQuestions->count()>0)
            <form action="{{route('user.papers.latex-pdf.store',$paper)}}" method="post">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 justify-items-center justify-center p-6 md:w-4/5 mx-auto">
                    <div class="callable">
                        Page Size
                        <div class="right-pointer"></div>
                    </div>
                    <div class="w-full h-full  flex justify-start items-start space-x-4">
                        <div class="page-size-container w-16 h-20 active">
                            <input type="checkbox" name="page_size" value="a4" class="page-size" checked>
                            <div class="text-xs">A4</div>
                        </div>
                        <div class="page-size-container w-16 h-24">
                            <input type="checkbox" name="page_size" value="legal" class="page-size">
                            <div class="text-xs">Legal</div>
                        </div>
                    </div>

                    <div class="callable">
                        Orientation
                        <div class="right-pointer"></div>
                    </div>
                    <div class="w-full h-full  flex justify-start items-start space-x-4">
                        <div class="flex justify-center items-start gap-x-4">
                            <div class="page-orientation-container w-16 h-20 active">
                                <input type="checkbox" bound='portrait' name="orientation" value="portrait" class="page-orientation" checked>
                                <div class="text-xs">Portrait</div>
                            </div>
                            <div class="page-orientation-container w-24 h-16">
                                <input type="checkbox" bound='landscape' name="orientation" value="landscape" class="page-orientation">
                                <div class="text-xs">Landscape</div>
                            </div>
                        </div>
                    </div>
                    <div class="callable">
                        Font Size
                        <div class="right-pointer"></div>
                    </div>
                    <div class="w-full h-full flex justify-start items-start space-x-4">
                        <div class="flex justify-center gap-x-4">
                            <div class="flex flex-col gap-2">
                                <div class="font-size-container">
                                    <input type="checkbox" name="font_size" value="12" class="font-size">
                                    <div class="text-base">Normal</div>
                                </div>
                                <div class="font-size-container">
                                    <input type="checkbox" name="font_size" value="10" class="font-size">
                                    <div class="text-sm">Medium</div>
                                </div>
                                <div class="font-size-container active">
                                    <input type="checkbox" name="font_size" value="9" class="font-size" checked>
                                    <div class="text-xs">Small</div>
                                </div>
                                <div class="font-size-container">
                                    <input type="checkbox" name="font_size" value="8" class="font-size">
                                    <div class="text-xxs">Extra Small</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="callable">
                        Papers Per Page
                        <div class="right-pointer"></div>
                    </div>
                    <div class="w-full h-full flex flex-col justify-start items-start">
                        <!-- portrait options -->
                        <div id='portrait' class="hidden grid grid-cols-3 gap-2 w-full text-center">
                            <!-- portrait -->
                            <div row='1' col='1' class="page grid grid-cols-1 w-12">
                                <div class="paper w-12 h-16 border"></div>
                                <div class="text-xs">1x1</div>
                            </div>
                            <div row='2' col='1' class="page grid grid-cols-1 w-12">
                                <div class="paper h-8 border"></div>
                                <div class="paper h-8 border"></div>
                                <div class="text-xs">2x1</div>
                            </div>
                            <div row='3' col='1' class="page grid grid-cols-1 w-12">
                                <div class="paper h-6 border"></div>
                                <div class="paper h-6 border"></div>
                                <div class="paper h-6 border"></div>
                                <div class="text-xs">3x1</div>
                            </div>
                            <!-- <div row='1' col='2' class="page grid grid-cols-2 w-12">
                                <div class="paper w-6 h-16 border"></div>
                                <div class="paper w-6 h-16 border"></div>
                                <div class="text-xs col-span-2">1x2</div>
                            </div>
                            <div row='2' col='2' class="page grid grid-cols-2 w-12">
                                <div class="w-6 paper h-8 border"></div>
                                <div class="w-6 paper h-8 border"></div>
                                <div class="w-6 paper h-8 border"></div>
                                <div class="w-6 paper h-8 border"></div>
                                <div class="text-xs col-span-2">2x2</div>
                            </div>
                            <div row='3' col='2' class="page grid grid-cols-2 w-12">
                                <div class="w-6 paper h-5 border"></div>
                                <div class="w-6 paper h-5 border"></div>
                                <div class="w-6 paper h-5 border"></div>
                                <div class="w-6 paper h-5 border"></div>
                                <div class="w-6 paper h-5 border"></div>
                                <div class="w-6 paper h-5 border"></div>
                                <div class="text-xs col-span-2">3x2</div>
                            </div> -->
                        </div>

                        <!-- landscapre options -->
                        <div id='landscape' class="grid grid-cols-3 gap-2 w-full text-center">
                            <!-- portrait -->
                            <div row='1' col='1' class="page grid grid-cols-1 w-16 active">
                                <div class="paper h-12 border"></div>
                                <div class="text-xs">1x1</div>
                            </div>
                            <div row='2' col='1' class="page grid grid-cols-1 w-16">
                                <div class="paper h-6 border"></div>
                                <div class="paper h-6 border"></div>
                                <div class="text-xs">2x1</div>
                            </div>
                            <div row='3' col='1' class="page grid grid-cols-1 w-16">
                                <div class="paper h-4 border"></div>
                                <div class="paper h-4 border"></div>
                                <div class="paper h-4 border"></div>
                                <div class="text-xs">3x1</div>
                            </div>
                            <!-- <div row='1' col='2' class="page grid grid-cols-2 w-16">
                                <div class="paper w-8 h-12 border"></div>
                                <div class="paper w-8 h-12 border"></div>
                                <div class="text-xs col-span-2">1x2</div>
                            </div>
                            <div row='2' col='2' class="page grid grid-cols-2 w-16">
                                <div class="w-8 paper h-6 border"></div>
                                <div class="w-8 paper h-6 border"></div>
                                <div class="w-8 paper h-6 border"></div>
                                <div class="w-8 paper h-6 border"></div>
                                <div class="text-xs col-span-2">2x2</div>
                            </div>
                            <div row='3' col='2' class="page grid grid-cols-2 w-16">
                                <div class="w-8 paper h-4 border"></div>
                                <div class="w-8 paper h-4 border"></div>
                                <div class="w-8 paper h-4 border"></div>
                                <div class="w-8 paper h-4 border"></div>
                                <div class="w-8 paper h-4 border"></div>
                                <div class="w-8 paper h-4 border"></div>
                                <div class="text-xs col-span-2">3x2</div>
                            </div> -->
                        </div>
                        <!-- <div class="col-span-3 divider"></div> -->
                        <!-- advanced printing options collapsible -->
                        <div class="collapsible mt-3 w-full hidden">
                            <div class="head">
                                <div class="flex items-center space-x-2">
                                    <i class="bx bxs-chevron-down text-blue-600"></i>
                                    <h2 class=""><span class="text-slate-800 text-xs">Advanced options</span></h2>
                                </div>
                            </div>

                            <div class="body">
                                <div id='advanced' class="col-span-3 grid grid-cols-2 gap-4">
                                    <div>
                                        <input type="number" name="rows" id="rows" value="1" min=1 max=6 class="custom-input text-center" required>
                                        <div class="text-xs">Horizontal</div>
                                    </div>
                                    <div>
                                        <input type="number" name="columns" id="columns" value="1" min=1 max=6 class="custom-input text-center" required>
                                        <div class="text-xs">Vertical</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider my-4"></div>
                <div class="text-center mb-8">
                    <button type="submit" class="btn btn-teal">Generate Paper <i class="bi-file-pdf ml-2"></i></button>
                </div>
            </form>
            @endif
        </div>
        @endsection
        @section('script')
        <script type="module">
            // $('.font-size').change(function() {
            //     // check only one of many
            //     $('.font-size').not(this).prop('checked', false);
            // });

            $('#rows').click(function() {
                $(this).select();
            })
            $('#columns').click(function() {
                $(this).select();
            })
            $('.page').click(function() {

                $('#rows').val($(this).attr('row'));
                $('#columns').val($(this).attr('col'));
                $(this).addClass('active');
                $('.page').not(this).removeClass('active');

            });

            $('.page-size-container').click(function() {
                //iterate through all first children (checkboxes) of the page szie class
                //update their check status and visibility 
                var obj = $(this).children(":first");
                $('.page-size-container').find(":first-child").each(function() {
                    if (obj.is($(this))) {
                        $(this).prop('checked', true);
                        $(this).parent().addClass('active');

                    } else {
                        $(this).prop('checked', false);
                        $(this).parent().removeClass('active');
                    }
                });
            })

            $('.page-orientation-container').click(function() {
                //iterate through all first children (checkboxes) of the page orientation
                //update their check status and visibility 
                var obj = $(this).children(":first");
                $('.page-orientation-container').find(":first-child").each(function() {
                    if (obj.is($(this))) {
                        $(this).prop('checked', true);
                        $('#' + $(this).attr('bound')).removeClass('hidden');
                        $('#' + $(this).attr('bound')).children(":first").addClass('active')
                        $('#' + $(this).attr('bound')).children().not(":first").removeClass('active')
                        $('#rows').val(1);
                        $('#columns').val(1);
                        $(this).parent().addClass('active');


                    } else {
                        $(this).prop('checked', false);
                        $('#' + $(this).attr('bound')).addClass('hidden');
                        $(this).parent().removeClass('active');
                    }
                });

            })

            $('.font-size-container').click(function() {
                //iterate through all first children (checkboxes) of the font szie class
                //update their check status and visibility 
                var obj = $(this).children(":first");
                $('.font-size-container').find(":first-child").each(function() {
                    if (obj.is($(this))) {
                        $(this).prop('checked', true);
                        $(this).parent().addClass('active');

                    } else {
                        $(this).prop('checked', false);
                        $(this).parent().removeClass('active');
                    }
                });
            })
        </script>
        @endsection