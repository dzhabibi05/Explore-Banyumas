<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-white font-semibold text-sm mb-1.5">Email</label>
            <input id="email" class="w-full bg-white text-slate-800 px-6 py-3 rounded-full border-none focus:ring-2 focus:ring-green-400 focus:outline-none shadow-inner" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-200 text-xs" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <label for="password" class="block text-white font-semibold text-sm mb-1.5">Password</label>
            <input id="password" class="w-full bg-white text-slate-800 px-6 py-3 rounded-full border-none focus:ring-2 focus:ring-green-400 focus:outline-none shadow-inner" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-200 text-xs" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-5 px-2">
            <label for="remember_me" class="inline-flex items-center text-white text-xs cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-green-700 focus:ring-green-500" name="remember">
                <span class="ms-2 font-medium">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs text-white/95 hover:text-white hover:underline transition font-medium" href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif
        </div>

        <!-- Footer / Submit Button -->
        <div class="flex items-center justify-end gap-6 mt-8">
            @if (Route::has('register'))
                <a class="border border-[#5DB02F] text-white hover:bg-[#5DB02F] px-8 py-2.5 rounded-full font-bold transition hover:shadow-lg hover:shadow-green-900/50" href="{{ route('register') }}">
                    Daftar Akun
                </a>
            @endif
            
            <button type="submit" class="border border-[#5DB02F] text-white hover:bg-[#5DB02F] px-8 py-2.5 rounded-full font-bold transition hover:shadow-lg hover:shadow-green-900/50">
                Masuk
            </button>
        </div>
    </form>
</x-guest-layout>
