{{-- <header class="fixed h-[12vh] top-0 flex bg-white w-full shadow-md px-4 lg:px-10">
    <div class="flex w-full justify-between items-center align-middle">
        <h1 class="text-lg font-bold"><span class="text-green-700">Stunting</span> Check</h1>
        <nav class="lg:flex justify-center h-full relative gap-x-4 hidden">
            <a href="{{ route('home') }}"
                class="flex justify-center items-center font-medium text-sm w-full h-full duration-500 ease-out px-5 border-b-2 border-green-700 {{ request()->is('/') ? 'border-green-700 text-green-700' : 'border-transparent text-neutral-600' }}">
                Home
            </a>
            <a href="/about"
                class="flex justify-center items-center border-b font-medium text-sm w-full h-full duration-500 ease-out px-5 {{ request()->is('about') ? 'border-b-2 border-green-700 text-green-700' : 'border-transparent text-neutral-600' }}">
                About
            </a>
            <a href="{{ route('kalkulator.create') }}"
                class="flex justify-center items-center border-b font-medium text-sm w-full h-full duration-500 ease-out px-5 {{ request()->is('calculator') ? 'border-b-2 border-green-700 text-green-700' : 'border-transparent text-neutral-600' }}">
                Calculator
            </a>
            <a href="{{ route('artikel') }}"
                class="flex justify-center items-center border-b font-medium text-sm w-full h-full duration-500 ease-out px-5 {{ request()->is('artikel') ? 'border-b-2 border-green-700 text-green-700' : 'border-transparent text-neutral-600' }}">
                Artikel
            </a>
        </nav>
        <div class="flex items-center align-middle gap-x-4">
            <a href="{{ route('login') }}"
                class="flex items-center align-middle px-8 h-10 text-xs rounded-full bg-green-700 hover:bg-green-800 text-white font-semibold">
                Sign In
            </a>
        </div>
    </div>
</header> --}}


<header class="fixed h-[12vh] top-0 flex bg-white w-full shadow-md px-4 lg:px-10 z-50">
    <div class="flex w-full justify-between items-center align-middle">
        <h1 class="text-lg font-bold"><span class="text-green-700">Stunting</span> Check</h1>

        <!-- Button Hamburger -->
        <button id="menu-btn" class="block lg:hidden text-gray-600 focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <!-- Nav Menu -->
        <nav id="menu" class="lg:flex justify-center h-full relative gap-x-4 hidden w-full lg:w-auto lg:flex">
            <a href="{{ route('home') }}"
                class="flex justify-center items-center font-medium text-sm w-full h-full duration-500 ease-out px-5 border-b-2 border-green-700 {{ request()->is('/') ? 'border-green-700 text-green-700' : 'border-transparent text-neutral-600' }}">
                Home
            </a>
            <a href="/about"
                class="flex justify-center items-center border-b font-medium text-sm w-full h-full duration-500 ease-out px-5 {{ request()->is('about') ? 'border-b-2 border-green-700 text-green-700' : 'border-transparent text-neutral-600' }}">
                About
            </a>
            <a href="{{ route('kalkulator.create') }}"
                class="flex justify-center items-center border-b font-medium text-sm w-full h-full duration-500 ease-out px-5 {{ request()->is('calculator') ? 'border-b-2 border-green-700 text-green-700' : 'border-transparent text-neutral-600' }}">
                Calculator
            </a>
            <a href="{{ route('artikel') }}"
                class="flex justify-center items-center border-b font-medium text-sm w-full h-full duration-500 ease-out px-5 {{ request()->is('artikel') ? 'border-b-2 border-green-700 text-green-700' : 'border-transparent text-neutral-600' }}">
                Artikel
            </a>
        </nav>

        <!-- Sign In Button -->
        <div class="hidden lg:flex items-center align-middle gap-x-4">
            <a href="{{ route('login') }}"
                class="flex items-center align-middle px-8 h-10 text-xs rounded-full bg-green-700 hover:bg-green-800 text-white font-semibold">
                Sign In
            </a>
        </div>
    </div>

    <!-- Dropdown Menu for Mobile -->
    <div id="dropdown-menu" class="hidden absolute top-[12vh] left-0 w-full bg-white shadow-lg lg:hidden">
        <nav class="flex flex-col items-center space-y-4 py-4">
            <a href="{{ route('home') }}"
                class="text-neutral-600 font-medium text-sm {{ request()->is('/') ? 'text-green-700' : '' }}">Home</a>
            <a href="/about"
                class="text-neutral-600 font-medium text-sm {{ request()->is('about') ? 'text-green-700' : '' }}">About</a>
            <a href="{{ route('kalkulator.create') }}"
                class="text-neutral-600 font-medium text-sm {{ request()->is('calculator') ? 'text-green-700' : '' }}">Calculator</a>
            <a href="{{ route('artikel') }}"
                class="text-neutral-600 font-medium text-sm {{ request()->is('artikel') ? 'text-green-700' : '' }}">Artikel</a>
            <a href="{{ route('login') }}"
                class="text-neutral-600 font-medium text-sm bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-full">
                Sign In
            </a>
        </nav>
    </div>
</header>
