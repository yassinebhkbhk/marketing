<!-- resources/views/users/index.blade.php -->

{{-- @extends('layouts.app') --}}
<title>Users List</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">Users</h1>
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse">
            <thead>
                <tr>
                    <th class="px-4 py-2 bg-gray-200">ID</th>
                    <th class="px-4 py-2 bg-gray-200">Name</th>
                    <th class="px-4 py-2 bg-gray-200">Email</th>
                    <th class="px-4 py-2 bg-gray-200">Status</th>
                    <th class="px-4 py-2 bg-gray-200">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="border px-4 py-2">{{ $user->id }}</td>
                        <td class="border px-4 py-2">{{ $user->name }}</td>
                        <td class="border px-4 py-2">{{ $user->email }}</td>
                        <td class="border px-4 py-2">{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td class="border flex items-center justify-center h-full p-1">
                            @if ($user->status == 1)
                                <form action="{{ route('users.deactivate', $user->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded">Deactivate</button>
                                </form>
                            @else
                                <form action="{{ route('users.activate', $user->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit"
                                        class="bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">Activate</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $users->links() }} <!-- Pagination links -->
    </div>
</div>
