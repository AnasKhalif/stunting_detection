<footer class="text-green-800 border-t border-green-800 bg-white py-20 px-4 lg:px-10 text-sm">
    <div class="mx-auto px-4 flex flex-col lg:flex-row justify-between items-start gap-6">
        <div class="flex flex-col lg:w-1/2">
            <h2 class="text-2xl font-bold">Stunting Check</h2>
            <p class="mt-4 text-left text-neutral-500">
                Platform untuk membantu orang tua memantau pertumbuhan anak dan mencegah stunting. Bersama kita
                wujudkan generasi yang
                sehat dan cerdas.
            </p>
            <a href="{{ route('kalkulator.create') }}"
                class="flex mx-auto lg:mx-0 items-center justify-between gap-2 font-semibold py-3 px-6 rounded-full bg-green-700 hover:bg-green-800 text-white w-fit text-sm mt-4">
                Cek Stunting
                <img src="{{ asset('./icon/arrow.svg') }}" class="mr-0" alt="calculator" />
            </a>
        </div>

        <div class="flex flex-col">
            <h3 class="text-lg font-bold mb-4">Quick Links</h3>
            <ul class="space-y-2 text-neutral-500">
                <li><a href="/" class="hover:text-green-800">Home</a></li>
                <li><a href="/about" class="hover:text-green-800">About Us</a></li>
                <li><a href="/kalkulator" class="hover:text-green-800">Stunting Calculator</a></li>
                <li><a href="#" class="hover:text-green-800">Contact</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div class="flex flex-col">
            <h3 class="text-lg font-bold mb-4">Contact Us</h3>
            <ul class="space-y-2 text-sm text-neutral-500 hover:cursor-pointer">
                <p class="hover:text-green-800 duration-500">Email: info@stuntingcheck.com</p>
                <p class="hover:text-green-800 duration-500">Phone: +62 812 3456 7890</p>
                <p class="hover:text-green-800 duration-500">Address: Jl. Veteran No. 123, Malang</p>
            </ul>
        </div>
    </div>

    <!-- Bottom Footer -->
</footer>
<div class="flex justify-center items-center border-t py-4 text-xs text-center">
    <p>&copy; 2024 Stunting Check. All rights reserved.</p>
</div>