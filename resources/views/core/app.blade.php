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
            });

            $('#district').select2({
                placeholder: "Pilih Kecamatan",
                allowClear: true
            });

            $('#city').on('change', function() {
                var cityValue = $(this).val();
                if (cityValue) {
                    var cityData = cityValue.split(':');
                    var cityCode = cityData[1];

                    $.ajax({
                        url: '/api/province/' + cityCode + '/districts',
                        type: 'GET',
                        success: function(data) {
                            var districtSelect = $('#district');
                            districtSelect.empty();
                            districtSelect.append('<option value="">Pilih Kecamatan</option>');
                            $.each(data, function(id, name) {
                                districtSelect.append('<option value="' + name + '">' +
                                    name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                } else {
                    $('#district').empty().append('<option value="">Pilih Kecamatan</option>');
                }
            });


            $('#kalkulatorForm').submit(function(e) {
                e.preventDefault();
                var districtName = $('#district option:selected')
                    .val();

                if (districtName) {

                    $('input[name="district_name"]').remove();


                    $('<input>').attr({
                        type: 'hidden',
                        name: 'district_name',
                        value: districtName
                    }).appendTo('#kalkulatorForm');

                    console.log("District Name:", districtName);
                    this.submit();
                } else {
                    alert("Pilih Kecamatan terlebih dahulu!");
                }
            });
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
                background: '#f0fff4 url(/images/bg_balita.jpg)',
                backdrop: `
                rgba(144, 238, 144, 0.5)
                url("/images/balitaku.gif")
                center top
                no-repeat
            `,
                confirmButtonColor: '#E4E0E1',
                confirmButtonText: 'OK'
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
                confirmButtonColor: '#28a745'
            });
        </script>
    @endif

</body>

</html>
