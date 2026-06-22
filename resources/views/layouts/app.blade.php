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
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-malba-gray-light text-malba-gray-dark dark:bg-[#1f232b] dark:text-gray-100">
        <div class="min-h-screen bg-malba-gray-light text-malba-gray-dark dark:bg-[#1f232b] dark:text-gray-100">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow-elegant border-b border-malba-gray-lighter dark:border-[#353b44] dark:bg-[#242a31]">
                    <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @livewireScripts
    </body>
</html>
