@extends('core.app')

@section('title')
    Kalkulator Stunting
@endsection

@section('content')
    <section class="w-full px-4 lg:px-10 my-24 lg:my-36">
        <div class="mx-auto py-2 px-6 rounded-tl-2xl rounded-br-2xl shadow-shadow-card bg-green-800 text-white w-fit mb-10">
            <h2 class="text-2xl font-bold text-center lg:text-xl">Cek Stunting</h2>
        </div>
        <div class="flex flex-col lg:flex-row w-full justify-between">
            <form action="{{ route('kalkulator.store') }}" method="POST" class="w-full lg:w-3/4 mx-auto">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <!-- Jenis Kelamin -->
                    <div class="col-span-1 mb-6">
                        <label class="block text-sm font-medium text-gray-900 lg:text-lg">Jenis Kelamin</label>
                        <select name="gender"
                            class="mt-2 w-full rounded-full border border-black bg-transparent px-4 py-3 lg:w-96">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>

                    <!-- Usia Anak -->
                    <div class="col-span-1 mb-6">
                        <label class="block text-sm font-medium text-gray-900 lg:text-lg">Usia (0-60 bulan)</label>
                        <input type="text" name="age"
                            class="mt-2 w-full rounded-full border border-black bg-transparent px-4 py-3 lg:w-96"
                            placeholder="Bulan" />
                    </div>

                    <!-- Tinggi Badan Anak Sekarang -->
                    <div class="col-span-1 mb-6">
                        <label class="block text-sm font-medium text-gray-900 lg:text-lg">Tinggi Badan Sekarang (cm)</label>
                        <input type="text" name="height"
                            class="mt-2 w-full rounded-full border border-black bg-transparent px-4 py-3 lg:w-96"
                            placeholder="Cm" />
                    </div>

                    <!-- Kota -->
                    <div class="col-span-1 mb-6">
                        <label class="block text-sm font-medium text-gray-900 lg:text-lg">Kota</label>
                        <select name="city_id" id="city"
                            class="mt-2 w-full rounded-full border border-gray-300 bg-white px-4 py-3 lg:w-96 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Pilih Kota</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Button Kirim -->
                <div class="mt-6 flex lg:mr-20 lg:justify-center">
                    <button type="submit"
                        class="w-full rounded-full bg-green-500 py-3 text-white transition duration-200 hover:bg-green-600 lg:w-2/4">
                        Hitung
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
