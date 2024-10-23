@extends('layouts.guest')

@section('title')
    Kalkulator Stunting
@endsection

@section('content')
    <div class="flex min-h-screen items-center justify-center bg-gray-100">
        <div class="mx-auto max-w-screen-md items-center px-4 lg:justify-center">
            <h1 class="text-center text-2xl font-bold lg:text-3xl">
                Kalkulator Stunting Anak - Anak
            </h1>
            <p class="mt-2 text-center text-lg lg:mt-3 lg:text-xl">
                Status stunting yang kami cek berdasarkan ukuran tubuh Anda, sesuai informasi yang Anda berikan. Oleh karena
                itu masukkanlah informasi yang benar.
            </p>

            @if ($errors->any())
                <div class="mb-4">
                    <ul class="text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-3 flex flex-col lg:mt-4 lg:flex-row">
                <img width="250" src="{{ asset('images/stunting_one.png') }}" alt="Stunting Anak-anak"
                    class="mx-auto items-center lg:py-12" />

                <form action="{{ route('kalkulator.store') }}" method="POST" class="flex w-full flex-col">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 lg:text-lg">Jenis Kelamin</label>
                        <select name="gender"
                            class="mt-2 w-full rounded-full border border-black bg-transparent px-4 py-3 lg:w-96">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 lg:text-lg">Usia Anak (0-60 bulan)</label>
                        <input type="text" name="age"
                            class="mt-2 w-full rounded-full border border-black bg-transparent px-4 py-3 lg:w-96"
                            placeholder="Bulan" />
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 lg:text-lg">Berat Badan Saat lahir</label>
                        <input type="text" name="birth_weight"
                            class="mt-2 w-full rounded-full border border-black bg-transparent px-4 py-3 lg:w-96"
                            placeholder="Cm" />
                    </div>


                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 lg:text-lg">Panjang Badan Saat lahir</label>
                        <input type="text" name="birth_length"
                            class="mt-2 w-full rounded-full border border-black bg-transparent px-4 py-3 lg:w-96"
                            placeholder="Cm" />
                    </div>


                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 lg:text-lg">Berat Badan Anak</label>
                        <input type="text" name="weight"
                            class="mt-2 w-full rounded-full border border-black bg-transparent px-4 py-3 lg:w-96"
                            placeholder="Kg" />
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 lg:text-lg">Tinggi Badan Anak</label>
                        <input type="text" name="height"
                            class="mt-2 w-full rounded-full border border-black bg-transparent px-4 py-3 lg:w-96"
                            placeholder="Cm" />
                    </div>

                    <div class="relative mb-6">
                        <label class="block text-sm font-medium text-gray-700 lg:text-lg">Kota</label>
                        <select name="city_id"
                            class="mt-2 w-full rounded-full border border-gray-300 bg-white px-4 py-3 lg:w-96 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Pilih Kota</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="flex lg:mr-20 lg:justify-center">
                        <button type="submit"
                            class="w-full rounded-full bg-green-500 py-3 text-white transition duration-200 hover:bg-green-600 lg:w-2/4">
                            Hitung
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
