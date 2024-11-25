@extends('layouts.app')

@section('title')
    Admin - Create User
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header flex justify-between items-center ml-5">
                        <h2 class="text-lg font-semibold">Create User</h2>
                        <a href="{{ route('admin.user.index') }}" class="btn btn-sm bg-green-500 mr-5 mt-5">Back</a>
                    </div>

                    <div class="card-body flex flex-col gap-6">
                        <form method="POST" action="{{ route('admin.user.store') }}">
                            @csrf

                            <div class="mb-6">
                                <label for="name" class="block text-sm mb-2 text-gray-400">{{ __('Name') }}</label>
                                <input id="name" type="text"
                                    class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="email"
                                    class="block text-sm mb-2 text-gray-400">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="password" class="block text-sm mb-2 text-gray-400">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="password-confirm"
                                    class="block text-sm mb-2 text-gray-400">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="mb-6">
                                <label for="role_id" class="block text-sm mb-2 text-gray-400">{{ __('Role') }}</label>
                                <select name="role_id" id="role_id"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('role_id') is-invalid @enderror">
                                    @if (count($roles))
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('role_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="btn text-base py-2.5 text-white font-medium w-fit hover:bg-blue-700">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
