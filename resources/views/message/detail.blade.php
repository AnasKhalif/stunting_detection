@extends('layouts.app')

@section('title')
    Detail Message - {{ $message->subject }}
@endsection

@section('content')
    <div class="col-span-2">
        <div class="card h-full">
            <div class="card-body">
                <h4 class="text-gray-600 text-2xl font-semibold mb-5">Detail Message</h4>

                <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                    <div class="mb-4">
                        <strong class="text-gray-700">Name:</strong>
                        <span class="text-gray-500">{{ $message->name }}</span>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Email:</strong>
                        <span class="text-gray-500">{{ $message->email }}</span>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Phone:</strong>
                        <span class="text-gray-500">{{ $message->phone }}</span>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Subject:</strong>
                        <span class="text-gray-500">{{ $message->subject }}</span>
                    </div>
                    <div class="mb-4">
                        <strong class="text-gray-700">Message:</strong>
                        <p class="text-gray-500">{{ $message->message }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('message.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition duration-200">
                        Back to Messages
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
