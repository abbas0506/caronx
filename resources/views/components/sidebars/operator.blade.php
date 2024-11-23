<aside aria-label="Sidebar" id='sidebar'>
    <div class="flex items-center justify-center w-full mt-16">
        <a href="{{url('/')}}" class="">
            <img alt="logo" src="{{asset('images/logo/app-logo.png')}}" class="w-16">
        </a>
    </div>
    <a href="{{url('/')}}" class="mt-8 font-bold text-center uppercase tracking-wide">Exampixel</a>
    <div class="text-xs text-center text-green-600">Data Entry</div>

    @if(Auth::user()->roles->count()>1)
    <div class="grid gap-2 mt-4 text">
        @foreach(Auth::user()->roles as $role)
        @if($role->name!='operator')
        <a href="{{ url('switch/as',$role->name) }}" class="btn btn-teal text-xs font-normal text-center rounded">Switch to {{ $role->name }} </a>
        @endif
        @endforeach
    </div>
    @endif

    <div class="mt-12">
        <ul class="space-y-2">
            <li>
                <a href="{{url('/')}}" class="flex items-center p-2">
                    @if($page=='home')
                    <i class="bi-house current-page"></i>
                    @else
                    <i class="bi-house"></i>
                    @endif
                    <span class="ml-2">Home</span>
                </a>
            </li>
            <li>
                <a href="{{route('operator.books.index')}}" class="flex items-center justify-between p-2">
                    <div>
                        <i class="bi bi-database-gear @if($page=='questions') current-page @endif"></i>
                        <span class="ml-2">Questions </span>
                    </div>
                    <div class="text-xs px-1 rounded-full bg-orange-400 text-slate-100 "></div>
                </a>
            </li>
        </ul>
    </div>
</aside>