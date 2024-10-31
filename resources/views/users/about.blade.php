@extends('core.app')

@section('title')
    About
@endsection

@section('content')
    <section class="flex flex-col md:flex-row items-center py-24 lg:justify-center lg:py-32">
        <div class="w-full md:w-auto flex justify-center">
            <img src="/img/about.png" alt="About Us Image" class="w-3/4 md:w-full h-auto object-cover">
        </div>
        <div class="w-full md:w-1/2 text-center md:text-left px-6 md:px-12">
            <h2 class="text-2xl lg:text-6xl font-semibold text-gray-800 mb-4">About <span class="text-green-700">Us</span>
            </h2>
            <p class="text-gray-600 text-sm">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis,
                pulvinar dapibus leo.
            </p>
        </div>
    </section>


    <section class="flex flex-col justify-center items-center mt-8 mb-12">
        <div class="mx-auto mb-12 py-2 px-6 rounded-tl-2xl rounded-br-2xl shadow-shadow-card bg-green-800 text-white w-fit">
            <h2 class="text-2xl font-bold text-center lg:text-xl">Vision and Mission</h2>
        </div>

        <div class="hidden lg:flex justify-center mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" width="371" height="600" viewBox="0 0 371 600" fill="none">
                <!-- Lingkaran -->
                <circle cx="14.414" cy="260.312" r="11.56" fill="black" />
                <circle cx="359.365" cy="569.197" r="11.56" fill="black" />
                <circle cx="185.502" cy="12.4653" r="11.56" fill="black" />

                <!-- Garis Path Utama -->
                <path d="M185.502 12.4653C185.502 12.4653 184 100 192.973 413" stroke="black" stroke-width="8" />

                <!-- Path Teks Misi -->
                <path d="M362.973 569C265.107 565.935 197.433 562.17 192.973 413" stroke="black" stroke-width="8" />

                <!-- Path Teks Visi -->
                <path d="M24 260C184.025 255.846 192.729 223.94 187 160" stroke="black" stroke-width="8" />
            </svg>
        </div>

        <div class="flex flex-col md:flex-row justify-center items-center w-full space-y-4 md:space-y-0 md:space-x-4 px-4">
            <!-- Menambahkan px-4 untuk padding horizontal -->
            <div class="p-6 rounded-2xl border-2 border-green-700 max-w-xs flex-1">
                <h1 class="font-bold text-lg">Vision</h1>
                <p class="text-neutral-600 text-sm">
                    Menjadi platform terdepan yang mendukung upaya pencegahan stunting di Indonesia dengan menyediakan
                    informasi, edukasi, dan alat yang dapat diakses oleh masyarakat untuk memastikan generasi mendatang
                    tumbuh
                    sehat, cerdas, dan berdaya saing.
                </p>
            </div>

            <div class="p-6 rounded-2xl border-2 border-green-700 max-w-xs flex-1">
                <h1 class="font-bold text-lg">Mission</h1>
                <p class="text-neutral-600 text-sm">
                    meningkatkan kesadaran dan pengetahuan masyarakat tentang stunting. Kami berkomitmen untuk menyediakan
                    informasi terkini dan akurat mengenai kesehatan anak, nutrisi, dan perkembangan melalui artikel,
                    panduan, dan
                    sumber
                    daya lainnya.
                </p>
            </div>
        </div>

    </section>
@endsection
