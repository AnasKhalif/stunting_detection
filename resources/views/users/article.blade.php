@extends('layouts.guest')

@section('title')
    Article Stunting
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Daftar Artikel Stunting</h1>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            @foreach ($articles as $article)
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-bold">{{ $article->title }}</h2>
                    <p class="text-gray-700 mt-2">{{ Str::limit($article->body, 150) }}</p>
                    <div class="mt-4">
                        <a href="" class="text-blue-500 hover:underline">Baca
                            selengkapnya</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $articles->links() }}
        </div>
    </div>
@endsection
