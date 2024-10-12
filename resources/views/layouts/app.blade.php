<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Spike TailwindCSS HTML Admin Template</title>
    @include('layouts.partials.link')
</head>

<body class=" bg-surface">
    @include('layouts.partials.header')

    @yield('content')

    @include('layouts.partials.footer')
    @include('layouts.partials.script')
</body>

</html>
