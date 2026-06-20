@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-malba-rose-pale text-start text-base font-semibold text-malba-rose-dark bg-malba-gray-light focus:outline-none focus:text-malba-rose-dark focus:bg-malba-gray-lighter focus:border-malba-rose-dark transition duration-150 ease-in-out dark:bg-[#2b313a] dark:text-malba-rose-pale'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-malba-gray-medium hover:text-malba-gray-dark hover:bg-malba-gray-light hover:border-malba-rose-pale focus:outline-none focus:text-malba-gray-dark focus:bg-malba-gray-light focus:border-malba-rose-pale transition duration-150 ease-in-out dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
