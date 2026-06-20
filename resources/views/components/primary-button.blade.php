<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-malba-rose-pale border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-malba-rose-dark focus:bg-malba-rose-dark active:scale-95 focus:outline-none focus:ring-2 focus:ring-malba-rose-pale focus:ring-offset-2 transition ease-in-out duration-150 shadow-elegant']) }}>
    {{ $slot }}
</button>
