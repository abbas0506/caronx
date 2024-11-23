<style>
    /* Custom styles for the animated underline */
    .animated-underline {
        position: relative;
        display: inline-block;
    }

    .animated-underline::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -4px;
        height: 2px;
        /* Adjust height as needed */
        width: 100%;
        background-color: #0D9488;
        /* Tailwind's blue-500 */
        transform: scaleX(0);
        transition: transform 0.25s ease;
        transform-origin: bottom center;
    }

    .animated-underline:hover::after {
        transform: scaleX(1);
        transform-origin: bottom center;
    }
</style>

<header class="sticky-header" id='header'>
    <div class="flex flex-wrap justify-between items-center w-full">
        <a href="{{ url('/') }}" class="flex text-xl flex-wrap font-bold items-center">
            <img src="{{ url('images/logo/app-logo.png') }}" alt="" class="w-8">
            <div class="text-lg font-medium ml-2">Dr Sajjad Sarwar</div>

        </a>
        <nav id='navbar' class="navbar">
            <ul>
                <li class="float-right md:hidden" onclick="toggleNavbarMobile()">
                    <i class="bi-x-lg text-xl text-orange-300 hover:-rotate-90 transition duration-500 ease-in-out"></i>
                </li>
                <li><a href="{{ url('/') }}" class="nav-item animated-underline">Home</a></li>
                <li><a href="#" class="nav-item animated-underline">About</a></li>
                <li><a href="#" class="nav-item animated-underline">Services</a></li>
                <li><a href="#" class="nav-item animated-underline">Packages</a></li>
                <li><a href="#" class="nav-item animated-underline">Contact Us</a></li>
                <li><a href="{{ url('login') }}" class="nav-item animated-underline">Login</a></li>
            </ul>
        </nav>

        <button class="md:hidden" onclick="toggleNavbarMobile()" id='menu'>
            <!-- menu -->
            <i class="bi-list text-lg"></i>
        </button>
    </div>
</header>
<script>
    var header = document.getElementById("header");
    window.onscroll = function() {
        if (window.pageYOffset > 5) {
            header.classList.add("scrolled-down");
        } else {
            header.classList.remove("scrolled-down");
        }
    };

    function toggleNavbarMobile() {
        $('#navbar').toggleClass('mobile');
    }

    function showLoginModal() {
        $('#loginModal').addClass('shown')
    }
</script>