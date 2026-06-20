<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>
            (function () {
                const applyTheme = function (theme) {
                    document.documentElement.classList.toggle('dark', theme === 'dark');
                    window.dispatchEvent(new CustomEvent('malba-theme-changed', { detail: { theme: theme } }));
                };

                const syncTheme = function () {
                    const storedTheme = localStorage.getItem('malba-theme');
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    applyTheme(storedTheme === 'dark' || (!storedTheme && prefersDark) ? 'dark' : 'light');
                };

                syncTheme();

                window.addEventListener('storage', function (event) {
                    if (event.key === 'malba-theme') {
                        applyTheme(event.newValue === 'dark' ? 'dark' : 'light');
                    }
                });

                document.addEventListener('livewire:navigated', syncTheme);
            })();

            window.MALBAToggleTheme = function () {
                const isDark = document.documentElement.classList.toggle('dark');
                const theme = isDark ? 'dark' : 'light';
                localStorage.setItem('malba-theme', theme);
                window.dispatchEvent(new CustomEvent('malba-theme-changed', { detail: { theme: theme } }));
            };
        </script>

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-malba-gray-dark antialiased bg-malba-gray-light dark:bg-[#1f232b] dark:text-gray-100">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-malba-gray-light dark:bg-[#1f232b]">
            <div class="mb-4 text-center">
                <a href="/" wire:navigate class="inline-flex items-center gap-3 rounded-full px-3 py-2 hover:bg-white/70 transition-colors duration-200 dark:hover:bg-white/5">
                    <x-application-logo class="h-16 w-16 fill-current text-malba-rose-pale" />
                    <span class="text-left leading-tight">
                        <span class="block text-[11px] font-semibold uppercase tracking-[0.35em] text-malba-gray-medium dark:text-gray-400">MALBA</span>
                        <span class="block text-lg font-bold tracking-wide text-malba-gray-dark dark:text-gray-100">THE BEAUTY HOUSE</span>
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-6 py-5 bg-white shadow-elegant-lg border border-malba-gray-lighter overflow-hidden sm:rounded-2xl dark:bg-[#242a31] dark:border-[#353b44]">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
