<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        // Redirigir según el rol del usuario
        if (auth()->user()->role === 'admin') {
            $this->redirect(route('dashboard'), navigate: true);
        } else {
            $this->redirect(route('cajero.dashboard'), navigate: true);
        }
    }
}; ?>

<div>
    <div class="mb-6 flex items-start justify-between gap-3">
        <div class="text-center flex-1">
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-malba-gray-medium dark:text-gray-400">MALBA</p>
            <h1 class="mt-1 text-2xl font-bold tracking-wide text-malba-gray-dark dark:text-gray-100">Iniciar sesión</h1>
            <p class="mt-2 text-sm text-malba-gray-medium dark:text-gray-400">Accede al sistema con una presentación elegante y minimalista.</p>
        </div>

        <button type="button" onclick="window.MALBAToggleTheme()" class="inline-flex shrink-0 items-center rounded-full border border-malba-gray-lighter bg-white px-3 py-2 text-xs font-semibold text-malba-gray-dark shadow-elegant transition-all duration-200 hover:border-malba-rose-pale hover:text-malba-rose-dark hover:shadow-elegant-lg dark:border-[#353b44] dark:bg-[#2b313a] dark:text-gray-100 dark:hover:border-malba-rose-pale dark:hover:text-malba-rose-pale" x-data="{ dark: document.documentElement.classList.contains('dark') }" @malba-theme-changed.window="dark = document.documentElement.classList.contains('dark')">
            <span x-text="dark ? '☀️ Claro' : '🌙 Oscuro'"></span>
        </button>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 rounded-xl border border-malba-gray-lighter bg-white px-4 py-3 text-sm text-malba-gray-dark shadow-elegant dark:border-[#353b44] dark:bg-[#2b313a] dark:text-gray-100" :status="session('status')" />

    <form wire:submit.prevent="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-malba-gray-dark dark:text-gray-100" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full rounded-xl border-malba-gray-lighter bg-malba-gray-light px-3 py-2 text-malba-gray-dark shadow-elegant transition-colors duration-200 focus:border-malba-rose-pale focus:bg-white focus:ring-2 focus:ring-malba-rose-pale/20 dark:border-[#353b44] dark:bg-[#2b313a] dark:text-gray-100 dark:placeholder:text-gray-500 dark:focus:bg-[#242a31]" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-red-600 dark:text-red-300" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-malba-gray-dark dark:text-gray-100" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full rounded-xl border-malba-gray-lighter bg-malba-gray-light px-3 py-2 text-malba-gray-dark shadow-elegant transition-colors duration-200 focus:border-malba-rose-pale focus:bg-white focus:ring-2 focus:ring-malba-rose-pale/20 dark:border-[#353b44] dark:bg-[#2b313a] dark:text-gray-100 dark:placeholder:text-gray-500 dark:focus:bg-[#242a31]"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-red-600 dark:text-red-300" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-malba-gray-lighter text-malba-rose-pale shadow-sm focus:ring-malba-rose-pale" name="remember">
                <span class="ms-2 text-sm text-malba-gray-medium dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="rounded-md text-sm text-malba-gray-medium underline decoration-malba-gray-lighter underline-offset-4 transition-colors duration-200 hover:text-malba-rose-dark focus:outline-none focus:ring-2 focus:ring-malba-rose-pale focus:ring-offset-2 dark:text-gray-400 dark:hover:text-malba-rose-pale dark:decoration-[#4b5563]" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
