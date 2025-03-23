<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Paper</title>
    <link href="{{ public_path('css/pdf_tw.css') }}" rel="stylesheet">
    <!-- <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script> -->

    <style>
        @page {
            margin: 30px 50px 30px 50px;
        }

        .footer {
            position: fixed;
            bottom: 50px;
            left: 30px;
            right: 50px;
            background-color: white;
            height: 50px;
        }

        .page-break {
            page-break-after: always;
        }

        .data tr th,
        .data tr td {
            /* font-size: 12px; */
            text-align: center;
            /* padding-bottom: 2px; */
            border: 0.5px solid;
        }
    </style>
</head>
@php
$roman = config('global.romans');
@endphp

<body>
    <main>
        <div class="custom-container">
            <!-- <div class="relative">
                <div class="absolute"><img alt="logo" src="{{ public_path('/images/logo/school_logo.png') }}" class="w-8"></div>
            </div> -->
            <table class="{{ $fontSize }} w-full">

                @php
                $i = 1;
                $j = 1;
                $roman = new Roman();
                $QNo = 1;

                @endphp
                <tbody>
                    @for ($i = 1; $i <= $rows; $i++)
                        <tr>
                        @for ($j = 1; $j <= $columns; $j++)
                            @php $QNo=1; @endphp
                            <td class='@if ($j != 1) pl-8 @endif'>

                            <table class="w-full">
                                <tbody>

                                    <tr>
                                        <td colspan="2" class="m-0 p-0 font-bold">{{ $paper->institution }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" class="m-0 p-0">{{ $paper->title }} Dated
                                            {{ $paper->paper_date->format('d/m/Y') }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-left">Subject: {{ $paper->course->name }}</td>
                                        <td class="text-right">Roll # ______</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div style="border-style:solid; border-width:0px 0px 0.5px 0px;">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Allowed Time: {{ $paper->suggestedTime() }}</td>
                                        <td class="text-right">Max Marks:
                                            {{ $paper->paperQuestions()->sum('marks') }}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <div style="border-style:solid; border-width:0px 0px 0.5px 0px;"></div>

                            @if ($paper->paperQuestions->count())
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th style="width:90%"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($paper->paperQuestions as $paperQuestion)
                                    @if ($paperQuestion->type_id==1)
                                    <tr>
                                        <td class="font-bold">Q.{{ $QNo++ }}</td>
                                        <td class="text-left font-bold">
                                            {{ $paperQuestion->question_title }}
                                        </td>
                                        <td>({{ $paperQuestion->marks }})</td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td class="text-left">
                                            <ol class="lower-roman ml-4">
                                                @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                                                <li>
                                                    {{ $paperQuestionPart->question->statement }}
                                                    <ol
                                                        class="list-horizontal lower-alpha pt-1">
                                                        <li class="text-left w-1-4">a)
                                                            {{ $paperQuestionPart->question->mcq->choice_a }}
                                                        </li>
                                                        <li class="text-left w-1-4">b)
                                                            {{ $paperQuestionPart->question->mcq->choice_b }}
                                                        </li>
                                                        <li class="text-left w-1-4">c)
                                                            {{ $paperQuestionPart->question->mcq->choice_c }}
                                                        </li>
                                                        <li class="text-left w-1-4">d)
                                                            {{ $paperQuestionPart->question->mcq->choice_d }}
                                                        </li>
                                                    </ol>
                                                </li>
                                                @endforeach
                                            </ol>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @endif <!-- end mcqs -->


                                    <!-- Partial Question (vertical)-->
                                    @if ($paperQuestion->type_id==2)
                                    <tr>
                                        <td class="font-bold">Q.{{ $QNo++ }}</td>
                                        <td class="text-left font-bold">
                                            {{ $paperQuestion->question_title }}
                                        </td>
                                        <td>({{ $paperQuestion->marks }})</td>
                                    </tr>
                                    @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                                    <tr>
                                        <td>{{ $roman->lowercase($loop->index + 1) }}</td>
                                        <td class="text-left">
                                            {{ $paperQuestionPart->question->statement }}
                                        </td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                    @endif


                                    <!-- simple -->
                                    @if ($paperQuestion->type_name == 'simple')
                                    <!-- has title -->
                                    @if ($paperQuestion->question_title)
                                    <tr>
                                        <td class="font-bold">Q.{{ $QNo++ }}</td>
                                        <td class="text-left font-bold">
                                            {{ $paperQuestion->question_title }}
                                        </td>
                                        <td>({{ $paperQuestion->marks }})
                                        </td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td class="text-left">
                                            {{ $paperQuestion->paperQuestionParts()->first()->question->statement }}
                                        </td>
                                        <td></td>
                                    </tr>

                                    @foreach ($paperQuestion->paperQuestionParts->first()->question->comprehensions as $comprehension)
                                    <tr>
                                        <td></td>
                                        <td class="text-left">
                                            {{ $comprehension->sub_question }}
                                        </td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <!-- without title -->
                                    <tr>
                                        <td>Q.{{ $QNo++ }}</td>
                                        <td class="text-left">
                                            {{ $paperQuestion->paperQuestionParts()->first()->question->statement }}
                                        </td>
                                        <td>({{ $paperQuestion->paperQuestionParts()->first()->marks }})
                                        </td>
                                    </tr>
                                    @endif <!-- has title or not -->
                                    @endif


                                    <!-- simple-or : optional questions -->
                                    @if ($paperQuestion->type_name == 'simple-or')
                                    @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                                    @if ($loop->first)
                                    <tr>
                                        <td>Q.{{ $QNo++ }}</td>
                                        <td class="text-left">
                                            {{ $paperQuestionPart->question->statement }}
                                            @if (!$loop->last)
                                            <span class="font-bold">OR</span>
                                            @endif
                                        </td>
                                        <td>({{ $paperQuestion->marks }})</td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td></td>
                                        <td class="text-left">
                                            {{ $paperQuestionPart->question->statement }}
                                            @if (!$loop->last)
                                            <span class="font-bold">OR</span>
                                            @endif
                                        </td>
                                        <td></td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif

                                    <!-- simple-and: mendatory questions -->
                                    @if ($paperQuestion->type_name == 'simple-and')
                                    @php
                                    $alphabets = range('a', 'z');
                                    @endphp
                                    @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                                    <tr>
                                        <td>
                                            @if ($loop->first)
                                            Q.{{ $QNo++ }}
                                            @endif
                                        </td>
                                        <td class="text-left">
                                            {{ $alphabets[$loop->index] }}).{{ $paperQuestionPart->question->statement }}
                                        </td>
                                        <td>({{ $paperQuestionPart->marks }})</td>
                                    </tr>
                                    @endforeach
                                    @endif

                                    <!--Long: poetry -->
                                    @if ($paperQuestion->type_name == 'poetry')
                                    <tr>
                                        <td class="font-bold">Q.{{ $QNo++ }}</td>
                                        <td class="text-left font-bold">
                                            {{ $paperQuestion->question_title }}
                                        </td>
                                        <td>({{ $paperQuestion->marks }})
                                        </td>
                                    </tr>
                                    @foreach ($paperQuestion->paperQuestionParts->first()->question->paraphrasings as $stanza)
                                    <tr>
                                        <td></td>
                                        <td class="text-left">{{ $stanza->poetry_line }}
                                        </td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    @endforeach <!-- end questions -->

                                </tbody>
                            </table>
                            @endif <!-- end if paper has questions -->

                            </td>
                            @endfor
                            </tr>
                            <!-- rowspacing between each row of papers -->
                            <tr>
                                <td class="py-4" colspan="{{ $columns }}"></td>
                            </tr>
                            @endfor
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>