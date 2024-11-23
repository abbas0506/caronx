@extends('layouts.basic')
@section('header')
<x-headers.user page="Welcome back!" icon="<i class='bi bi-emoji-smile'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.collaborator page='home'></x-sidebars.collaborator>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb">
                <div>Collabrator</div>
                <i class="bx bx-chevron-right"></i>
                <i class="bi-house"></i>
            </div>
            <div class="md:hidden text-slate-500">Welcome back!</div>
        </div>


        <!-- pallets -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
            <a href="" class="flex items-center pallet-box">
                <div class="flex flex-1 items-center space-x-3">
                    <div>
                        <img src="{{ url('images/small/tick-mark.png') }}" alt="tick" class="w-12 h-12">
                    </div>
                    <div>
                        <h2 class="text-slate-600">Approved Questions</h2>
                        @if($questions->whereNotNull('approver_id')->count())
                        <label>My contribution: {{ round($questions->where('approver_id', Auth::user()->id)->count()/$questions->whereNotNull('approver_id')->count()*100,0)}} %</label>
                        @else
                        <label>My contribution: 0%</label>
                        @endif
                    </div>

                </div>
                <div class="ico bg-green-100 text-green-600">
                    {{ $questions->where('approver_id', Auth::user()->id)->count() }}
                </div>
            </a>

            <a href="" class="flex items-center pallet-box">
                <div class="flex flex-1 items-center space-x-3">
                    <div>
                        <img src="{{ url('images/small/payment.png') }}" alt="wallet" class="w-10 h-10">
                    </div>
                    <div>
                        <h2 class="text-slate-600">My Wallet</h2>
                        <label> Expires at: @if(Auth::user()->sales->count()) {{ Auth::user()->sales->max('expiry_at')->format('d/m/Y')}}@endif</label>
                    </div>

                </div>
                <div class="ico bg-green-100 text-green-600">
                    {{ Auth::user()->coins() }}
                </div>
            </a>

        </div>

        <div class="grid place-items-center h-40">
            <a href="{{ route('collaborator.grades.index') }}" class="btn btn-blue rounded px-6 py-3">Start Approving Now</a>
        </div>

        <div class="grid">
            <div class="md:col-span-2">
                <div class="p-4 bg-white">
                    <h2>My Recent Approvals</h2>
                    <div class="divider my-3 border-slate-200"></div>
                    <div class="overflow-x-auto mt-4">
                        <table class="table-fixed borderless w-full">
                            <thead>
                                <tr class="">
                                    <th class="w-8">Sr</th>
                                    <th class='w-60 text-left'>Question</th>
                                    <th class='w-6'>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questions->whereNotNull('approver_id')->sortByDesc('updated_at')->take(5) as $question) <tr class="tr">
                                    <td>{{ $loop->index+1 }}</td>
                                    <td class=" text-left">{{ $question->statement }}</td>
                                    <td>{{ $question->type->name }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
    @endsection