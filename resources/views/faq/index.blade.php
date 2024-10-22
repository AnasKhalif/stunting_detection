@extends('layouts.app')

@section('title')
    Dashboard - FAQ
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header flex justify-between items-center ml-5">
                        <h2 class="text-lg font-semibold">FAQ</h2>
                        <a href="{{ route('faq.create') }}" class="btn btn-sm btn-secondary mr-5 mt-2">Create</a>
                    </div>

                    <div class="card-body">
                        @if (session('message'))
                            <x-alert :type="session('type')" :message="session('message')" />
                        @endif

                        <table class="min-w-full bg-white border text-center">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-2 px-4 border-b">ID</th>
                                    <th class="py-2 px-4 border-b">Question</th>
                                    <th class="py-2 px-4 border-b">Answer</th>
                                    <th class="py-2 px-4 border-b">Published</th>
                                    <th class="py-2 px-4 border-b">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faqs as $faq)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-2 px-4 border-b">{{ $faq->id }}</td>
                                        <td class="py-2 px-4 border-b">{{ $faq->question }}</td>
                                        <td class="py-2 px-4 border-b">{{ $faq->answer }}</td>
                                        <td class="py-2 px-4 border-b">{{ $faq->published ? 'Published' : 'Unpublished' }}
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('faq.edit', $faq->id) }}"
                                                    class="bg-blue-500 text-white hover:bg-blue-600 px-3 py-1 rounded-full">Edit</a>
                                                <form action="{{ route('faq.destroy', $faq->id) }}" method="post"
                                                    class="inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-red-500 text-white hover:bg-red-600 px-3 py-1 rounded-full">Delete</button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $faqs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
