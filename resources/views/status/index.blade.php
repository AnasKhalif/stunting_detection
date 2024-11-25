@extends('layouts.app')

@section('title')
    Dashboard - Status Stunting
@endsection

@section('content')
    <div class="col-span-2">
        <div class="card h-full">
            <div class="card-body">
                <h4 class="text-gray-500 text-lg font-semibold mb-5">Status Stunting</h4>
                <div class="relative overflow-x-auto">
                    <!-- table -->
                    <table class="text-left w-full whitespace-nowrap text-sm text-gray-500">
                        <thead>
                            <tr class="text-sm">
                                <th scope="col" class="p-4 font-semibold">Profile</th>
                                <th scope="col" class="p-4 font-semibold">Age (months)</th>
                                <th scope="col" class="p-4 font-semibold">Height (cm)</th>
                                <th scope="col" class="p-4 font-semibold">City</th>
                                <th scope="col" class="p-4 font-semibold">District</th>
                                <th scope="col" class="p-4 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stuntingResults as $result)
                                <tr>
                                    <td class="p-4 text-sm">
                                        <div class="flex gap-6 items-center">
                                            <div class="h-12 w-12 inline-block">
                                                <!-- Ganti gambar berdasarkan gender -->
                                                <img src="{{ $result->gender == 'perempuan' ? asset('./assets/images/profile/user-4.jpg') : asset('./assets/images/profile/user-3.jpg') }}"
                                                    alt="" class="rounded-full w-100">
                                            </div>
                                            <div class="flex flex-col gap-1 text-gray-500">
                                                <h3 class=" font-bold">{{ $result->gender }}</h3>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <h3 class="font-medium">{{ $result->age }} months</h3>
                                    </td>
                                    <td class="p-4">
                                        <h3 class="font-medium">{{ $result->height }} cm</h3>
                                    </td>
                                    <td class="p-4">
                                        <h3 class="font-medium">{{ $result->city->name }}</h3>
                                    </td>
                                    <td class="p-4">
                                        <h3 class="font-medium">{{ $result->district_name }}</h3>
                                    </td>
                                    <td class="p-4">
                                        <span
                                            class="inline-flex items-center py-2 px-4 rounded-3xl font-semibold 
                                        {{ $result->prediction_result == 'stunted'
                                            ? 'bg-red-400 text-black'
                                            : ($result->prediction_result == 'severely stunted'
                                                ? 'bg-red-600 text-black'
                                                : ($result->prediction_result == 'normal'
                                                    ? 'bg-green-400 text-black'
                                                    : ($result->prediction_result == 'tinggi'
                                                        ? 'bg-blue-400 text-black'
                                                        : ''))) }}">
                                            {{ $result->prediction_result }}
                                        </span>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination links -->
                <div class="mt-4">
                    {{ $stuntingResults->links() }} <!-- Menampilkan link pagination -->
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h4 class="text-gray-500 text-lg font-semibold mb-5">Report by City</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($reports as $report)
                <div class="card p-5 bg-white shadow-sm rounded-lg">
                    <h5 class="text-lg font-bold text-gray-700">{{ $report->city->name }}</h5>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><span class="font-semibold">Total Data:</span> {{ $report->total }}</li>
                        <li><span class="font-semibold">Severely Stunted:</span> {{ $report->severely_stunted }}</li>
                        <li><span class="font-semibold">Stunted:</span> {{ $report->stunted }}</li>
                        <li><span class="font-semibold">Normal:</span> {{ $report->normal }}</li>
                        <li><span class="font-semibold">Tinggi:</span> {{ $report->tinggi }}</li>
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
@endsection
