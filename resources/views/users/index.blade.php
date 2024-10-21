@extends('core.app')

@section('title')
    Stunting Check
@endsection

@section('content')
    <section
        class="flex lg:justify-between items-center justify-center w-full min-h-screen px-4 lg:px-10 flex-col gap-10 lg:flex-row-reverse lg:my-20">
        <div class="lg:w-1/2 lg:mx-auto">
            <img src="./img/hero-illustration.png" class="w-8/12 mx-auto" alt="img-hero" />
        </div>
        <div class="flex flex-col lg:w-1/2 lg:mx-auto gap-3 text-center lg:text-left">
            <h1 class="text-2xl lg:text-6xl font-bold">
                <span class="text-green-700">Cegah Stunting</span>
                Sekarang!
            </h1>
            <p class="text-neutral-600 text-sm">
                Stunting bukan hanya masalah tumbuh kembang fisik, tapi juga menyangkut masa depan generasi kita. Mulai
                sekarang,
                pastikan anak-anak tumbuh sehat dan cerdas.
            </p>
            <h2 class="font-semibold text-sm text-neutral-700">Selamatkan Generasi Mendatang – Langkah Kecil, Dampak
                Besar!</h2>
            <a href="kalkulator"
                class="flex mx-auto lg:mx-0 items-center justify-between gap-2 font-semibold py-3 mt-2 px-6 rounded-full bg-green-700 hover:bg-green-800 text-white w-fit text-sm">
                Cek Stunting
                <img src="{{ asset('./icon/arrow.svg') }}" class="mr-0" alt="calculator" />
            </a>
        </div>
    </section>

    <section class="flex flex-col lg:flex-row justify-between items-center w-full px-4 lg:px-10 lg:my-20">
        <div class="flex flex-col gap-6">
            <div
                class="mx-auto mb-4 py-2 px-6 rounded-tl-2xl rounded-br-2xl shadow-shadow-card bg-green-800 text-white w-fit">
                <h2 class="text-2xl font-bold text-center lg:text-xl">Tanda Stunting Pada Anak</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div
                    class="p-6 rounded-2xl border-2 border-green-700 shadow-green-700 transition duration-300 shadow-shadow-card">
                    <h1 class="font-bold text-lg"><span class="text-green-700">Pertumbuhan </span>Terhambat</h1>
                    <p class="text-neutral-600 text-sm">
                        Anak dengan stunting memiliki tinggi badan yang lebih pendek dari rata-rata anak seusianya. Hal
                        ini terjadi karena
                        kurangnya asupan nutrisi yang cukup selama masa pertumbuhan.
                    </p>
                </div>
                <div
                    class="p-6 rounded-2xl border-2 border-green-700 shadow-green-700 transition duration-300 shadow-shadow-card">
                    <h1 class="font-bold text-lg"><span class="text-green-700">Berat Badan </span>Rendah</h1>
                    <p class="text-neutral-600 text-sm">
                        Anak stunting cenderung memiliki berat badan yang lebih rendah dan tidak proporsional dengan
                        usianya. Kondisi ini
                        menunjukkan adanya masalah gizi kronis yang berdampak pada tumbuh kembangnya.
                    </p>
                </div>
                <div
                    class="p-6 rounded-2xl border-2 border-green-700 shadow-green-700 transition duration-300 shadow-shadow-card">
                    <h1 class="font-bold text-lg">Perkembangan <span class="text-green-700">Kognitif Lambat</span></h1>
                    <p class="text-neutral-600 text-sm">
                        Anak yang mengalami stunting seringkali menunjukkan keterlambatan dalam perkembangan kognitif,
                        seperti sulit fokus,
                        lambat merespons, dan menghadapi tantangan dalam belajar.
                    </p>
                </div>
                <div
                    class="p-6 rounded-2xl border-2 border-green-700 shadow-green-700 transition duration-300 shadow-shadow-card">
                    <h1 class="font-bold text-lg">Rentan Terhadap <span class="text-green-700">Penyakit</span></h1>
                    <p class="text-neutral-600 text-sm">
                        Anak stunting memiliki sistem imun yang lebih lemah, sehingga lebih sering mengalami infeksi dan
                        masalah kesehatan
                        lainnya dibandingkan dengan anak-anak yang tumbuh normal.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full px-4 lg:px-10 my-20">
        <div class="mx-auto py-2 px-6 rounded-tl-2xl rounded-br-2xl shadow-shadow-card bg-green-800 text-white w-fit mb-10">
            <h2 class="text-2xl font-bold text-center lg:text-xl">Cara Mencegah Stunting</h2>
        </div>
        <div class="flex flex-col-reverse lg:flex-row-reverse align-middle items-center justify-between">
            <div class="w-full lg:w-1/2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col border w-full border-green-700 p-6 rounded-2xl">
                        <img src="{{ asset('./icon/food.svg') }}" alt="" class="w-10" />
                        <h1 class="font-bold text-lg mt-5">Gizi <span class="text-green-700">Seimbang</span></h1>
                        <p class="text-neutral-600 text-sm">
                            Pastikan anak mendapat nutrisi yang cukup, termasuk protein, vitamin, dan mineral.
                        </p>
                    </div>
                    <div class="flex flex-col border border-green-700 p-6 rounded-2xl">
                        <img src="{{ asset('./icon/bottle.svg') }}" alt="" class="w-10" />
                        <h1 class="font-bold text-lg mt-5">ASI <span class="text-green-700">Eksklusif</span></h1>
                        <p class="text-neutral-600 text-sm">Berikan ASI selama 6 bulan pertama tanpa tambahan makanan
                            atau minuman.</p>
                    </div>
                    <div class="flex flex-col border border-green-700 p-6 rounded-2xl">
                        <img src="{{ asset('./icon/water.svg') }}" alt="" class="w-10" />
                        <h1 class="font-bold text-lg mt-5"><span class="text-green-700">Kebersihan</span> Lingkungan
                        </h1>
                        <p class="text-neutral-600 text-sm">Jaga kebersihan makanan, air, dan lingkungan untuk mencegah
                            infeksi.</p>
                    </div>
                    <div class="flex flex-col border border-green-700 p-6 rounded-2xl">
                        <img src="{{ asset('./icon/ruler.svg') }}" alt="" class="w-10" />
                        <h1 class="font-bold text-lg mt-5">Pantau <span class="text-green-700">Pertumbuhan</span></h1>
                        <p class="text-neutral-600 text-sm">
                            Periksakan anak secara rutin untuk memantau perkembangan dan cegah stunting lebih dini.
                        </p>
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-1/2">
                <img src="./img/healthy-food.jpg" alt="" class="w-8/12 mx-auto" />
            </div>
        </div>
    </section>

    <section class="px-4 lg:px-10 lg:my-32">
        <h2 class="text-2xl font-bold text-center mb-6"><span class="text-green-700">Artikel</span> Terbaru</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach ($articles as $article)
                <div class="flex flex-col shadow-md rounded-3xl p-5">
                    <div class="w-full overflow-hidden rounded-2xl">
                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                            class="w-full h-64 rounded-2xl duration-300 ease-out" />
                    </div>
                    <h1 class="font-bold mt-2">{{ $article->title }}</h1>
                    <p class="text-sm text-neutral-500 mt-2 truncate">
                        {{ $article->body }}
                    </p>
                    <a href="{{ route('artikel.show', $article->id) }}"
                        class="font-semibold mt-4 bg-green-700 text-white rounded-full py-2 text-xs text-center">
                        Baca Selengkapnya
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <section class="w-full bg-white py-20">
        <div class="mx-auto flex flex-col items-center gap-6 w-full px-4 lg:px-10">
            <h2 class="text-2xl font-bold text-center"><span class="text-green-700">FAQ</span> - Frequently Asked
                Questions</h2>
            <div class="w-full space-y-2">
                <div class="border border-gray-200 rounded-lg w-full">
                    <button class="w-full flex justify-between items-center p-4 text-left text-gray-800 font-semibold"
                        id="faq1-btn">
                        Apa itu stunting?
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div id="faq1-content" class="hidden px-4 py-2 text-gray-600">
                        Stunting adalah kondisi di mana anak memiliki tinggi badan yang jauh lebih rendah dari standar
                        usianya akibat
                        kurangnya asupan nutrisi dalam waktu yang lama, terutama pada 1000 hari pertama kehidupan.
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg w-full">
                    <button class="w-full flex justify-between items-center p-4 text-left text-gray-800 font-semibold"
                        id="faq2-btn">
                        Apa penyebab utama stunting?
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div id="faq2-content" class="hidden px-4 py-2 text-gray-600">
                        Stunting disebabkan oleh kurangnya asupan gizi yang memadai, terutama selama masa kehamilan dan
                        awal kehidupan anak.
                        Faktor lain seperti pola makan yang buruk, sanitasi yang tidak memadai, dan akses terbatas ke
                        layanan kesehatan juga
                        berkontribusi.
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg w-full">
                    <button class="w-full flex justify-between items-center p-4 text-left text-gray-800 font-semibold"
                        id="faq3-btn">
                        Bagaimana cara mencegah stunting?
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div id="faq3-content" class="hidden px-4 py-2 text-gray-600">
                        Pencegahan stunting dapat dilakukan dengan memberikan asupan gizi yang cukup dan seimbang sejak
                        masa kehamilan
                        hingga anak berusia dua tahun. Juga penting untuk menjaga kebersihan, memastikan imunisasi, dan
                        memberikan ASI
                        eksklusif selama 6 bulan pertama.
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg w-full">
                    <button class="w-full flex justify-between items-center p-4 text-left text-gray-800 font-semibold"
                        id="faq4-btn">
                        Apa dampak jangka panjang dari stunting?
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div id="faq4-content" class="hidden px-4 py-2 text-gray-600">
                        Anak yang mengalami stunting berisiko menghadapi masalah perkembangan fisik dan kognitif,
                        gangguan belajar, serta
                        berisiko lebih tinggi terkena penyakit kronis seperti diabetes dan penyakit jantung di masa
                        dewasa.
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
