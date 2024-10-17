@extends('layouts.app')

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
                            <x-alert :type="session('type')" :message="session('message')" />
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
                                                <form action="{{ route('article.destroy', $article->id) }}" method="post"
                                                    class="inline">
                                                    @method('DELETE') @csrf
                                                    <a href="{{ route('article.edit', $article->id) }}"
                                                        class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 rounded-full">Edit</a>
                                                    <button type="submit"
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
@endsection
