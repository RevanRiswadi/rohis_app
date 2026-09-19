<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="mb-2 block text-sm font-bold text-slate-800">Alamat Email</label>
            <input id="email" class="w-full rounded-2xl border border-slate-200 bg-slate-50/80 px-4 py-3.5 font-medium text-slate-800 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 @error('email') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@rohis.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="text-sm font-bold text-slate-800">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-emerald-700 hover:text-emerald-800 transition" href="{{ route('password.request') }}">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>

            <input id="password" class="w-full rounded-2xl border border-slate-200 bg-slate-50/80 px-4 py-3.5 font-medium text-slate-800 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100 @error('password') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••">

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                <span class="ms-2 text.sm font-medium text-slate-600">Ingat Saya</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full rounded-2xl bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-600 px-6 py-4 text-base font-extrabold text-white shadow-xl shadow-emerald-600/25 transition duration-300 hover:-translate-y-0.5 hover:from-emerald-700 hover:to-teal-700 active:translate-y-0">
                Masuk ke Dashboard
            </button>
        </div>
    </form>
</x-guest-layout>
