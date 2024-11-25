@extends('layouts.app')

@section('title')
    Admin - Edit Article
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header flex justify-between items-center ml-5">
                        <h2 class="text-lg font-semibold">Edit Article</h2>
                        <a href="{{ route('article.index') }}" class="btn btn-sm bg-green-500 mr-5 mt-5">Back</a>
                    </div>

                    <div class="card-body flex flex-col gap-6">
                        <form method="POST" action="{{ route('article.update', $article->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-6">
                                <label for="title" class="block text-sm mb-2 text-gray-400">{{ __('Title') }}</label>
                                <input id="title" type="text"
                                    class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('title') is-invalid @enderror"
                                    name="title" value="{{ $article->title }}" required autocomplete="title"
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
                                    class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('body') is-invalid @enderror">{{ $article->body }}</textarea>
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
                                    <option value="0" {{ $article->published == 0 ? 'selected' : '' }}>Unpublished
                                    </option>
                                    <option value="1" {{ $article->published == 1 ? 'selected' : '' }}>Published
                                    </option>
                                </select>
                                @error('published')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="image" class="block text-sm mb-2 text-gray-400">{{ __('Image') }}</label>
                                <input id="image" type="file"
                                    class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('image') is-invalid @enderror"
                                    name="image" accept="image/*">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <!-- Menampilkan gambar yang ada saat ini -->
                                @if ($article->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $article->image) }}" alt="Current Image"
                                            class="w-full max-w-md rounded-2xl shadow-lg">
                                        <p class="text-sm text-gray-500 mt-1">Current Image</p>
                                    </div>
                                @endif
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="btn text-base py-2.5 text-white font-medium w-fit hover:bg-blue-700">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
