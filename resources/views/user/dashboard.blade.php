@extends('layouts.basic')
@section('header')
<x-headers.user page="Welcome back!" icon="<i class='bi bi-emoji-smile'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.user page='home'></x-sidebars.user>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb mt-2">
                <div>Dashboard</div>
                <i class="bx bx-chevron-right"></i>
                <i class="bi-house"></i>
            </div>


        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <!-- pallets -->
        <div class="grid mt-2">
            <a href="{{ route('user.profiles.edit', Auth::user()) }}" class="flex items-center pallet-box">
                <div class="flex flex-1 items-center space-x-3">
                    <div>
                        <img src="{{ url('images/icons/profile-0.png') }}" alt="avatar" class="w-16 h-16">
                    </div>
                    <div>
                        <h2 class="text-slate-600">Profile Status</h2>
                        <label>{{ $profileStatus }} % complete </label>
                    </div>

                </div>
                <div class="w-16 h-16">
                    <canvas id="profileStatusChart"></canvas>
                </div>
            </a>
        </div>

        <div class="grid w-full p-5 bg-gradient-to-b  from-teal-50 to-slate-50 border border-teal-100 rounded-lg text-xs md:text-sm mt-8">
            <h2 class="text-left">Do you know?</h2>
            <p class="text-left">Question paper is generated in 4 steps</p>
            <ul class="list-decimal pl-5 list-inside leading-relaxed">
                <li>Selection of grade & subject</li>
                <li>Selection of chapters</li>
                <li>Random selection of questions</li>
                <li>Setting printing option and taking print</li>
            </ul>

        </div>
        <div class="grid place-items-center mt-8">
            <a href="{{ route('user.papers.create') }}" class="btn btn-blue rounded px-6 py-3">Generate Paper Now</a>
        </div>

        <div class="bg-white w-full mt-8">
            @if(Auth::user()->papers->count()>0)
            <h2>My Recent Papers </h2>
            <div class="overflow-x-auto w-full mt-3">
                <table class="table-fixed w-full sm">
                    <thead>
                        <tr>
                            <th class="w-16">Sr</th>
                            <th class="w-96">Title</th>
                            <th class="w-32">Date</th>
                            <th class="w-24">Q.Paper</th>
                            <th class="w-24">Ans Key</th>
                        </tr>
                    <tbody>
                        @php $sr=1; @endphp
                        @foreach(Auth::user()->papers->sortByDesc('id')->take(5) as $paper)
                        <tr>
                            <td>{{$sr++}}</td>
                            <td class="text-left">
                                <a href="{{route('user.papers.show',$paper)}}" class="link">{{$paper->title}}</a>
                                <br>
                                <label>{{$paper->course->name}}</label>
                            </td>
                            <td>{{$paper->paper_date->format('d/m/Y')}}</td>
                            <td><a href="{{route('user.papers.simple-pdf.create',$paper)}}"><i class="bi-printer"></i></a></td>
                            <td><a href="{{route('user.papers.keys.show',$paper)}}"><i class="bi-key"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                    </thead>
                </table>
            </div>
            @else
            <div class="text-slate-400 text-center">Currently no data found!</div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('profileStatusChart').getContext('2d');
        const profileStatusChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                // labels: ['Red', 'Blue', 'Yellow'],
                datasets: [{
                    // label: 'My Dataset',
                    data: @json($data['values']),
                    backgroundColor: ['teal', 'lightgray'],
                    borderColor: ['teal', 'gray'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                cutout: '60%'
            }
        });
    });
</script>

@endsection