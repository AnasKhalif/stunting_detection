@extends('core.app')

@section('title')
    Kalkulator Stunting
@endsection

@section('content')
    <style>
        .select2-container .select2-selection--single {
            border-radius: 9999px !important;
            border: 1px solid black !important;
            padding: 0.75rem 1rem !important;
            background-color: transparent !important;
            height: 3.25rem !important;
            display: flex !important;
            align-items: center !important;
        }

        .select2-container .select2-selection__rendered {
            padding-left: 1rem !important;
            line-height: 1.5rem !important;
        }
    </style>

    <section class="w-full px-4 lg:px-10 my-24 lg:my-36">
        <div class="mx-auto py-2 px-6 rounded-tl-2xl rounded-br-2xl shadow-shadow-card bg-green-800 text-white w-fit mb-10">
            <h2 class="text-2xl font-bold text-center lg:text-xl">Cek Stunting</h2>
        </div>
        <div class="flex flex-col w-full items-center">
            <form action="{{ route('kalkulator.store') }}" method="POST" class="w-full lg:w-3/4 mx-auto">
                @csrf
                <div class="flex flex-col gap-6">

                    <div>
                        <label class="block text-sm font-medium text-gray-900 lg:text-lg">Jenis Kelamin</label>
                        <select name="gender" class="mt-2 w-full rounded-full border border-black bg-transparent px-4 py-3">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                        @error('gender')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                    <div>
                        <label class="block text-sm font-medium text-gray-900 lg:text-lg">Usia (0-60 bulan)</label>
                        <input type="text" name="age"
                            class="mt-2 w-full rounded-full border border-black bg-transparent px-4 py-3"
                            placeholder="Bulan" />
                        @error('age')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                    <div>
                        <label class="block text-sm font-medium text-gray-900 lg:text-lg">Tinggi Badan Sekarang (cm)</label>
                        <input type="text" name="height"
                            class="mt-2 w-full rounded-full border border-black bg-transparent px-4 py-3"
                            placeholder="Cm" />
                        @error('height')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                    <div>
                        <label class="block text-sm font-medium text-gray-900 lg:text-lg">Kota</label>
                        <select name="city_id" id="city"
                            class="mt-2 w-full rounded-full border border-black bg-transparent px-4 py-3 select2">
                            <option value="">Pilih Kota</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                placeholder: 'Pilih Kota',
                theme: 'classic'
            });


            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' || mutation.addedNodes.length) {
                        $('.select2-selection').addClass(
                            'rounded-full border border-black bg-transparent px-4 py-3');
                    }
                });
            });


            document.querySelectorAll('.select2').forEach(function(el) {
                observer.observe(el, {
                    attributes: true,
                    childList: true,
                    subtree: true
                });
            });
        });
    </script>
@endpush
