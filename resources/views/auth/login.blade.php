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
                    <h1 class="text-xl font-bold"><span class="text-green-700">Stunting</span> Check</h1>
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
                            class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-green-700 focus:ring-0"
                            value="{{ old('email') }}" required autofocus />
                        @if ($errors->has('email'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <!-- password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm mb-2 text-gray-400">Password</label>
                        <input type="password" id="password" name="password"
                            class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-green-700 focus:ring-0"
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
                        <a class="underline text-sm text-gray-600 hover:text-gray-900"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>

                    </div>

                    <!-- button -->
                    <div class="grid my-6">
                        <button type="submit"
                            class="btn py-[10px] text-base text-white font-medium bg-green-700 hover:bg-green-700">Sign
                            In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
