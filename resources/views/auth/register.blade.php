<x-guest-layout title="Daftar Akun">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-white font-semibold text-sm mb-1.5">Name</label>
            <input id="name" class="w-full bg-white text-slate-800 px-6 py-3 rounded-full border-none focus:ring-2 focus:ring-green-400 focus:outline-none shadow-inner" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-200 text-xs" />
        </div>

        <!-- Email Address -->
        <div class="mt-5">
            <label for="email" class="block text-white font-semibold text-sm mb-1.5">Email</label>
            <input id="email" class="w-full bg-white text-slate-800 px-6 py-3 rounded-full border-none focus:ring-2 focus:ring-green-400 focus:outline-none shadow-inner" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-200 text-xs" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <label for="password" class="block text-white font-semibold text-sm mb-1.5">Password</label>
            <input id="password" class="w-full bg-white text-slate-800 px-6 py-3 rounded-full border-none focus:ring-2 focus:ring-green-400 focus:outline-none shadow-inner" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-200 text-xs" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-5">
            <label for="password_confirmation" class="block text-white font-semibold text-sm mb-1.5">Confirm Password</label>
            <input id="password_confirmation" class="w-full bg-white text-slate-800 px-6 py-3 rounded-full border-none focus:ring-2 focus:ring-green-400 focus:outline-none shadow-inner" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-200 text-xs" />
        </div>

        <!-- Footer / Submit Button -->
        <div class="flex items-center justify-end gap-6 mt-8">
            <a class="border border-[#5DB02F] text-white hover:bg-[#5DB02F] px-8 py-2.5 rounded-full font-bold transition hover:shadow-lg hover:shadow-green-900/50" href="{{ route('login') }}">
                Masuk
            </a>

            <button type="submit" class="border border-[#5DB02F] text-white hover:bg-[#5DB02F] px-8 py-2.5 rounded-full font-bold transition hover:shadow-lg hover:shadow-green-900/50">
                Register
            </button>
        </div>
    </form>
</x-guest-layout>
