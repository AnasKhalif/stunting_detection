@extends('core.app')

@section('title')
    Artikel
@endsection

@section('content')
    <section class="px-4 lg:px-10 lg:my-32 my-24">
        <div class="mx-auto py-2 px-6 rounded-tl-2xl rounded-br-2xl shadow-shadow-card bg-green-800 text-white w-fit mb-10">
            <h2 class="text-2xl font-bold text-center lg:text-xl">Artikel</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 rounded mt-6">
            @foreach ($articles as $article)
                <div class="flex flex-col shadow-md rounded-3xl p-5 group hover:cursor-pointer">
                    <div class="w-full overflow-hidden rounded-2xl">
                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                            class="w-full h-56 object-cover rounded-2xl duration-300 ease-out group-hover:scale-125" />
                    </div>
                    <h1 class="font-bold mt-2 group">{{ $article->title }}</h1>
                    <p class="group text-sm text-neutral-500 truncate">
                        {{ $article->body }}
                    </p>
                    <a href="{{ route('artikel.show', $article->id) }}"
                        class="font-semibold w-full mt-4 bg-green-700 text-white rounded-full py-3 text-xs text-center">
                        Baca Selengkapnya
                    </a>
                </div>
            @endforeach
        </div>
        <!-- Pagination -->
        <div class="mt-6">
            {{ $articles->links() }} <!-- Menampilkan link pagination -->
        </div>
    </section>
@endsection
