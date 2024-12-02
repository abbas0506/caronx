<header class="user-header">
    <div class="flex flex-wrap w-full h-16 items-center justify-between px-4 md:px-6 shadow-sm">

        <div class="flex items-center">
            <a href="{{ url('/') }}" class="flex text-xl flex-wrap font-bold items-center">
                <img src="{{ url('images/logo/q.png') }}" alt="" class="w-6">
                <div class="text-lg font-medium">uiz</div>

            </a>
        </div>
        <div id=" current-user-area" class="flex space-x-3 items-center justify-center relative">
            <label for="toggle-current-user-dropdown" class="hidden md:flex items-center">
                <div class="">{{ Auth::user()->name }}</div>
            </label>
            <div id='menu' class="flex md:hidden">
                <i class="bi bi-list"></i>
            </div>
        </div>
    </div>

</header>