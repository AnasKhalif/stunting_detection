{{-- @extends('layouts.app')

@section('title')
    Dashboard - Articles
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header flex justify-between items-center ml-5">
                        <h2 class="text-lg font-semibold">Articles</h2>
                        <a href="{{ route('article.create') }}" class="btn btn-sm btn-secondary mr-5 mt-2">Create</a>
                    </div>

                    <div class="card-body">
                        @if (session('message'))
                            <script>
                                Swal.fire({
                                    icon: "{{ session('type') }}",
                                    title: "{{ session('message') }}",
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            </script>
                        @endif

                        <table class="min-w-full bg-white border text-center">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-2 px-4 border-b">ID</th>
                                    <th class="py-2 px-4 border-b">Title</th>
                                    <th class="py-2 px-4 border-b">Author</th>
                                    <th class="py-2 px-4 border-b">Published</th>
                                    <th class="py-2 px-4 border-b">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-2 px-4 border-b">{{ $article->id }}</td>
                                        <td class="py-2 px-4 border-b">{{ $article->title }}</td>
                                        <td class="py-2 px-4 border-b">{{ $article->user->name }}</td>
                                        <td class="py-2 px-4 border-b">
                                            {{ $article->published ? 'Published' : 'Unpublished' }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('article.edit', $article->id) }}"
                                                    class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 rounded-full">Edit</a>
                                                <form id="delete-form-{{ $article->id }}"
                                                    action="{{ route('article.destroy', $article->id) }}" method="post"
                                                    class="inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="button" onclick="confirmDelete({{ $article->id }})"
                                                        class="bg-red-500 text-white hover:bg-red-600 px-3 py-1 rounded-full">Delete</button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection --}}


@extends('layouts.app')

@section('title')
    Dashboard - Articles
@endsection

@section('content')
    <div class="col-span-2">
        <div class="card h-full">
            <div class="card-header flex justify-between items-center ml-5">
                <h2 class="text-lg font-semibold">Articles</h2>
                <a href="{{ route('article.create') }}" class="btn btn-sm btn-secondary mr-5 mt-2">Create</a>
            </div>

            <div class="card-body">
                @if (session('message'))
                    <script>
                        Swal.fire({
                            icon: "{{ session('type') }}",
                            title: "{{ session('message') }}",
                            showConfirmButton: false,
                            timer: 3000
                        });
                    </script>
                @endif

                <div class="relative overflow-x-auto">
                    <table class="text-left w-full whitespace-nowrap text-sm text-gray-500 text-center">
                        <thead>
                            <tr class="text-sm">
                                <th scope="col" class="p-4 font-semibold">ID</th>
                                <th scope="col" class="p-4 font-semibold">Title</th>
                                <th scope="col" class="p-4 font-semibold">Author</th>
                                <th scope="col" class="p-4 font-semibold">Published</th>
                                <th scope="col" class="p-4 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $article)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4 text-sm">{{ $article->id }}</td>
                                    <td class="p-4 text-sm">{{ $article->title }}</td>
                                    <td class="p-4 text-sm">{{ $article->user->name }}</td>
                                    <td class="p-4 text-sm">
                                        {{ $article->published ? 'Published' : 'Unpublished' }}
                                    </td>
                                    <td class="p-4 text-sm">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('article.edit', $article->id) }}"
                                                class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-1 rounded-full">Edit</a>
                                            <form id="delete-form-{{ $article->id }}"
                                                action="{{ route('article.destroy', $article->id) }}" method="post"
                                                class="inline">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" onclick="confirmDelete({{ $article->id }})"
                                                    class="bg-red-500 text-white hover:bg-red-600 px-3 py-1 rounded-full">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination links -->
                <div class="mt-4">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
