<aside aria-label="Sidebar" id='sidebar'>
    <div class="flex items-center justify-center w-full mt-16">
        <a href="{{url('/')}}" class="">
            <img alt="logo" src="{{asset('images/logo/app-logo.png')}}" class="w-16">
        </a>
    </div>
    <div class="mt-8 font-bold text-center text-orange-300 uppercase tracking-wide">Exampixel</div>
    <div class="text-xs text-center text-green-600">User Panel</div>

    @if(Auth::user()->roles->count()>1)
    <div class="grid gap-2 mt-4 text">
        @foreach(Auth::user()->roles as $role)
        @if($role->name!='user')
        <a href="{{ url('switch/as',$role->name) }}" class="btn btn-teal text-xs font-normal text-center rounded">Switch to {{ $role->name }} </a>
        @endif
        @endforeach
    </div>
    @endif

    <div class="mt-12">
        <ul class="space-y-2">
            <li>
                <a href="{{url('/')}}" class="flex items-center p-2">
                    <i class="bi-house @if($page=='home') current-page @endif"></i>
                    <span class="ml-3">Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.papers.create') }}" class="flex items-center p-2">
                    <i class="bi bi-file-earmark-pdf @if($page=='paper') current-page @endif"></i>
                    <span class="ml-3">Generate Paper</span>
                </a>
            </li>

            <li>
                <a href="{{route('passwords.edit', Auth::user()->id)}}" class="flex items-center p-2">
                    <i class="bi bi-key"></i>
                    <span class="ml-3">Change Password</span>
                </a>
            </li>

    </div>
</aside>