<nav class="-mx-3 flex flex-1 justify-end">
    @auth
        <a
            href="{{ url('/dashboard') }}"
            class="rounded-lg px-3 py-2 text-malba-gray-dark ring-1 ring-transparent transition hover:text-malba-rose-dark hover:bg-malba-gray-light focus:outline-none focus-visible:ring-malba-rose-pale"
        >
            Dashboard
        </a>
    @else
        <a
            href="{{ route('login') }}"
            class="rounded-lg px-3 py-2 text-malba-gray-dark ring-1 ring-transparent transition hover:text-malba-rose-dark hover:bg-malba-gray-light focus:outline-none focus-visible:ring-malba-rose-pale"
        >
            Log in
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="rounded-lg px-3 py-2 text-malba-gray-dark ring-1 ring-transparent transition hover:text-malba-rose-dark hover:bg-malba-gray-light focus:outline-none focus-visible:ring-malba-rose-pale"
            >
                Register
            </a>
        @endif
    @endauth
</nav>
