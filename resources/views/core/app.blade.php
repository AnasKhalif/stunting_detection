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

</body>

</html>