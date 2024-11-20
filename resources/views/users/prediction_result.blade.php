@extends('core.app')

@section('title')
    Hasil Prediksi Stunting
@endsection

@section('content')
    <section class="mt-12 lg:mt-36 mb-12 lg:mb-8">
        <div class="container mx-auto ">

            <div class="bg-[#2A7D5E] shadow-lg rounded-[3rem] flex flex-col lg:flex-row mx-4 p-6 py-12 min-h-[400px]">

                <div class="w-full lg:w-1/2 flex flex-col justify-center px-4">
                    <h2 class="text-white text-5xl mb-4">Analisa Prediksi <br> Kesehatan</h2>
                    <p class="text-white">Hasil prediksi stunting berdasarkan data yang telah Anda masukkan : <br> <span
                            class="text-lg font-medium">{{ $status }}</span></p>
                </div>


                <div class="w-full lg:w-1/2 flex items-stretch mt-6 lg:mt-0 px-12">
                    <div class="bg-[#468f74] p-4 rounded-lg shadow-inner flex-grow flex flex-col border-8 border-[#5f9e86]">
                        <div>
                            <h1 class="text-white text-4xl">Saran Hasil Prediksi</h1>
                        </div>
                        <div class="flex-grow flex items-center">
                            <ul class="text-white text-medium list-disc ml-5">
                                @foreach ($advice['steps'] as $step)
                                    <li>{{ $step }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection
