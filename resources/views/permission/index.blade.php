@extends('layouts.app')

@section('title')
    Dashboard - Permissions
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header flex justify-between items-center">
                        <a href="{{ route('admin.permission.create') }}" class="btn btn-sm btn-secondary ml-5 mt-5">Create</a>
                    </div>

                    <div class="card-body">

                        @if (session('message'))
                            <x-alert :type="session('type')" :message="session('message')" />
                        @endif

                        <table class="min-w-full bg-white border text-center">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">ID</th>
                                    <th class="py-2 px-4 border-b">Name</th>
                                    <th class="py-2 px-4 border-b">Display Name</th>
                                    <th class="py-2 px-4 border-b">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-2 px-4 border-b">{{ $permission->id }}</td>
                                        <td class="py-2 px-4 border-b">{{ $permission->name }}</td>
                                        <td class="py-2 px-4 border-b">{{ $permission->display_name }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <div class="flex justify-center space-x-2">
                                                <form action="{{ route('admin.permission.destroy', $permission->id) }}"
                                                    method="post" class="inline">
                                                    @method('DELETE') @csrf
                                                    <a href="{{ route('admin.permission.edit', $permission->id) }}"
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

                        {{ $permissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection