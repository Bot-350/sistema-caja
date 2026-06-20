@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center whitespace-nowrap rounded-t-md border-b-2 border-malba-rose-pale px-1 pt-1 text-sm font-medium leading-5 text-malba-gray-dark focus:outline-none focus:border-malba-rose-dark transition duration-150 ease-in-out dark:text-gray-100'
            : 'inline-flex items-center whitespace-nowrap rounded-t-md border-b-2 border-transparent px-1 pt-1 text-sm font-medium leading-5 text-malba-gray-medium hover:border-malba-rose-pale hover:text-malba-gray-dark focus:outline-none focus:text-malba-gray-dark focus:border-malba-rose-pale transition duration-150 ease-in-out dark:text-gray-300 dark:hover:text-gray-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
