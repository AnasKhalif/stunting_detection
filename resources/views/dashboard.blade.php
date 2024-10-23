@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="col-span-2">
            <div class="card">
                <div class="card-body">
                    <div class="flex  justify-between mb-5">
                        <h4 class="text-gray-500 text-lg font-semibold sm:mb-0 mb-2">weekly traffic</h4>
                    </div>
                    <div id="profit"></div>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-gray-500 text-lg font-semibold mb-4">Traffic Stunting</h4>
                    <div class="flex items-center justify-between gap-12">
                        <div>
                            <div class="flex">
                                <div class="flex gap-2 items-center">
                                    <span class="w-2 h-2 rounded-full bg-green-600"></span>
                                    <p class="text-gray-400 font-normal text-xs">Not Stunting</p>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    <p class="text-gray-400 font-normal text-xs"> Stunting</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div id="grade"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="flex gap-6 items-center justify-between">
                        <div class="flex flex-col gap-4">
                            <h4 class="text-gray-500 text-lg font-semibold">Average Stunting</h4>
                            <div class="flex flex-col gap-4">
                                @if ($stuntingCount > $notStuntingCount)
                                    <h3 class="text-[22px] font-semibold text-gray-500">{{ $stuntingCount }}</h3>
                                @else
                                    <h3 class="text-[22px] font-semibold text-gray-500">{{ $notStuntingCount }}</h3>
                                @endif

                                @if ($stuntingCount > $notStuntingCount)
                                    <div class="flex items-center gap-1">
                                        <span class="flex items-center justify-center w-5 h-5 rounded-full bg-red-400">
                                            <i class="ti ti-arrow-down-right text-black-500"></i>
                                        </span>
                                        <p class="text-gray-500 text-sm font-normal">-9%</p>
                                        <p class="text-gray-400 text-sm font-normal text-nowrap">last month</p>
                                    </div>
                                @else
                                    <div class="flex items-center gap-1">
                                        <span class="flex items-center justify-center w-5 h-5 rounded-full bg-green-400">
                                            <i class="ti ti-arrow-up-right text-black-500"></i>
                                        </span>
                                        <p class="text-gray-500 text-sm font-normal">+9%</p>
                                        <p class="text-gray-400 text-sm font-normal text-nowrap">last month</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div
                            class="w-11 h-11 flex justify-center items-center rounded-full bg-gray-500 text-white self-start">
                            <i class="ti ti-chart-line text-xl"></i>
                        </div>

                    </div>
                </div>
                <div id="earning"></div>
            </div>
        </div>


    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="card">
            <div class="card-body">
                <h4 class="text-gray-500 text-lg font-semibold mb-5">Article Terbaru</h4>
                <ul class="timeline-widget relative">
                    @foreach ($articles as $article)
                        <li class="timeline-item flex relative overflow-hidden min-h-[70px]">
                            <div class="timeline-time text-gray-500 text-sm min-w-[90px] py-[6px] pr-4 text-end">
                                {{ $article->created_at->format('h:i A') }} <!-- Format waktu -->
                            </div>
                            <div class="timeline-badge-wrap flex flex-col items-center ">
                                <div
                                    class="timeline-badge w-3 h-3 rounded-full shrink-0 bg-transparent border-2 border-blue-600 my-[10px]">
                                </div>
                                <div class="timeline-badge-border block h-full w-[1px] bg-gray-100"></div>
                            </div>
                            <div class="timeline-desc py-[6px] px-4">
                                <p class="text-gray-500 font-semibold">{{ $article->title }}</p> <!-- Judul artikel -->
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-span-2">
            <div class="card h-full">
                <div class="card-body">
                    <h4 class="text-gray-500 text-lg font-semibold mb-5">Status Stunting</h4>
                    <div class="relative overflow-x-auto">
                        <table class="text-left w-full whitespace-nowrap text-sm text-gray-500">
                            <thead>
                                <tr class="text-sm">
                                    <th scope="col" class="p-4 font-semibold">Profile</th>
                                    <th scope="col" class="p-4 font-semibold">Age (months)</th>
                                    <th scope="col" class="p-4 font-semibold">Birth Weight (kg)</th>
                                    <th scope="col" class="p-4 font-semibold">Birth Length (cm)</th>
                                    <th scope="col" class="p-4 font-semibold">Current Weight (kg)</th>
                                    <th scope="col" class="p-4 font-semibold">Current Height (cm)</th>
                                    <th scope="col" class="p-4 font-semibold">City</th>
                                    <th scope="col" class="p-4 font-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stuntingResults as $result)
                                    <tr>
                                        <td class="p-4 text-sm">
                                            <div class="flex gap-6 items-center">
                                                <div class="h-12 w-12 inline-block">
                                                    <img src="{{ $result->gender == 'Perempuan' ? asset('./assets/images/profile/user-4.jpg') : asset('./assets/images/profile/user-3.jpg') }}"
                                                        alt="" class="rounded-full w-100">
                                                </div>
                                                <div class="flex flex-col gap-1 text-gray-500">
                                                    <h3 class="font-bold">{{ $result->gender }}</h3>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <h3 class="font-medium">{{ $result->age }} months</h3>
                                        </td>
                                        <td class="p-4">
                                            <h3 class="font-medium">{{ $result->birth_weight }} kg</h3>
                                        </td>
                                        <td class="p-4">
                                            <h3 class="font-medium">{{ $result->birth_length }} cm</h3>
                                        </td>
                                        <td class="p-4">
                                            <h3 class="font-medium">{{ $result->weight }} kg</h3>
                                        </td>
                                        <td class="p-4">
                                            <h3 class="font-medium">{{ $result->height }} cm</h3>
                                        </td>
                                        <td class="p-4">
                                            <h3 class="font-medium">{{ $result->city->name }}</h3>
                                        </td>
                                        <td class="p-4">
                                            <span
                                                class="inline-flex items-center py-2 px-4 rounded-3xl font-semibold {{ $result->prediction_result == 'Stunting' ? 'bg-red-400 text-black' : 'bg-green-400 text-black' }}">
                                                {{ $result->prediction_result }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tambahkan CSS untuk ApexCharts jika belum ada -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">

    <div id="grade" style="height: 170px;"></div>
    <div id="profit" style="height: 370px;"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        $(function() {
            // Ambil data untuk chart donut
            var notStunting = {!! json_encode($notStuntingCount) !!} || 0;
            var stunting = {!! json_encode($stuntingCount) !!} || 0;

            console.log("Not Stunting:", notStunting);
            console.log("Stunting:", stunting);

            // Render chart grade (donut)
            var gradeOptions = {
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
            };

            var donutChart = new ApexCharts(document.querySelector("#grade"), gradeOptions);
            donutChart.render();

            // Ambil data untuk chart profit (bar)
            var stuntingData = {!! json_encode($stuntingData) !!};
            var notStuntingData = {!! json_encode($notStuntingData) !!};
            var dates = {!! json_encode($dates) !!};

            // Render chart profit (bar)
            var profitOptions = {
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

            var barChart = new ApexCharts(document.querySelector("#profit"), profitOptions);
            barChart.render();
        });
    </script>
@endsection
