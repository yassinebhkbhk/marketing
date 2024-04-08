<!-- resources/views/users/index.blade.php -->

{{-- @extends('layouts.app') --}}
<title>Users List</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    .bg-blue-500 {
        background-color: rgb(59 130 246) !important;
    }

    .hover\:bg-blue-700:hover {
        --tw-bg-opacity: 1;
        background-color: rgb(29 78 216 / var(--tw-bg-opacity)) !important;
    }

    .bg-green-500 {
        --tw-bg-opacity: 1;
        background-color: rgb(34 197 94 / var(--tw-bg-opacity)) !important;
    }

    .hover\:bg-green-700:hover {
        --tw-bg-opacity: 1;
        background-color: rgb(21 128 61 / var(--tw-bg-opacity)) !important;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-blue-600 leading-tight">
            {{ __('Users List') }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4 py-8">
        <form action="{{ route('user.search') }}" method="GET">
            <div class="mb-4 flex space-x-2">
                <input type="text" id="searchTerm" name="searchTerm" placeholder="Search Users:"
                    value="{{ isset($searchTerm) && isset($users) ? $searchTerm : '' }}"
                    class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Search</button>
            </div>
        </form>

        @if (isset($searchTerm) && isset($users) && $users->count() > 0)
            <ul class="list-disc">
                <table class="table-auto w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 bg-blue-500 border text-gray-100">ID</th>
                            <th class="px-4 py-2 bg-blue-500 border text-gray-100">Name</th>
                            <th class="px-4 py-2 bg-blue-500 border text-gray-100">Email</th>
                            <th class="px-4 py-2 bg-blue-500 border text-gray-100">Status</th>
                            <th class="px-4 py-2 bg-blue-500 border text-gray-100">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="bg-white">
                                <td class="border px-4 py-2">{{ $user->id }}</td>
                                <td class="border px-4 py-2">{{ $user->name }}</td>
                                <td class="border px-4 py-2">{{ $user->email }}</td>
                                <td class="border px-4 py-2">{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
                                <td class="border flex items-center justify-center h-full p-1">
                                    @if ($user->status == 1)
                                        <form action="{{ route('users.deactivate', $user->id) }}" method="POST"
                                            class="m-0">
                                            @csrf
                                            <button type="submit" class="text-green-500 py-1 px-6 rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('users.activate', $user->id) }}" method="POST"
                                            class="m-0">
                                            @csrf
                                            <button type="submit" class="text-red-500 py-1 px-4 rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <li><a href="{{ route('user.profile', $user->id) }}">{{ $user->name }}</a> ({{ $user->email }})</li> --}}


            </ul>
            {{ $users->links() }}
        @elseif (isset($users) && $users->count() > 0)
            {{-- <h1 class="text-3xl font-bold mb-4">Users</h1> --}}
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse rounded">
                    <thead>
                        <tr class="">
                            <th class="px-4 py-2 bg-blue-500 border text-gray-100">ID</th>
                            <th class="px-4 py-2 bg-blue-500 border text-gray-100">Name</th>
                            <th class="px-4 py-2 bg-blue-500 border text-gray-100">Email</th>
                            <th class="px-4 py-2 bg-blue-500 border text-gray-100">Status</th>
                            <th class="px-4 py-2 bg-blue-500 border text-gray-100">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="bg-white">
                                <td class="border px-4 py-2">{{ $user->id }}</td>
                                <td class="border px-4 py-2">{{ $user->name }}</td>
                                <td class="border px-4 py-2">{{ $user->email }}</td>
                                <td class="border px-4 py-2">{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
                                <td class="border flex items-center justify-center h-full p-1">
                                    @if ($user->status == 1)
                                        <form action="{{ route('users.deactivate', $user->id) }}" method="POST"
                                            class="m-0">
                                            @csrf
                                            <button type="submit" class="text-green-500 py-1 px-6 rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('users.activate', $user->id) }}" method="POST"
                                            class="m-0">
                                            @csrf
                                            <button type="submit" class="text-red-500 py-1 px-4 rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                </svg>
                                            </button>
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
        @else
            <p>No users found for your search term.</p>
        @endif
    </div>
</x-app-layout>
