@extends('layouts.app')

@section('title')
    Admin - Create Article
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-lg font-semibold text-gray-500 ml-5 mt-4">{{ __('Article') }}</div>
                    <div class="card-body flex flex-col gap-6">
                        <form method="POST" action="{{ route('article.store') }}">
                            @csrf

                            <div class="mb-6">
                                <label for="title" class="block text-sm mb-2 text-gray-400">{{ __('Title') }}</label>
                                <input id="title" type="text"
                                    class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('title') is-invalid @enderror"
                                    name="title" value="{{ old('title') }}" required autocomplete="title"
                                    placeholder="Title" autofocus>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="body" class="block text-sm mb-2 text-gray-400">{{ __('Body') }}</label>
                                <textarea name="body" id="body" cols="30" rows="3" required autocomplete="body"
                                    class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('body') is-invalid @enderror">{{ old('body') }}</textarea>
                                @error('body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="published"
                                    class="block text-sm mb-2 text-gray-400">{{ __('Published') }}</label>
                                <select name="published" id="published"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('published') is-invalid @enderror">
                                    <option value="0" {{ old('published') == 0 ? 'selected' : '' }}>Unpublished
                                    </option>
                                    <option value="1" {{ old('published') == 1 ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('published')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="flex justify-end">
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
