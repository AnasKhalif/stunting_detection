@extends('layouts.app')

@section('title')
    Dashboard - Message
@endsection

@section('content')
    <div class="col-span-2">
        <div class="card h-full">
            <div class="card-body">
                <h4 class="text-gray-500 text-lg font-semibold mb-5">Message User</h4>
                <div class="relative overflow-x-auto">
                    <!-- table -->
                    <table class="text-left w-full whitespace-nowrap text-sm text-gray-500">
                        <thead>
                            <tr class="text-sm">
                                <th scope="col" class="p-4 font-semibold">Profile</th>
                                <th scope="col" class="p-4 font-semibold">Email</th>
                                <th scope="col" class="p-4 font-semibold">Phone</th>
                                <th scope="col" class="p-4 font-semibold">Subject</th>
                                <th scope="col" class="p-4 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                                <tr>
                                    <td class="p-4 text-sm">
                                        <div class="flex gap-6 items-center">
                                            <div class="h-12 w-12 inline-block">
                                                <img src="{{ asset('./img/default-avatar.jpeg') }}" alt=""
                                                    class="rounded-full w-100">
                                            </div>
                                            <div class="flex flex-col gap-1 text-gray-500">
                                                <h3 class=" font-bold">{{ $message->name }}</h3>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <h3 class="font-medium">{{ $message->email }}</h3>
                                    </td>
                                    <td class="p-4">
                                        <h3 class="font-medium">{{ $message->phone }}</h3>
                                    </td>
                                    <td class="p-4">
                                        <h3 class="font-medium">{{ $message->subject }}</h3>
                                    </td>

                                    <td class="p-4">
                                        <a href="{{ route('message.show', $message->id) }}"
                                            class="text-blue-500 hover:underline flex items-center">
                                            <i class="ti ti-mail-opened text-2xl"></i>
                                            <span class="ml-2">Detail</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
