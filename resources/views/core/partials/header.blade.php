<header class="fixed h-[12vh] top-0 flex bg-white w-full shadow-md px-4 lg:px-10">
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
</header>
