@extends('auth.main')

@section('title')
    Login
@endsection

@section('content')
    <!-- Main Content -->
    <div
        class="flex flex-col w-full overflow-hidden relative min-h-screen radial-gradient items-center justify-center g-0 px-4">
        <div class="justify-center items-center w-full card lg:flex max-w-md ">
            <div class="w-full card-body">
                <div class="flex justify-center items-center h-full">
                    <a class="text-2xl font-bold text-sky-500 py-4" href="/">Check Stunt</a>
                </div>

                <p class="mb-4 text-gray-400 text-sm text-center">Mulai perjalanan Anda untuk memastikan masa depan sehat
                    bagi anak-anak.</p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 text-green-600 text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm mb-2 text-gray-400">Email</label>
                        <input type="email" id="email" name="email"
                            class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0"
                            value="{{ old('email') }}" required autofocus />
                        @if ($errors->has('email'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <!-- password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm mb-2 text-gray-400">Password</label>
                        <input type="password" id="password" name="password"
                            class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0"
                            required />
                        @if ($errors->has('password'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <!-- remember me -->
                    <div class="flex justify-between">
                        <div class="flex">
                            <input type="checkbox"
                                class="shrink-0 mt-0.5 border-gray-200 rounded-[4px] text-blue-600 focus:ring-blue-500"
                                id="remember_me" name="remember">
                            <label for="remember_me" class="text-sm text-gray-500 ms-3">Remember this Device</label>
                        </div>
                        <a href="{{ route('password.request') }}"
                            class="text-sm font-semibold text-blue-600 hover:text-blue-700">Forgot Password?</a>
                    </div>

                    <!-- button -->
                    <div class="grid my-6">
                        <button type="submit"
                            class="btn py-[10px] text-base text-white font-medium bg-blue-600 hover:bg-blue-700">Sign
                            In</button>
                    </div>

                    <div class="flex justify-center gap-2 items-center">
                        <p class="text-base font-semibold text-gray-400">Don't have an account</p>
                        <a href="{{ route('register') }}"
                            class="text-sm font-semibold text-blue-600 hover:text-blue-700">Create an account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
