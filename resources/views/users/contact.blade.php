@extends('core.app')

@section('title')
    Contact
@endsection

@section('content')
    <section class="lg:mt-28">
        <div><iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63219.14214529117!2d112.5905833304482!3d-7.978643313838005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd62822063dc2fb%3A0x78879446481a4da2!2sMalang%2C%20Kota%20Malang%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1730450501308!5m2!1sid!2sid"
                width="600" height="45" class="w-full h-96 filter brightness-75" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe></div>
    </section>

    <section class="mx-5 lg:mx-14 flex flex-col-reverse gap-10 lg:gap-20 lg:flex-row justify-between mt-5 lg:mt-6 lg:mb-6">
        <div class="lg:w-1/2 w-full">
            <h1 class="font-bold text-2xl text-green-800">Hubungi Kami</h1>
            <p class="text-gray-700 text-base mt-2">
                Kesehatan anak Anda adalah prioritas kami. Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan
                tentang nutrisi, tumbuh kembang, atau tips menjaga kesehatan anak. Tim kami siap membantu Anda dengan
                informasi yang akurat dan saran yang bermanfaat. Bersama-sama, kita dapat memastikan anak-anak tumbuh sehat
                dan kuat.
            </p>
            <div class="mt-6">
                <h2 class="font-semibold text-lg text-green-800">Alamat</h2>
                <p class="text-gray-600 text-sm">Kota Malang, Jawa Timur, Indonesia</p>
            </div>
            <div class="mt-4">
                <h2 class="font-semibold text-lg text-green-800">No Telpon</h2>
                <p class="text-gray-600 text-sm">0812 3456 7890</p>
            </div>
        </div>

        <form name="form-contact" action="{{ route('kontak.store') }}" method="POST"
            class="lg:w-1/2 w-full flex flex-col bg-gray-50 p-8 rounded-lg shadow-md" autocomplete="off">
            @csrf
            <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Isi Formulir Kontak</h2>

            <div class="flex flex-col mb-4">
                <label for="name" class="text-gray-700 font-medium">Nama Lengkap</label>
                <input type="text" name="name" id="name" placeholder="Nama Lengkap Anda"
                    class="text-sm border border-gray-300 rounded-full py-3 px-4 focus:border-green-600 focus:ring-2 focus:ring-green-200 transition duration-300 ease-in-out outline-none"
                    required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col mb-4">
                <label for="email" class="text-gray-700 font-medium">Email</label>
                <input type="email" name="email" id="email" placeholder="Alamat Email"
                    class="text-sm border border-gray-300 rounded-full py-3 px-4 focus:border-green-600 focus:ring-2 focus:ring-green-200 transition duration-300 ease-in-out outline-none"
                    required>
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col mb-4">
                <label for="tel" class="text-gray-700 font-medium">No Telepon</label>
                <input type="tel" name="phone" id="tel" placeholder="Nomor Telepon Anda"
                    class="text-sm border border-gray-300 rounded-full py-3 px-4 focus:border-green-600 focus:ring-2 focus:ring-green-200 transition duration-300 ease-in-out outline-none"
                    required>
                @error('phone')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col mb-4">
                <label for="subject" class="text-gray-700 font-medium">Subject</label>
                <input type="text" name="subject" id="subject" placeholder="Subject Pesan Anda"
                    class="text-sm border border-gray-300 rounded-full py-3 px-4 focus:border-green-600 focus:ring-2 focus:ring-green-200 transition duration-300 ease-in-out outline-none"
                    required>
                @error('subject')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col mb-4">
                <label for="message" class="text-gray-700 font-medium">Message</label>
                <textarea name="message" id="message" rows="4" placeholder="Tulis pesan Anda di sini..."
                    class="text-sm border border-gray-300 rounded-lg py-3 px-4 focus:border-green-600 focus:ring-2 focus:ring-green-200 transition duration-300 ease-in-out outline-none resize-none"
                    required></textarea>
                @error('message')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" name="send" id="send"
                class="w-full bg-green-700 hover:bg-green-600 text-white py-3 font-bold rounded-full text-sm transition duration-300 ease-in-out mt-3">
                Kirim Pesan
            </button>
        </form>

    </section>
@endsection
