<!-- resources/views/users/index.blade.php -->

{{-- @extends('layouts.app') --}}
<title>Pages List</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

@php
    function getRandomColor()
    {
        $colors = ['#007BFF', '#0069D9', '#0056B3', '#004380'];
        return $colors[array_rand($colors)];
    }
@endphp

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">Pages</h1>
    @if ($pages->isEmpty())
        <p>No pages available.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($pages as $page)
                <div class="bg-white rounded-lg shadow-md p-6 relative">

                    <div class="absolute top-0 left-0 w-full h-2 rounded-t-lg"
                        style="background-color: {{ getRandomColor() }}"></div>
                    <h2 class="text-2xl font-bold mb-2">{{ $page->NomPage }}</h2>
                    <p><strong>Location:</strong> {{ $page->Location }}</p>
                    <p><strong>Created at:</strong> {{ $page->created_at->format('Y-m-d') }}</p>

                    <div class="mt-auto">
                        @if ($page->link)
                            <a href="{{ $page->link }}"
                                class="text-blue-500 hover:text-blue-700 font-bold py-2 rounded inline-block">Visit
                                Page</a>
                        @else
                            <p>No link available</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $pages->links() }} <!-- Pagination links -->
        </div>
    @endif
</div>
