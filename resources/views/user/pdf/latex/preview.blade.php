\documentclass[addpoints]{exam}
\renewcommand{\thepartno}{\roman{partno}}
\usepackage[{{ $fontSize }}pt]{extsizes}
\usepackage{amsfonts}
\usepackage{mathrsfs}
\usepackage{amsmath}
\usepackage{adjustbox}
\usepackage[left=1cm,right=1cm,top=1cm,bottom=1cm,{{ $orientation }},{{ $pageSize }}paper]{geometry}
\usepackage{polyglossia}
\usepackage{fontspec}
\usepackage[firstpageonly,color={[gray]{0.9}},text=exampixel.com,fontsize=100pt]{draftwatermark}
\usepackage{bidi}
\setmainlanguage{english}
\setotherlanguage{urdu}
\setmainfont{Jameel Noori Nastaleeq.ttf}[Path=/latex/fonts/]
@if ($paper->course->subject->text_direction == 'R')
\renewcommand\thechoice{\ifcase\value{choice}\or ا\or ب\or ج\or د\fi}
\renewcommand\choicelabel{(\thechoice)}
@else
\renewcommand{\choicelabel}{(\alph{choice})}
@endif
{{-- \qformat{\textbf{ {{ __('messages.question_no') }} \thequestion-\thequestiontitle } \hfill
(\totalpoints) } --}}
\newcommand{\cellcontent}{

\begin{center} \large{\uppercase { @if ($paper->institution)
{{ $paper->institution }}
@else
Institution Title
@endif }}\\ \small {{ $paper->title }} \\
{{ $paper->paper_date->format('d/m/Y') }}
\#{{ $paper->id }}
\end{center}
{{ $paper->course->subject->text_direction == 'R' ? $paper->course->subject->name_ur : $paper->course->name }}
\hfill
{{ __('messages.name_or_roll') }}:
\_\_\_\_\_\_\_\_\_\_\_\_

\vspace{2mm} \hrule \vspace{2mm}
{{ __('messages.total_marks') }} : {{ $paper->paperQuestions->sum('marks') }} \hfill
{{ __('messages.time') }} :
{{ $paper->suggestedTime() }}
\vspace{2mm} \hrule \vspace{1mm}
\begin{questions}
@foreach ($paper->paperQuestions as $paperQuestion)
@if ($paperQuestion->type_name == 'mcq')
\question{ {{ $paperQuestion->question_title }} }\hfill ({{ $paperQuestion->marks }})
\begin{parts}
@foreach ($paperQuestion->paperQuestionParts as $part)
\part
{!! Helper::parseTex($part->question->statement, true) !!}\\
\begin{oneparchoices}
\choice {!! Helper::parseAnswer($part->question->mcq->choice_a) !!}
\choice {!! Helper::parseAnswer($part->question->mcq->choice_b) !!}
\choice {!! Helper::parseAnswer($part->question->mcq->choice_c) !!}
\choice {!! Helper::parseAnswer($part->question->mcq->choice_d, true) !!}
\end{oneparchoices}
@endforeach
\end{parts}
\dotfill
@endif
@if ($paperQuestion->type_name == 'partial')
\question{ {{ $paperQuestion->question_title }} }\hfill ({{ $paperQuestion->marks }})
\begin{parts}
@foreach ($paperQuestion->paperQuestionParts as $part)
\part
@if (in_array($part->question->type_id, [20]))
\begin{RTL}
@endif
{!! Helper::parseTex($part->question->statement) !!}
@if (in_array($part->question->type_id, [20]))
\end{RTL}
@endif
@endforeach
\end{parts}
{{-- \hspace{0.5mm} --}}
@endif
@if ($paperQuestion->type_name == 3)
\question{
{!! Helper::parseTex($paperQuestion->question_title) !!}
}\hfill({{ $paperQuestion->marks }})
\begin{parts}
\part
{!! Helper::parseTex($paperQuestion->paperQuestionParts()->first()->question->statement) !!}
\end{parts}
@endif

@if ($paperQuestion->type_name == 'simple')
\question{
@if ($paperQuestion->question_title)
{!! Helper::parseTex($paperQuestion->question_title) !!}
@else
{!! Helper::parseTex($paperQuestion->paperQuestionParts()->first()->question->statement) !!}
@endif
} \hfill ({{ $paperQuestion->marks }})
@if ($paperQuestion->question_title)
{!! Helper::parseTex($paperQuestion->paperQuestionParts()->first()->question->statement) !!}
@endif
\begin{parts}
@foreach ($paperQuestion->paperQuestionParts->first()->question->comprehensions as $comprehension)
\part
{!! Helper::parseTex($comprehension->sub_question) !!}
@endforeach
\end{parts}
@endif
@if ($paperQuestion->type_name == 'simple-or')
\question{
@if ($paperQuestion->question_title)
{!! Helper::parseTex($paperQuestion->question_title) !!}
@endif
}\hfill ({{ $paperQuestion->marks }})\\
@foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
{!! Helper::parseTex($paperQuestionPart->question->statement) !!}
@if (!$loop->last)
\textbf{ {{ __('messages.or') }} } \\
@endif
@endforeach
@endif
@if ($paperQuestion->type_name == 'simple-and')
\question{
@if ($paperQuestion->question_title)
{!! Helper::parseTex($paperQuestion->question_title) !!}
@endif
} \hfill ({{ $paperQuestion->marks }})
\begin{parts}
@forelse ($paperQuestion->paperQuestionParts as $paperQuestionPart)
\part {!! Helper::parseTex($paperQuestionPart->question->statement) !!}
@endforeach
\end{parts}
@endif

@if ($paperQuestion->type_name == 7)
\question{
{{ $paperQuestion->question_title }}
}\hfill ({{ $paperQuestion->marks }})
\begin{parts}
@foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
\part {!! Helper::parseTex($paperQuestionPart->question->statement) !!}
@endforeach
\end{parts}
@endif
@if ($paperQuestion->type_name == 9)
\question{
{{ $paperQuestion->question_title }}
}\hfill ({{ $paperQuestion->marks }})
\begin{parts}
@foreach ($paperQuestion->paperQuestionParts->first()->question->paraphrasings as $stanza)
\part
{!! Helper::parseTex($stanza->poetry_line) !!}
@endforeach
\end{parts}
@endif

@if ($paperQuestion->type_name == 10)
\question{
{{ $paperQuestion->question_title }}
} \hfill ({{ $paperQuestion->marks }})
{!! Helper::parseTex($paperQuestion->paperQuestionParts->first()->question->statement) !!}
\begin{parts}
@foreach ($paperQuestion->paperQuestionParts->first()->question->comprehensions as $comprehension)
\part
{!! Helper::parseTex($comprehension->sub_question) !!}
@endforeach
\end{parts}
@endif
@if ($paperQuestion->type_name == 'partial-x')
\question{
{{ $paperQuestion->question_title }}
} \hfill ({{ $paperQuestion->marks }})
\begin{oneparchoices}
@foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
\choice
{!! Helper::parseTex($paperQuestionPart->question->statement) !!}
@endforeach
\end{oneparchoices}
@endif
@if ($paperQuestion->type_name == 'poetry')
\question{
{{ $paperQuestion->question_title }}
} \hfill ({{ $paperQuestion->marks }})
\begin{parts}
@foreach ($paperQuestion->paperQuestionParts->first()->question->paraphrasings as $stanza)
\part
{!! Helper::parseTex($stanza->poetry_line) !!}
@endforeach
\end{parts}
@endif
@endforeach
\end{questions}
}
\begin{document}
@if ($paper->course->subject->text_direction == 'R')
\begin{RTL}
@endif
@if ($rows == 1)
\cellcontent
@elseif($rows == 2)
\cellcontent \dotfill \cellcontent
@elseif($rows == 3)
\cellcontent \dotfill \cellcontent \dotfill \cellcontent
@endif

{{--
\newpage
\begin{center}
\textbf{Answer Key for MCQs}\\
@php
    $mcqs = $paper->paperQuestions->where('type_name', 'mcq')->first()->paperQuestionParts;
@endphp
\begin{tabular}{
@for ($i = 0; $i <= $mcqs->count(); $i++)
    | c
@endfor
|
}
\hline
@foreach ($mcqs as $part)
    \#{{ $loop->index + 1 }} &
@endforeach
\\
\hline
@foreach ($mcqs as $part)
\textbf{ {{ $part->question->mcq->correct }} } &
@endforeach
\\
\hline
\end{tabular}\\
\vspace{2mm}
{{-- \textbf{Grade Table}\\ --}}
{{-- \vspace{2mm} --}}
{{-- \gradetable[v][questions] --}}
{{-- \end{center}  --}}

@if ($paper->course->subject->text_direction == 'R')
\end{RTL}
@endif
\end{document}