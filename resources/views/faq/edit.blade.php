@extends('layouts.app')

@section('title')
    Admin - Edit FAQ
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-lg font-semibold text-gray-500 ml-5 mt-4">{{ __('Edit FAQ') }}</div>

                    <div class="card-body flex flex-col gap-6">
                        <form method="POST" action="{{ route('faq.update', $faq->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Question Field -->
                            <div class="mb-6">
                                <label for="question" class="block text-sm mb-2 text-gray-400">{{ __('Question') }}</label>
                                <input id="question" type="text"
                                    class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('question') is-invalid @enderror"
                                    name="question" value="{{ $faq->question }}" required autocomplete="question"
                                    placeholder="Question" autofocus>

                                @error('question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Answer Field -->
                            <div class="mb-6">
                                <label for="answer" class="block text-sm mb-2 text-gray-400">{{ __('Answer') }}</label>
                                <textarea name="answer" id="answer" cols="30" rows="3" required autocomplete="answer"
                                    class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('answer') is-invalid @enderror">{{ $faq->answer }}</textarea>
                                @error('answer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Published Field -->
                            <div class="mb-6">
                                <label for="published"
                                    class="block text-sm mb-2 text-gray-400">{{ __('Published') }}</label>
                                <select name="published" id="published"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 @error('published') is-invalid @enderror">
                                    <option value="0" {{ $faq->published == 0 ? 'selected' : '' }}>Unpublished</option>
                                    <option value="1" {{ $faq->published == 1 ? 'selected' : '' }}>Published</option>
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
