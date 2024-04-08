@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'flex items-center p-2 text-blue-600 rounded-lg dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-700 group'
            : 'flex items-center p-2 text-gray-600 rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-blue-700 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if (isset($icon))
        {{ $icon }}
    @endif

    <span class="ms-3">
        {{ $slot }}
    </span>
</a>
