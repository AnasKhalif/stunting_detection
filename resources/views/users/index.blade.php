@extends('layouts.guest')

@section('title')
    Check Stunt
@endsection

@section('content')
    <div class="text-gray-600 antialiased">
        <div class="bg-gray-100">
            <div class="mx-auto max-w-screen-lg px-3 py-6">
                <div class="flex flex-wrap items-center justify-between">
                    <div>
                        <a class="text-2xl font-bold text-sky-500" href="/">Check Stunt</a>
                    </div>
                    <nav class="flex flex-row gap-4">
                        <ul class="navbar flex items-center text-xl font-medium text-gray-800 gap-3">
                            <li><a href="{{ route('article.index') }}">Article</a></li>
                        </ul>
                        <ul class="navbar flex items-center text-xl font-medium text-gray-800 gap-3">
                            <li><a href="{{ route('login') }}">Sign in</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="mx-auto max-w-screen-lg px-3 pt-20 pb-32">
                <header class="text-center">
                    <h1 class="whitespace-pre-line text-5xl font-bold leading-hero text-gray-900">
                        <span class="text-primary-500">Cegah Stunting,</span> Selamatkan Generasi Mendatang
                    </h1>
                    <div class="mb-16 mt-4 text-2xl">
                        Cara mudah dan cepat untuk memeriksa potensi stunting pada anak Anda. Temukan informasi
                        penting untuk tindakan pencegahan.
                    </div>
                    <a href="{{ route('kalkulator.create') }}">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            Cek Potensi Stunting Sekarang
                        </button>
                    </a>

                </header>
            </div>
        </div>

        <div class="mx-auto max-w-screen-lg px-3 py-16">
            <div class="mb-12 text-center">
                <h2 class="text-4xl font-bold text-gray-900">Apa Itu Stunting Pada Anak?</h2>
                <div class="mt-4 text-xl md:px-20">
                    Stunting adalah masalah serius yang dapat menghambat perkembangan anak. Dengan pemeriksaan dini,
                    Anda dapat mengambil langkah proaktif untuk memastikan masa depan yang lebih sehat. Cek sekarang
                    dan dapatkan panduan langkah-langkah pencegahan yang mudah diikuti.
                </div>
            </div>

            <div class="mt-20 flex flex-wrap items-center">
                <div class="w-full text-center sm:w-1/2 sm:px-6">
                    <h3 class="text-3xl font-semibold text-gray-900">Kenali Stunting Sejak Dini</h3>
                    <div class="mt-6 text-xl leading-9">
                        Stunting adalah kondisi kronis yang memengaruhi pertumbuhan fisik dan kognitif anak. Dengan
                        deteksi dini, Anda dapat mencegah dampak jangka panjang yang membahayakan perkembangan anak
                        Anda.
                    </div>
                </div>
                <div class="w-full p-6 sm:w-1/2">
                    <img src="{{ asset('images/feature3.svg') }}" alt="Third feature alt text">
                </div>
            </div>

            <div class="mt-20 flex flex-wrap items-center flex-row-reverse">
                <div class="w-full text-center sm:w-1/2 sm:px-6">
                    <h3 class="text-3xl font-semibold text-gray-900">Masa Depan Tanpa Stunting</h3>
                    <div class="mt-6 text-xl leading-9">
                        Dengan mencegah stunting, Anda memberikan anak Anda kesempatan terbaik untuk masa depan yang
                        cerah.
                    </div>
                </div>
                <div class="w-full p-6 sm:w-1/2">
                    <img src="{{ asset('images/feature2.svg') }}" alt="Second feature alt text">
                </div>
            </div>

            <div class="mt-20 flex flex-wrap items-center">
                <div class="w-full text-center sm:w-1/2 sm:px-6">
                    <h3 class="text-3xl font-semibold text-gray-900">Tindakan Cepat untuk Masa Depan Lebih Baik</h3>
                    <div class="mt-6 text-xl leading-9">
                        Stunting dapat diatasi dengan intervensi yang tepat waktu.
                    </div>
                </div>
                <div class="w-full p-6 sm:w-1/2">
                    <img src="{{ asset('images/feature.svg') }}" alt="First feature alt text">
                </div>
            </div>

            <div class="mx-auto max-w-screen-lg px-3 py-16">
                <div
                    class="flex flex-col rounded-md bg-primary-100 p-4 text-center sm:flex-row sm:items-center sm:justify-between sm:p-12 sm:text-left">
                    <div class="text-2xl font-semibold">
                        <div class="text-gray-900">Mulai Cek Kesehatan Anak Anda</div>
                        <div class="text-primary-500">Deteksi dini stunting bisa menyelamatkan masa depan anak Anda.
                            Ayo mulai sekarang!</div>
                    </div>
                    <div class="mt-3 sm:ml-2 sm:mt-0">
                        <a href="{{ route('kalkulator.create') }}">
                            <div class="btn btn-base btn-primary">Cek Sekarang</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
