@extends('core.app')

@section('title')
    About
@endsection

@section('content')
    <section
        class="relative flex mt-20 flex-col items-center justify-center w-full h-[20vh] lg:h-[30vh] text-white bg-cover bg-center after:bg-black after:w-full after:h-[20vh] after:absolute after:lg:h-[30vh] after:bg-opacity-45"
        style="background-image: url('/img/about-hero.jpg');">
        <h1 class="font-extrabold text-2xl lg:text-3xl z-10">Tentang Kami</h1>
        <span class="text-xs lg:text-sm z-10">
            <b>Home > Tentang Kami</b>
        </span>
    </section>

    <section class="flex flex-col justify-center items-center mt-8 mb-12 px-5 md:px-10">
        <div class="mx-auto mb-12 py-2 px-6 rounded-tl-2xl rounded-br-2xl shadow-shadow-card bg-green-800 text-white w-fit">
            <h2 class="text-2xl font-bold text-center lg:text-xl">Tentang Smart Growth</h2>
        </div>
        <p class="text-neutral-600 text-sm text-center">SmartGrowth adalah platform digital yang berkomitmen membantu
            orang tua dan pengasuh dalam memantau tumbuh kembang anak guna mencegah stunting. Kami menyediakan informasi
            yang akurat, edukasi yang mudah dipahami, dan alat pemantauan praktis agar setiap anak di Indonesia bisa tumbuh
            dengan optimal, sehat, dan cerdas. Dengan dukungan para ahli, kami berupaya meningkatkan kesadaran masyarakat
            tentang pentingnya gizi dan kesehatan anak, menciptakan generasi masa depan yang bebas dari stunting.
            Bergabunglah bersama kami untuk mewujudkan Indonesia yang lebih sehat dan sejahtera.</p>
        <a href="{{ route('kalkulator.create') }}"
            class="flex mx-auto lg:mx-0 items-center justify-between gap-2 font-semibold py-3 px-6 rounded-full bg-green-700 hover:bg-green-800 text-white w-fit text-sm mt-7">
            Cek Stunting
            <img src="{{ asset('./icon/arrow.svg') }}" class="mr-0" alt="calculator" />
        </a>
    </section>

    <section class="my-10 mx-5 lg:mx-10 lg:py-20">
        <div class="flex flex-col lg:flex-row gap-5 lg:gap-20 align-middle items-center">
            <div class="w-full lg:w-1/2">
                <h1 class="font-bold text-2xl">Visi Kami</h1>
                <p class="text-sm text-neutral-600 ">
                    Kami memiliki visi untuk menjadi platform terpercaya dalam mendukung upaya pencegahan dan penanganan
                    stunting di Indonesia. Dengan menyediakan informasi dan edukasi yang akurat serta mudah diakses oleh
                    masyarakat, kami berharap dapat membantu memastikan tumbuh kembang anak-anak Indonesia yang optimal,
                    sehat, dan berkualitas.</p>
                <h1 class="font-bold text-2xl text-end mt-5">Misi Kami</h1>
                <p class="text-sm text-end text-neutral-600 ">
                    Kami berkomitmen untuk meningkatkan kesadaran masyarakat tentang stunting melalui edukasi yang mudah
                    dipahami dan alat pemantauan yang praktis. Dengan bekerja sama dengan para ahli, kami menyediakan
                    informasi yang akurat dan terkini untuk membantu orang tua memantau tumbuh kembang anak. Tujuan kami
                    adalah menciptakan generasi Indonesia yang sehat, cerdas, dan bebas dari stunting.</p>

            </div>
            <div class="w-full lg:w-1/2 grid grid-cols-2 gap-4">
                <img src="/img/hero-section.png" class="aspect-video" alt="" />
                <img src="/img/hero-section.png" class="aspect-video" alt="" />
                <img src="/img/hero-section.png" class="aspect-video" alt="" />
                <img src="/img/hero-section.png" class="aspect-video" alt="" />
            </div>
        </div>
    </section>

    <section class="flex flex-col lg:flex-row justify-between items-center w-full px-4 lg:px-10 lg:my-20">
        <div class="flex flex-col gap-6">
            <div
                class="mx-auto mb-4 py-2 px-6 rounded-tl-2xl rounded-br-2xl shadow-shadow-card bg-green-800 text-white w-fit">
                <h2 class="text-2xl font-bold text-center lg:text-xl">Kenapa SmartGrowth</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div
                    class="p-6 rounded-2xl border-2 border-green-700 shadow-green-700 transition duration-300 shadow-shadow-card">
                    <h1 class="font-bold text-lg">Akurasi Tinggi dengan <span class="text-green-700">Teknologi AI</span>
                    </h1>
                    <p class="text-neutral-600 text-sm">
                        Stunting Check menggunakan teknologi AI canggih dengan tingkat akurasi hingga 97% dalam memantau dan
                        menganalisis tumbuh kembang anak. Ini memastikan orang tua mendapatkan hasil yang akurat dan
                        terpercaya untuk kesehatan anak mereka.
                    </p>
                </div>
                <div
                    class="p-6 rounded-2xl border-2 border-green-700 shadow-green-700 transition duration-300 shadow-shadow-card">
                    <h1 class="font-bold text-lg">Dukungan dari<span class="text-green-700"> Para Ahli</span></h1>
                    <p class="text-neutral-600 text-sm">
                        Setiap informasi dan layanan yang kami sediakan didukung oleh tim ahli di bidang kesehatan anak dan
                        gizi, termasuk dokter anak dan ahli gizi. Kami memastikan bahwa semua edukasi yang kami bagikan
                        selalu mengikuti standar medis terbaru.
                    </p>
                </div>
                <div
                    class="p-6 rounded-2xl border-2 border-green-700 shadow-green-700 transition duration-300 shadow-shadow-card">
                    <h1 class="font-bold text-lg">Gratis dan <span class="text-green-700">Mudah Diakses </span>untuk Semua
                    </h1>
                    <p class="text-neutral-600 text-sm">
                        Anak yang mengalami stunting seringkali menunjukkan keterlambatan dalam perkembangan kognitif,
                        seperti sulit fokus,
                        lambat merespons, dan menghadapi tantangan dalam belajar.
                    </p>
                </div>
                <div
                    class="p-6 rounded-2xl border-2 border-green-700 shadow-green-700 transition duration-300 shadow-shadow-card">
                    <h1 class="font-bold text-lg">Kerahasiaan dan <span class="text-green-700">Keamanan Data </span></h1>
                    <p class="text-neutral-600 text-sm">
                        Privasi Anda adalah prioritas kami. Semua data yang Anda masukkan ke dalam platform Stunting Check
                        dijamin kerahasiaannya dan disimpan dengan protokol keamanan yang tinggi, sehingga Anda dapat
                        memantau pertumbuhan anak dengan tenang dan aman.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
