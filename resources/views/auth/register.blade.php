@extends('auth.main')

@section('title')
    Register
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
                <p class="mb-4 text-gray-400 text-sm text-center">Cegah stunting, selamatkan generasi masa depan. Mulai dari
                    sini</p>

                <!-- form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm mb-2 text-gray-400">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                            class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                        @if ($errors->has('name'))
                            <span class="text-red-500 text-sm">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm mb-2 text-gray-400">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                        @if ($errors->has('email'))
                            <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm mb-2 text-gray-400">Password</label>
                        <input type="password" id="password" name="password" required
                            class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                        @if ($errors->has('password'))
                            <span class="text-red-500 text-sm">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm mb-2 text-gray-400">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                        @if ($errors->has('password_confirmation'))
                            <span class="text-red-500 text-sm">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="grid my-6">
                        <button type="submit" class="btn py-[10px] text-base text-white font-medium hover:bg-blue-700">Sign
                            Up</button>
                    </div>

                    <div class="flex justify-center gap-2 items-center">
                        <p class="text-base font-semibold text-gray-400">Already have an Account?</p>
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Sign
                            In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
