<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-malba-gray-light border border-malba-gray-lighter rounded-lg font-semibold text-xs text-malba-gray-dark uppercase tracking-widest shadow-elegant hover:bg-malba-gray-lighter focus:outline-none focus:ring-2 focus:ring-malba-rose-pale focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
