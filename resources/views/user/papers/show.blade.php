@extends('layouts.basic')

@section('header')
<x-headers.user page="Q. Paper" icon="<i class='bi bi-file-earmark-text'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.user page='paper'></x-sidebars.user>
@endsection

@php
$colors = config('globals.colors');
$roman = new Roman();
$QNo = 1;
@endphp

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb">
                <a href="{{ url('/') }}">Home</a>
                <div>/</div>
                <div>Paper</div>
            </div>
        </div>


        <div class="content-section rounded-lg mt-8 text-sm ">
            <!-- page message -->
            @if ($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <div class="flex flex-row flex-wrap justify-between items-center gap-4 relative">
                <div class="flex flex-row items-center gap-3">
                    <a href="{{ route('user.papers.simple-pdf.create', $paper) }}">
                        <img src="{{ url('images/icons/pdf.png') }}" alt="paper" class="w-12">
                    </a>
                    <div class="flex flex-col">
                        <h2>{{ $paper->book->name }} </h2>
                        <label>{{ $paper->title }}</label>
                    </div>
                </div>
                <div class="text-center">
                    <div><i class="bi-calendar4-event text-xl"></i></div>
                    <label for="">{{ $paper->paper_date->format('d/m/Y') }}</label>
                </div>
                <!-- center align at bottom -->
                <a href="{{ route('user.papers.edit', $paper) }}" class="absolute right-2 top-1 btn btn-sky flex justify-center items-center rounded-full p-0 w-5 h-5"><i class="bx bx-pencil text-xs"></i></a>
            </div>

            <!-- show print button only if paper has some questions -->
            <div class="fixed left-0 md:pl-60 bottom-0 bg-teal-50 flex justify-between items-center w-full px-4 py-2 opacity-90">
                <div class="flex flex-col flex-wrap gap-x-2">
                    <h3>{{ $paper->book->name }}</h3>
                    <label> Step 3/4 ( {{ $paper->paperQuestions->sum('marks') }} marks )</label>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('user.papers.edit', $paper) }}" class="flex justify-center items-center rounded-full border border-slate-600 p-0 w-5 h-5"><i class="bi-question text-sm"></i></a>
                    @if($paper->paperQuestions->sum('marks')>0)
                    <a href="{{ route('user.papers.latex-pdf.create', $paper) }}"><i class="bi-printer"></i></a>
                    @endif
                    <a href="{{ route('user.paper.questions.create', $paper) }}" class="flex w-10 h-10 items-center justify-center rounded-full bg-teal-300 hover:bg-teal-400 text-xs">Q+</a>
                </div>

            </div>

            <div class="divider my-3"></div>

            @if ($paper->paperQuestions->count())
            <div class="flex flex-row justify-between items-center w-full">
                <label>Suggested Time: &nbsp {{ $paper->suggestedTime() }}</label>
                <label>Max marks: {{ $paper->paperQuestions->sum('marks') }}</label>
            </div>

            <div class="divider my-3"></div>

            <div class="overflow-x-auto mt-4">
                <table class="table-fixed w-full xs md:sm">
                    <thead>
                        <tr>
                            <th class="w-8"></th>
                            <th class="w-96"></th>
                            <th class="w-8"></th>
                            <th class="w-8"></th>
                            <th class="w-8"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($paper->paperQuestions as $paperQuestion)

                        <!-- MCQs -->
                        @if ($paperQuestion->type_name == 'mcq')
                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>({{ $paperQuestion->marks }})</td>
                            <td>
                                <a href="{{ route('user.paper.questions.edit', [$paper, $paperQuestion]) }}"><i class="bx bx-pencil text-green-600"></i></a>
                            </td>
                            <td>
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>

                        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                        <tr>
                            <td>{{$roman->lowercase($loop->index+1)}}</td>
                            <td class="text-left">{{ $paperQuestionPart->question->statement }}
                                @if(Auth::user()->hasRole('collaborator'))
                                <a href="{{ route('user.paper.base-questions.edit', [$paper, $paperQuestionPart->question]) }}"><i class="bx bx-pencil text-green-500"></i></a>
                                @endif
                            </td>
                            <td></td>
                            <td>
                                <a href="{{ route('user.paper-question-parts.refresh', $paperQuestionPart) }}"><i class="bi-arrow-repeat text-green-600"></i></a>
                            </td>
                            <td>
                                <form
                                    action="{{ route('user.paper-question-parts.destroy', $paperQuestionPart) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bi-x text-red-600 confirm-del"></i></button>
                                </form>
                            </td>

                        </tr>

                        <tr>
                            <td></td>
                            <td class="text-left">
                                <div class="grid grid-cols-2">
                                    <div>a) {{ $paperQuestionPart->question->mcq->choice_a }}</div>
                                    <div>b) {{ $paperQuestionPart->question->mcq->choice_b }}</div>
                                    <div>c) {{ $paperQuestionPart->question->mcq->choice_c }}</div>
                                    <div>d) {{ $paperQuestionPart->question->mcq->choice_d }}</div>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td>
                                <div class="flex items-center">
                                    <a href="{{ route('user.paper-question.type.extensions.create', [$paperQuestion, $paperQuestion->paperQuestionParts->first()->question->type]) }}" class="flex justify-center items-center w-6 h-6 rounded-full bg-blue-600"><i class="bi-plus text-white"></i></a>
                                    &nbsp;<label for="">(append another question)</label>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif

                        <!-- partial -->
                        @if ($paperQuestion->type_name == 'partial' || $paperQuestion->type_name == 'partial-x')
                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td> ({{ $paperQuestion->marks }})</td>
                            <td>
                                <a href="{{ route('user.paper.questions.edit', [$paper, $paperQuestion]) }}"><i class="bx bx-pencil text-green-600"></i></a>
                            </td>
                            <td>
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>
                        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                        <tr>
                            <td>{{$roman->lowercase($loop->index+1)}}</td>
                            <td class="text-left">{{ $paperQuestionPart->question->statement }}
                                @if(Auth::user()->hasRole('collaborator'))
                                <a href="{{ route('user.paper.base-questions.edit', [$paper, $paperQuestionPart->question]) }}"><i class="bx bx-pencil text-green-500"></i></a>
                                @endif
                            </td>
                            <td></td>
                            <td>
                                <a href="{{ route('user.paper-question-parts.refresh', $paperQuestionPart) }}"><i class="bi-arrow-repeat text-green-600"></i></a>
                            </td>
                            <td>
                                <form
                                    action="{{ route('user.paper-question-parts.destroy', $paperQuestionPart) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bi-x text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td>
                                <div class="flex items-center">
                                    <a href="{{ route('user.paper-question.type.extensions.create', [$paperQuestion, $paperQuestion->paperQuestionParts->first()->question->type]) }}" class="flex justify-center items-center w-6 h-6 rounded-full bg-blue-600"><i class="bi-plus text-white"></i></a>
                                    &nbsp;<label for="">(append another question)</label>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif

                        <!-- simple question -->
                        @if ($paperQuestion->type_name == 'simple')
                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>({{ $paperQuestion->marks }})</td>
                            <td>
                                <a href="{{ route('user.paper.questions.edit', [$paper, $paperQuestion]) }}"><i class="bx bx-pencil text-green-600"></i></a>
                            </td>
                            <td>
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td class="text-left">{{$paperQuestion->paperQuestionParts()->first()->question->statement }}

                                @if(Auth::user()->hasRole('collaborator'))
                                <a href="{{ route('user.paper.base-questions.edit', [$paper, $paperQuestion->paperQuestionParts()->first()->question]) }}"><i class="bx bx-pencil text-green-500"></i></a>
                                @endif
                            </td>
                            <td></td>
                            <td>
                                <a href="{{ route('user.paper-question-parts.refresh', $paperQuestion->paperQuestionParts()->first()) }}"><i class="bi-arrow-repeat text-green-600"></i></a>
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <div class="flex items-center">
                                    <a href="{{ route('user.paper-question.type.extensions.index', [$paper, $paperQuestion]) }}" class="flex justify-center items-center w-6 h-6 rounded-full bg-blue-600"><i class="bi-plus text-white"></i></a>
                                    <!-- <a href="{{ route('user.paper-question.type.extensions.index', [$paperQuestion, $paperQuestion->paperQuestionParts->first()->question->type]) }}" class="flex justify-center items-center w-6 h-6 rounded-full bg-blue-600"><i class="bi-plus text-white"></i></a> -->
                                    &nbsp;<label for="">(append another question)</label>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif

                        <!-- simple-or -->
                        @if ($paperQuestion->type_name == 'simple-or')
                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>({{ $paperQuestion->marks }})</td>
                            <td>
                                <a href="{{ route('user.paper.questions.edit', [$paper, $paperQuestion]) }}"><i class="bx bx-pencil text-green-600"></i></a>
                            </td>
                            <td>
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>
                        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                        <tr>
                            <td></td>
                            <td class="text-left">
                                {{ $paperQuestionPart->question->statement }} @if(!$loop->last) <span class="font-bold">OR</span> @endif
                                @if(Auth::user()->hasRole('collaborator'))
                                <a href="{{ route('user.paper.base-questions.edit', [$paper, $paperQuestionPart->question]) }}"><i class="bx bx-pencil text-green-500"></i></a>
                                @endif
                            </td>
                            <td></td>
                            <td>
                                <a href="{{ route('user.paper-question-parts.refresh', $paperQuestionPart) }}"><i class="bi-arrow-repeat text-green-600"></i></a>
                            </td>
                            <td>
                                <form
                                    action="{{ route('user.paper-question-parts.destroy', $paperQuestionPart) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bi-x text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td>
                                <div class="flex items-center">
                                    <a href="{{ route('user.paper-question.type.extensions.index', [$paper, $paperQuestion]) }}" class="flex justify-center items-center w-6 h-6 rounded-full bg-blue-600"><i class="bi-plus text-white"></i></a>
                                    &nbsp;<label for="">(append another question)</label>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif

                        <!-- simple-and -->
                        @if ($paperQuestion->type_name == 'simple-and')
                        @php
                        $alphabets = range('a', 'z');
                        @endphp

                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>({{ $paperQuestion->marks }})</td>
                            <td>
                                <a href="{{ route('user.paper.questions.edit', [$paper, $paperQuestion]) }}"><i class="bx bx-pencil text-green-600"></i></a>
                            </td>
                            <td>
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>

                        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                        <tr>
                            <td>{{ $alphabets[$loop->index] }})</td>
                            <td class="text-left">
                                {{ $paperQuestionPart->question->statement }}

                                @if(Auth::user()->hasRole('collaborator'))
                                <a href="{{ route('user.paper.base-questions.edit', [$paper, $paperQuestionPart->question]) }}"><i class="bx bx-pencil text-green-500"></i></a>
                                @endif
                            </td>
                            <td>{{ $paperQuestionPart->marks }}</td>
                            <td>
                                <a href="{{ route('user.paper-question-parts.refresh', $paperQuestionPart) }}"><i class="bi-arrow-repeat text-green-600"></i></a>
                            </td>
                            <td>
                                <form
                                    action="{{ route('user.paper-question-parts.destroy', $paperQuestionPart) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bi-x text-red-600 confirm-del"></i></button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td>
                                <div class="flex items-center">
                                    <a href="{{ route('user.paper-question.type.extensions.index', [$paper, $paperQuestion]) }}" class="flex justify-center items-center w-6 h-6 rounded-full bg-blue-600"><i class="bi-plus text-white"></i></a>
                                    &nbsp;<label for="">(append another question)</label>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif

                        <!-- poetry lines -->
                        @if($paperQuestion->type_name=='stanza')

                        @endif

                        <!-- comprehension -->
                        @if($paperQuestion->type_name=='comprehension')

                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>({{ $paperQuestion->marks }})</td>
                            <td>
                                <a href="{{ route('user.paper.questions.edit', [$paper, $paperQuestion]) }}"><i class="bx bx-pencil text-green-600"></i></a>
                            </td>
                            <td>
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td class="text-left">{{$paperQuestion->question->statement }}</td>
                            <td></td>
                            <td>
                                <a href="{{ route('user.paper-question-parts.refresh', $paperQuestion->paperQuestionParts()->first()) }}"><i class="bi-arrow-repeat text-green-600"></i></a>
                            </td>
                        </tr>
                        @endif
                        @endforeach <!-- end iterating questions -->

                    </tbody>
                </table>
            </div>
            @else
            <!-- paper has no question -->
            <div class="flex items-center md:w-4/5 mx-auto mt-8  bg-orange-50 p-4 rounded-lg font-semibold">
                <p>Question paper is currently <span class="text-teal-600 ml-1">empty</span>. &nbsp Start adding questions by clicking on <a href="{{ route('user.papers.edit', $paper) }}" class="text-teal-600 mx-1"> Q+ </a> icon in the &nbsp <u> lower right corner of screen</u>.</p>
            </div>
            <div class="md:w-3/4 mx-auto mt-8">
                <h2>Do you know?</h2>
                <table class="table-auto borderless w-full mt-4">
                    <thead>
                        <tr>
                            <th class="w-16 md:w-24">Icon</th>
                            <th class="text-left">Function</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-teal-600 text-base">Q+</td>
                            <td class="text-left">for adding new questions to this paper</td>
                        </tr>
                        <tr>
                            <td class="text-teal-600"><i class="bi-arrow-repeat text-lg"></i></td>
                            <td class="text-left">for auto replacing any part of the question</td>
                        </tr>
                        <tr>
                            <td class="text-blue-600"><i class="bx bx-pencil text-lg"></i></td>
                            <td class="text-left">for editing any question info.</td>
                        </tr>
                        <tr>
                            <td class="text-red-600"><i class="bi-x text-lg"></i></td>
                            <td class="text-left">for removing any part of the question</td>
                        </tr>
                        <tr>
                            <td class="text-red-600"><i class="bi-trash"></i></td>
                            <td class="text-left">for removing whole question</td>
                        </tr>
                        <tr>
                            <td class=""><i class="bi-printer"></i></td>
                            <td class="text-left">for getting preview or printing the question paper</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif <!-- end if paper has questions -->

        </div>
    </div>
</div>
<!-- bottom marging -->
<div class="h-16"></div>

@endsection

@section('script')

<script type="module">
    $('document').ready(function() {

        $("html, body").animate({
            scrollTop: $(document).height()
        }, 1000);

        $('.confirm-del').click(function(event) {
            var form = $(this).closest("form");
            // var name = $(this).data("name");
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    //submit corresponding form
                    form.submit();
                }
            });
        });

    });
</script>
@endsection