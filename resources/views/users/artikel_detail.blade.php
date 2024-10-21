@extends('core.app')

@section('title')
    {{ $article->title }} - Detail Artikel
@endsection

@section('content')
    <section class="px-4 lg:px-10 lg:my-32">
        <h2 class="text-3xl font-bold text-center mb-4">{{ $article->title }}</h2>
        <div class="flex justify-center mb-6">
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                class="w-full max-w-md rounded-2xl shadow-lg">
        </div>
        <div class="text-lg text-neutral-600">
            <p>{{ $article->body }}</p>
        </div>
        <div class="mt-6 text-center">
            <a href="{{ route('artikel') }}"
                class="font-semibold w-full max-w-xs bg-green-700 text-white rounded-full py-3 text-xs block mx-auto">
                Kembali ke daftar artikel
            </a>
        </div>
    </section>
@endsection
