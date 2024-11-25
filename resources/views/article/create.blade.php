@extends('layouts.app')

@section('title')
    Admin - Create Article
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header flex justify-between items-center ml-5">
                        <h2 class="text-lg font-semibold">Create Article</h2>
                        <a href="{{ route('article.index') }}" class="btn btn-sm bg-green-500 mr-5 mt-5">Back</a>
                    </div>
                    <div class="card-body flex flex-col gap-6">
                        <form method="POST" action="{{ route('article.store') }}" enctype="multipart/form-data">
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
                                <textarea name="body" id="body" cols="50" rows="30" required autocomplete="body"
                                    class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('body') is-invalid @enderror">{{ old('body') }}</textarea>
                                @error('body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="image" class="block text-sm mb-2 text-gray-400">{{ __('Image') }}</label>
                                <input id="image" type="file"
                                    class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('image') is-invalid @enderror"
                                    name="image" accept="image/*"> <!-- Input untuk upload gambar -->
                                @error('image')
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
