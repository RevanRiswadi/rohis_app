<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="flex items-center shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-3 rounded-xl px-2 py-1.5 transition hover:bg-slate-100">
                        <x-application-logo class="block h-9 w-auto fill-current text-slate-800" />
                    </a>
                </div>

                <div class="hidden items-center gap-2 sm:-my-px sm:flex">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="rounded-xl px-3 py-2 text-sm font-semibold">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')" class="rounded-xl px-3 py-2 text-sm font-semibold">
                        {{ __('Anggota') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.galleries.index')" :active="request()->routeIs('admin.galleries.*')" class="rounded-xl px-3 py-2 text-sm font-semibold">
                        {{ __('Galeri') }}
                    </x-nav-link>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm font-bold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-100 hover:text-emerald-800">
                        <i data-lucide="house" class="h-4 w-4"></i>
                        {{ __('Kembali ke Halaman Web') }}
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-100 focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <i data-lucide="chevron-down" class="h-4 w-4"></i>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex items-center -me-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-slate-50 p-2 text-slate-600 transition hover:bg-slate-100 focus:outline-none">
                    <i x-show="!open" data-lucide="menu" class="h-6 w-6"></i>
                    <i x-show="open" data-lucide="x" class="h-6 w-6" style="display:none;"></i>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-slate-200 bg-white sm:hidden">
        <div class="space-y-2 px-4 py-3">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')">
                {{ __('Anggota') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.galleries.index')" :active="request()->routeIs('admin.galleries.*')">
                {{ __('Galeri') }}
            </x-responsive-nav-link>
            <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-700 transition hover:bg-emerald-100">
                <i data-lucide="house" class="h-4 w-4"></i>
                {{ __('Kembali ke Halaman Web') }}
            </a>
        </div>

        <div class="border-t border-slate-200 px-4 py-4">
            <div class="text-base font-semibold text-slate-800">{{ Auth::user()->name }}</div>
            <div class="text-sm text-slate-500">{{ Auth::user()->email }}</div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
