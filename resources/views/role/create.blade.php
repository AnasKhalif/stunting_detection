@extends('layouts.app')

@section('title')
    Admin - Create Role
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-lg font-semibold text-gray-500 ml-5 mt-4">{{ __('Create Role') }}</div>

                    <div class="card-body flex flex-col gap-6">
                        <form method="POST" action="{{ route('admin.role.store') }}">
                            @csrf

                            <div class="mb-6">
                                <label for="name" class="block text-sm mb-2 text-gray-400">{{ __('Name') }}</label>
                                <input id="name" type="text"
                                    class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autofocus>
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
                                    name="display_name" value="{{ old('display_name') }}" required>
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
                                    name="description" value="{{ old('description') }}" required>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="permissions"
                                    class="block text-sm mb-2 text-gray-400">{{ __('Permissions') }}</label>
                                <div class="grid grid-cols-3 gap-4">
                                    @foreach ($permissions as $permission)
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="permissions_id[]" class="form-check-input"
                                                value="{{ $permission->id }}">
                                            <label class="text-gray-500">{{ $permission->display_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-6 flex justify-end">
                                <button type="submit"
                                    class="btn text-base py-2.5 text-white font-medium w-fit hover:bg-blue-700">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
