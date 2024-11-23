@extends('layouts.basic')

@section('header')
<x-headers.user page="Welcome back!" icon="<i class='bi bi-emoji-smile'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='home'></x-sidebars.admin>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb">
                <div>Admin</div>
                <i class="bx bx-chevron-right"></i>
                <i class="bi-house"></i>
            </div>
            <div class="md:hidden text-slate-500">Welcome back!</div>
        </div>

        <!-- pallets -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.books.index') }}" class="pallet-box">
                <div class="flex-1">
                    <div class="title">Questions</div>
                    <div class="flex items-center space-x-4">
                        <div class="h2">{{$questions->count()}}</div>
                        @if($questions->where('created_at', today())->count())
                        <div><i class="bi-arrow-up"></i>{{ $questions->where('created_at', today())->count() }}</div>
                        @endif

                    </div>
                </div>
                <div class="ico bg-green-100">
                    <i class="bi bi-question-circle text-green-600"></i>
                </div>
            </a>
            <a href="" class="pallet-box">
                <div class="flex-1">
                    <div class="title">Recent Questions</div>
                    <div class="h2">{{$questions->where('created_at',today())->count()}}</div>
                </div>
                <div class="ico bg-indigo-100">
                    <i class="bi bi-person-workspace text-indigo-400"></i>
                </div>
            </a>
            <a href="" class="pallet-box">
                <div class="flex-1 ">
                    <div class="title">Recent Subscription</div>
                    <div class="h2">%</div>
                </div>
                <div class="ico bg-teal-100">
                    <i class="bi bi-card-checklist text-teal-600"></i>
                </div>
            </a>
            <a href="" class="pallet-box">
                <div class="flex-1">
                    <div class="title">Recent Payments</div>
                    <div class="h2"> %</div>
                </div>
                <div class="ico bg-sky-100">
                    <i class="bi bi-graph-up text-sky-600"></i>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 mt-8 gap-4 rounded">
            <!-- middle panel  -->
            <div class="md:col-span-3">
                <!-- update news  -->
                <div class="p-4 bg-white border rounded-lg">
                    <h2>Most Recent</h2>
                    <div class="divider my-3 border-slate-200"></div>
                    <!-- <div class="divider my-3 border-slate-200"></div> -->
                    <div class="overflow-x-auto mt-4">
                        <table class="table-fixed borderless w-full">
                            <thead>
                                <tr class="">
                                    <th class="w-10">Sr</th>
                                    <th class='w-60'>Question</th>
                                    <th class="w-24">Subject</th>
                                    <th class='w-24'>Created_at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $sr=1;
                                @endphp
                                @foreach($questions->sortByDesc('id')->take(20) as $question) <tr class="tr">
                                    <td>{{$sr++}}</td>
                                    <td class=" text-left">{{ $question->statement }}</td>
                                    <td>{{ $question->chapter->book->name }}</td>
                                    <td>{{ $question->created_at }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
            <!-- middle panel end -->
            <!-- right side bar starts -->
            <div class="">
                <div class="bg-white p-4 border rounded-lg">
                    <h2>Profile</h2>
                    <div class="flex flex-col">
                        <div class="flex text-sm mt-4">
                            <div class="w-8"><i class="bi-person"></i></div>
                            <div>{{ Auth::user()->name }}</div>
                        </div>
                        <div class="flex text-sm mt-2">
                            <div class="w-8"><i class="bi-envelope-at"></i></div>
                            <div>{{ Auth::user()->email }}</div>
                        </div>
                        <div class="divider border-blue-200 mt-4"></div>
                        <div class="flex text-sm mt-4">
                            <div class="w-8"><i class="bi-key"></i></div>
                            <a href="{{route('passwords.edit', Auth::user()->id)}}" class="link">Change Password</a>
                        </div>
                    </div>
                </div>

            </div>
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