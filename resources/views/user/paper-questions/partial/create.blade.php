@extends('layouts.basic')

@section('header')
<x-headers.user page="New Paper" icon="<i class='bi bi-file-earmark-text'></i>"></x-headers.user>
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
                <div>Add Q.</div>
            </div>
        </div>


        <div class="content-section mt-6">
            <div class="flex items-center justify-between flex-wrap  gap-2">
                <div class="flex flex-row items-center gap-3">
                    <img src="{{ url('images/small/pdf.png') }}" alt="paper" class="w-12">
                    <div class="flex flex-col">
                        <h2>{{ $paper->book->name }} </h2>
                        <div class="flex items-center space-x-3">
                            <label>{{ $paper->title }}</label>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-slate-500 text-sm text-center md:text-right md:pr-5">Step 3.2/4</p>
                </div>
            </div>
            <div class="divider my-3"></div>

            <form action="{{ route('user.paper.question-type.partial-questions.store', [$paper, $type]) }}" method="post" class="grid gap-6 md:w-3/4 mx-auto mt-6">
                @csrf
                <h2 class="text-xl">{{ $type->name }}</h2>
                <input type="hidden" name="type_name" value="{{ $type->display_style }}">

                <div class="grid md:grid-cols-3 gap-6 items-center">
                    <div class="">
                        <label>Importance Level</label>
                        <select name="frequency" id="" class="custom-input-borderless text-sm py-1">
                            <option value="1">Normal</option>
                            <option value="2">High</option>
                            <option value="3">Very High</option>
                        </select>
                    </div>

                    <div class="" id='marks' @if(in_array($type->id,[1,2])) hidden @endif>
                        <label>Marks</label>
                        <input type="number" name="marks" class="custom-input-borderless" min=1 max=100 value="5">
                    </div>
                </div>

                <div>
                    <label for="">Question Title</label>
                    <input type="text" name="question_title" value="{{ $type->default_title }}" class="custom-input-borderless">
                </div>


                <div class="grid text-sm border p-6">

                    <table class="borderless">
                        <thead>
                            <tr>
                                <th>Sr</th>
                                <th class="text-left">Chapter</th>
                                <th>Parts</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chapters->sortBy('sr') as $chapter)
                            <tr>
                                <td>{{ $chapter->sr}}.</td>
                                <td class="text-left">{{ $chapter->title }}</td>
                                <td>
                                    <input type="hidden" name='chapter_ids_array[]' value="{{$chapter->id}}">
                                    <input type="number" name='num_of_parts_array[]' autocomplete="off" class="parts-count custom-input-borderless w-16 h-8 text-center px-0" min='0' value="0" oninput="syncNumOfParts()">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="grid gap-6">
                    <div class="w-40">
                        <label>Total Parts</label>
                        <input type="number" id="total_parts" class="custom-input-borderless" value="0" disabled>
                    </div>
                    <div class="w-40">
                        <label>Compulsory Parts</label>
                        <input type="number" id='compulsory_parts' name="compulsory_parts" class="custom-input-borderless text-red-600" value="" min=1>
                    </div>
                </div>
                <!-- <div class="divider my-3"></div> -->
                <div class="text-right">
                    <button type="submit" class="btn btn-blue px-4 py-2 text-sm rounded-md">Add Q.</button>
                </div>
                <div class="h-8"></div>
            </form>

        </div>
        @endsection
        @section('script')
        <script type="module">
            $(document).ready(function() {

                $('.parts-count').click(function() {
                    $(this).select();
                })
                $('#compulsory_parts').click(function() {
                    $(this).select();
                })

                $('.parts-count').bind('keyup mouseup', function() {
                    var sumOfParts = 0;
                    $('.parts-count').each(function() {
                        sumOfParts += parseInt($(this).val());

                    });

                    sumOfParts = parseInt(sumOfParts);
                    $('#total_parts').val(sumOfParts);
                    $('#compulsory_parts').val(sumOfParts);
                });


                $('form').submit(function(event) {
                    var validated = true;
                    var compulsory_parts = $('#compulsory_parts').val();
                    if ($('#total_parts').val() == '')
                        validated = false
                    else if ($.isNumeric(compulsory_parts)) {
                        var totalParts = $('#parts_count').val()
                        if (compulsory_parts <= 0 || compulsory_parts > totalParts)
                            validated = false
                    } else {
                        validated = false
                    }

                    if (!validated) {
                        event.preventDefault();
                        Swal.fire({
                            title: "Warning",
                            text: "Review compulsory parts carefully!",
                            icon: "warning",
                            showConfirmButton: false,
                            timer: 1500

                        });

                    }
                    return validated;
                });
            });
        </script>
        @endsection