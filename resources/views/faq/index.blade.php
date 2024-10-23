@extends('layouts.app')

@section('title')
    Dashboard - FAQ
@endsection

@section('content')
    <div class="col-span-2">
        <div class="card h-full">
            <div class="card-header flex justify-between items-center ml-5">
                <h2 class="text-lg font-semibold">FAQ</h2>
                <a href="{{ route('faq.create') }}" class="btn btn-sm btn-secondary mr-5 mt-2">Create</a>
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
                                <th scope="col" class="p-4 font-semibold">Question</th>
                                <th scope="col" class="p-4 font-semibold">Answer</th>
                                <th scope="col" class="p-4 font-semibold">Published</th>
                                <th scope="col" class="p-4 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faqs as $faq)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4 text-sm">{{ $faq->id }}</td>
                                    <td class="p-4 text-sm">{{ $faq->question }}</td>
                                    <td class="p-4 text-sm">{{ Str::limit($faq->answer, 50, '...') }}</td>
                                    <td class="p-4 text-sm">{{ $faq->published ? 'Published' : 'Unpublished' }}</td>
                                    <td class="p-4 text-sm">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('faq.edit', $faq->id) }}"
                                                class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-1 rounded-full">Edit</a>
                                            <form id="delete-form-{{ $faq->id }}"
                                                action="{{ route('faq.destroy', $faq->id) }}" method="post" class="inline">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" onclick="confirmDelete({{ $faq->id }})"
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
                    {{ $faqs->links() }}
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
