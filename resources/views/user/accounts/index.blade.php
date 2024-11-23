@extends('layouts.basic')
@section('header')
<x-headers.user page="My Account" icon="<i class='bi bi-wallet'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.user page='account'></x-sidebars.user>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb">
                <a href="{{ url('/') }}">Home</a>
                <div>/</div>
                <div>My Account</div>
            </div>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <!-- pallets -->
        <div class="mt-8">
            <a href="" class="flex items-center  pallet-box">
                <div class="flex flex-1 items-center space-x-3">
                    <div>
                        <img src="{{ url('images/small/wallet.png') }}" alt="" class="w-12 h-12">
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


        <div class="p-4 bg-white mt-6 w-full">
            @if(Auth::user()->sales->count()>0)
            <h2>Account Detail </h2>
            <div class="overflow-x-auto w-full mt-3">
                <table class="table-fixed">
                    <thead>
                        <tr>
                            <th class="w-16">Sr</th>
                            <th class="w-96">Remarks</th>
                            <th class="w-32">Date</th>
                            <th class="w-32">Coins</th>
                        </tr>
                    <tbody>
                        @php $sr=1; @endphp
                        @foreach(Auth::user()->sales->sortByDesc('id') as $sale)
                        <tr>
                            <td>{{$sr++}}</td>
                            <td class="text-left">{{$sale->remarks}}</td>
                            <td>{{$sale->created_at->format('d/m/Y')}}</td>
                            <td>{{ $sale->coins }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </thead>
                </table>
            </div>
            @else
            <div class="h-full flex flex-col justify-center items-center">
                <h3 class="text-slate-600">Currently no paper found!</h3>
                <a href="{{ route('user.papers.index') }}" class="btn btn-blue mt-6 rounded">Start Creating Now</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function confirmDel(event) {
        event.preventDefault(); // prevent form submit
        var form = event.target; // storing the form

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
                form.submit();
            }
        })
    }
</script>

@endsection