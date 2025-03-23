<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer Key</title>
    <link href="{{public_path('css/pdf_tw.css')}}" rel="stylesheet">
    <!-- <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script> -->

    <style>
        @page {
            margin: 50px 80px 50px 80px;
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
            font-size: 12px;
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
        <div class="custom-container text-sm">
            <table class="w-full">
                <tbody>
                    <tr>
                        <td colspan="2" class="text-center p-3 font-bold text-base">{{$paper->title}}</td>
                    </tr>
                    <tr>
                        <td class="text-left">{{$paper->course->name}}</td>
                        <td class="text-right">Dated: {{$paper->paper_date->format('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div style="border-style:solid; border-width:0px 0px 0.5px 0px;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="py-2 font-bold">Answer Key</td>
                    </tr>

                </tbody>
            </table>
            <div style="border-style:solid; border-width:0px 0px 0.5px 0px;"></div>

            @if($paper->paperQuestions()->mcqs()->count()>0)
            <table class="table-auto w-32 mx-auto">
                <thead>
                    <tr>
                        <th>Q.</th>
                        <th>Answer</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($paper->paperQuestions()->mcqs()->get() as $paperQuestion)
                    @foreach($paperQuestion->paperQuestionParts as $paperQuestionPart)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ ucfirst($paperQuestionPart->question->mcq->correct)}}</td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </main>
</body>

</html>