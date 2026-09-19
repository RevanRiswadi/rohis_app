<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-700">Akun</p>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">
                    {{ __('Profile') }}
                </h2>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700 transition hover:bg-emerald-100">
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-4 shadow-[0_25px_60px_rgba(15,23,42,0.06)] sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-4 shadow-[0_25px_60px_rgba(15,23,42,0.06)] sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-4 shadow-[0_25px_60px_rgba(15,23,42,0.06)] sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
