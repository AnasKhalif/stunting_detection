@extends('layouts.app')

@section('title')
    Admin - Create Permission
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header flex justify-between items-center ml-5">
                        <h2 class="text-lg font-semibold">Create Permisson</h2>
                        <a href="{{ route('admin.permission.index') }}" class="btn btn-sm bg-green-500 mr-5 mt-5">Back</a>
                    </div>

                    <div class="card-body flex flex-col gap-6">
                        <form method="POST" action="{{ route('admin.permission.store') }}">
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
                                <label for="display_name"
                                    class="block text-sm mb-2 text-gray-400">{{ __('Display Name') }}</label>
                                <input id="display_name" type="text"
                                    class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('display_name') is-invalid @enderror"
                                    name="display_name" value="{{ old('display_name') }}" required
                                    autocomplete="display_name">
                                @error('display_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="description"
                                    class="block text-sm mb-2 text-gray-400">{{ __('Description') }}</label>
                                <input id="description" type="text"
                                    class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('description') is-invalid @enderror"
                                    name="description" value="{{ old('description') }}" required autocomplete="description">
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="btn text-base py-2.5 text-white font-medium w-fit hover:bg-blue-700">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
