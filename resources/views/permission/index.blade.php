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
                            <script>
                                Swal.fire({
                                    icon: "{{ session('type') }}",
                                    title: "{{ session('message') }}",
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            </script>
                        @endif

                        <!-- Membuat tabel responsive -->
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">ID</th>
                                        <th scope="col" class="py-3 px-6">Name</th>
                                        <th scope="col" class="py-3 px-6">Display Name</th>
                                        <th scope="col" class="py-3 px-6">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="py-2 px-6">{{ $permission->id }}</td>
                                            <td class="py-2 px-6">{{ $permission->name }}</td>
                                            <td class="py-2 px-6">{{ $permission->display_name }}</td>
                                            <td class="py-2 px-6">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.permission.edit', $permission->id) }}"
                                                        class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-1 rounded-full">Edit</a>
                                                    <form id="delete-form-{{ $permission->id }}"
                                                        action="{{ route('admin.permission.destroy', $permission->id) }}"
                                                        method="post">
                                                        @method('DELETE') @csrf
                                                        <button type="button"
                                                            class="bg-red-500 text-white hover:bg-red-600 px-3 py-1 rounded-full"
                                                            onclick="confirmDelete({{ $permission->id }})">Delete</button>
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
                            {{ $permissions->links() }}
                        </div>
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
            })
        }
    </script>
@endsection
