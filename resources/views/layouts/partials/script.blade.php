<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/iconify-icon/dist/iconify-icon.min.js') }}"></script>
<script src="{{ asset('assets/libs/@preline/dropdown/index.js') }}"></script>
<script src="{{ asset('assets/libs/@preline/overlay/index.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>

<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $(function() {
        var notStunting = {!! json_encode($notStuntingCount) !!} || 0;
        var stunting = {!! json_encode($stuntingCount) !!} || 0;

        console.log("Not Stunting:", notStunting);
        console.log("Stunting:", stunting);

        var grade = {
            series: [notStunting, stunting],
            labels: ["Not Stunting", "Stunting"],
            chart: {
                height: 170,
                type: "donut",
                fontFamily: "'Plus Jakarta Sans', sans-serif",
                foreColor: "#c6d1e9",
            },
            tooltip: {
                theme: "dark",
                fillSeriesColor: false,
            },
            colors: ["#73EC8B", "#FEA1A1"],
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: false,
            },
            stroke: {
                show: false,
            },
            responsive: [{
                breakpoint: 991,
                options: {
                    chart: {
                        width: 150,
                    },
                },
            }],
            plotOptions: {
                pie: {
                    donut: {
                        size: "80%",
                        background: "none",
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: "12px",
                                color: undefined,
                                offsetY: 5,
                            },
                            value: {
                                show: false,
                                color: "#98aab4",
                            },
                        },
                    },
                },
            },
            responsive: [{
                    breakpoint: 1476,
                    options: {
                        chart: {
                            height: 120,
                        },
                    },
                },
                {
                    breakpoint: 1280,
                    options: {
                        chart: {
                            height: 170,
                        },
                    },
                },
                {
                    breakpoint: 1166,
                    options: {
                        chart: {
                            height: 120,
                        },
                    },
                },
                {
                    breakpoint: 1024,
                    options: {
                        chart: {
                            height: 170,
                        },
                    },
                },
                {
                    breakpoint: 1720,
                    options: {
                        chart: {
                            height: 145,
                        },
                    },
                },
            ],
        };

        var chart = new ApexCharts(document.querySelector("#grade"), grade);
        chart.render();
    });
</script>

<script>
    $(function() {
        // Mengambil data dari server
        var stuntingData = {!! json_encode($stuntingData) !!};
        var notStuntingData = {!! json_encode($notStuntingData) !!};
        var dates = {!! json_encode($dates) !!};

        // Fungsi untuk merender chart profit
        function renderProfitChart() {
            var profit = {
                series: [{
                        name: "Stunting",
                        data: stuntingData,
                    },
                    {
                        name: "Tidak Stunting",
                        data: notStuntingData,
                    }
                ],
                chart: {
                    fontFamily: "Poppins,sans-serif",
                    type: "bar",
                    height: 370,
                    offsetY: 10,
                    toolbar: {
                        show: false,
                    },
                },
                grid: {
                    show: true,
                    strokeDashArray: 3,
                    borderColor: "rgba(0,0,0,.1)",
                },
                colors: ["#dc3545", "#28a745"],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "30%",
                        endingShape: "flat",
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    width: 5,
                    colors: ["transparent"],
                },
                xaxis: {
                    type: "category",
                    categories: dates,
                    axisTicks: {
                        show: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                    labels: {
                        style: {
                            colors: "#a1aab2",
                        },
                    },
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: "#a1aab2",
                        },
                    },
                },
                fill: {
                    opacity: 1,
                    colors: ["#dc3545", "#28a745"],
                },
                tooltip: {
                    theme: "dark",
                },
                legend: {
                    show: true,
                },
            };

            var chart_column_basic = new ApexCharts(
                document.querySelector("#profit"),
                profit
            );
            chart_column_basic.render();
        }


        renderProfitChart();


        var notStunting = {!! json_encode($notStuntingCount) !!} || 0;
        var stunting = {!! json_encode($stuntingCount) !!} || 0;

        console.log("Not Stunting:", notStunting);
        console.log("Stunting:", stunting);

        var grade = {
            // (isi objek grade yang ada sebelumnya)
        };

        var chart = new ApexCharts(document.querySelector("#profit"), grade);
        chart.render();
    });
</script>


{{-- <script>
    var profit = {
        series: [{
                name: "Pixel ",
                data: [9, 5, 3, 7, 5, 10, 3],
            },
            {
                name: "Ample ",
                data: [6, 3, 9, 5, 4, 6, 4],
            },
        ],
        chart: {
            fontFamily: "Poppins,sans-serif",
            type: "bar",
            height: 370,
            offsetY: 10,
            toolbar: {
                show: false,
            },
        },
        grid: {
            show: true,
            strokeDashArray: 3,
            borderColor: "rgba(0,0,0,.1)",
        },
        colors: ["#1e88e5", "#21c1d6"],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "30%",
                endingShape: "flat",
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            show: true,
            width: 5,
            colors: ["transparent"],
        },
        xaxis: {
            type: "category",
            categories: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
            axisTicks: {
                show: false,
            },
            axisBorder: {
                show: false,
            },
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        yaxis: {
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        fill: {
            opacity: 1,
            colors: ["#73EC8B", "#FEA1A1"],
        },
        tooltip: {
            theme: "dark",
        },
        legend: {
            show: false,
        },
        responsive: [{
            breakpoint: 767,
            options: {
                stroke: {
                    show: false,
                    width: 5,
                    colors: ["transparent"],
                },
            },
        }, ],
    };

    var chart_column_basic = new ApexCharts(
        document.querySelector("#profit"),
        profit
    );
    chart_column_basic.render();
</script> --}}
