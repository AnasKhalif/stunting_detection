<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <link rel="icon" href="{{ asset('img/hero-illustration.png') }}" type="image/png">
    <style>
        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>

    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>

<body>

    @include('core.partials.header')
    @yield('content')
    @include('core.partials.script')
    @include('core.partials.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Include Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#city').select2({
                placeholder: "Pilih Kota",
                allowClear: true
            })

        });
    </script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('message'))
        <script>
            Swal.fire({
                title: 'Hasil Prediksi',
                text: "{{ session('message') }}",
                width: 600,
                padding: '3em',
                color: '#ffffff',
                background: '#f0fff4 url(/images/bg_balita.jpg)', // Background lebih cerah
                backdrop: `
                rgba(144, 238, 144, 0.5)
                url("/images/balitaku.gif")
                center top
                no-repeat
            `,
                confirmButtonColor: '#E4E0E1', // Ubah warna tombol menjadi putih
                confirmButtonText: 'OK' // Teks tombol
            });
        </script>
    @endif

    @if (session('contact_message'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Pesan Terkirim',
                text: "{{ session('contact_message') }}",
                confirmButtonText: 'OK',
                confirmButtonColor: '#28a745' // Warna hijau
            });
        </script>
    @endif

</body>

</html>
