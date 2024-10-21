{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

@extends('layouts.app')

@section('title')
    Profile - Edit
@endsection

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h4 class="text-2xl font-bold mb-6">
            <span class="text-gray-500 font-light">Account Settings /</span> Account
        </h4>

        <div class="flex flex-col space-y-6">
            <div class="w-full">
                <div class="bg-white shadow-md rounded-md overflow-hidden">
                    <h5 class="text-lg font-semibold px-6 py-4">Profile Details</h5>

                    <!-- Account -->
                    <div class="p-6">
                        <div class="flex items-start gap-6">
                            <img src="{{ asset('./img/artikel.jpeg') }}" alt="user-avatar"
                                class="block rounded-full h-24 w-24" id="uploadedAvatar">
                            <div class="flex flex-col gap-3">
                                <label for="upload" class="bg-blue-500 text-white px-4 py-2 rounded-md cursor-pointer">
                                    Upload new photo
                                    <input type="file" id="upload" class="hidden" accept="image/png, image/jpeg">
                                </label>
                                <button type="button" class="bg-gray-100 text-gray-500 px-4 py-2 rounded-md">Reset</button>
                                <p class="text-gray-500 text-sm">Allowed JPG, JPEG, or PNG</p>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-200">

                    <div class="p-6">
                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                                <input id="name" name="name" type="text"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                                @error('name')
                                    <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                                <input id="email" name="email" type="email"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('email', $user->email) }}" required autocomplete="username" />
                                @error('email')
                                    <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                                @enderror

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                    <div>
                                        <p class="text-sm mt-2 text-gray-800">
                                            {{ __('Your email address is unverified.') }}
                                            <button form="send-verification"
                                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                {{ __('Click here to re-send the verification email.') }}
                                            </button>
                                        </p>

                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 font-medium text-sm text-green-600">
                                                {{ __('A new verification link has been sent to your email address.') }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md">{{ __('Save') }}</button>

                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>

        <!-- Form Ganti Password -->
        <div class="w-full mt-6">
            <div class="bg-white shadow-md rounded-md overflow-hidden">
                <h5 class="text-lg font-semibold px-6 py-4">Change Password</h5>

                <div class="p-6">
                    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">
                                {{ __('Current Password') }}
                            </label>
                            <input id="current_password" name="current_password" type="password"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                autocomplete="current-password" />
                            @error('current_password')
                                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                {{ __('New Password') }}
                            </label>
                            <input id="password" name="password" type="password"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                autocomplete="new-password" />
                            @error('password')
                                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                {{ __('Confirm Password') }}
                            </label>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                autocomplete="new-password" />
                            @error('password_confirmation')
                                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                                {{ __('Save') }}
                            </button>

                            @if (session('status') === 'password-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Form Ganti Password -->

        <!-- Form Hapus Akun -->
        <section class="space-y-6 mt-6">
            <header>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Delete Account') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                </p>
            </header>

            <x-danger-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete Account') }}</x-danger-button>

            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <div class="mt-6">
                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                            placeholder="{{ __('Password') }}" />

                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button class="ms-3">
                            {{ __('Delete Account') }}
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        </section>
        <!-- /Form Hapus Akun -->
    </div>
@endsection
