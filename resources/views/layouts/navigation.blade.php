<nav x-data="{ open: false }" class="bg-white rounded-b-[2rem] shadow-[0_15px_35px_rgba(0,0,0,0.05)] border-b border-slate-100 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <!-- Left Side: Logo & Brand -->
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 transition hover:opacity-90">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 sm:h-14 w-auto" />
                </a>
            </div>

            <!-- Right Side: Links & Profile Dropdown (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:gap-6">
                <!-- Navigation Link -->
                <a href="{{ url('/') }}" class="text-[#457C1A] hover:text-[#2d5211] font-bold text-sm sm:text-base transition">
                    {{ __('Beranda') }}
                </a>
                
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 rounded-full text-sm font-bold transition border border-[#457C1A] {{ request()->routeIs('admin.*') ? 'bg-[#457C1A] text-white shadow-md shadow-[#457C1A]/20' : 'bg-white text-[#457C1A] hover:bg-[#457C1A]/5' }}">
                        {{ __('Admin Panel') }}
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-full text-sm font-bold transition border border-[#457C1A] {{ request()->routeIs('dashboard') ? 'bg-[#457C1A] text-white shadow-md shadow-[#457C1A]/20' : 'bg-white text-[#457C1A] hover:bg-[#457C1A]/5' }}">
                        {{ __('Riwayat Analisis') }}
                    </a>
                @endif

                <!-- Profile Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-5 py-2.5 border border-slate-200 text-sm font-bold rounded-full text-slate-700 bg-slate-50 hover:bg-slate-100 focus:outline-none transition">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="ms-2 h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="text-sm font-semibold text-slate-700 hover:text-[#457C1A]">
                                {{ __('Profil Saya') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" class="text-sm font-semibold text-rose-600 hover:text-rose-700"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger Button (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2.5 rounded-xl text-[#457C1A] hover:bg-[#457C1A]/5 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-100 bg-white rounded-b-2xl">
        <div class="pt-2 pb-3 space-y-1.5 px-4">
            <a href="{{ url('/') }}" class="block px-4 py-2 text-sm font-bold text-slate-700 hover:text-[#457C1A]">
                {{ __('Beranda') }}
            </a>
            
            @if (Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="rounded-xl font-bold text-sm">
                    {{ __('Admin Panel') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-xl font-bold text-sm">
                    {{ __('Riwayat Analisis') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Profile Settings -->
        <div class="pt-4 pb-4 border-t border-slate-100 px-4">
            <div class="px-4 mb-3">
                <div class="font-bold text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-xs text-slate-400 mt-0.5">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-xl font-bold text-sm text-slate-700 hover:text-[#457C1A]">
                    {{ __('Profil Saya') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="rounded-xl font-bold text-sm text-rose-600"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
