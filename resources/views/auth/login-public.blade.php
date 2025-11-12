@extends('layouts.app2')
@if (Route::has('password.request'))
    <a class="text-green-700 hover:underline" href="{{ route('password.request') }}">Lupa kata sandi?</a>
@endif
</div>
</div>
</div>


<div class="flex items-center justify-between gap-4">
    <a href="{{ route('beranda') }}"
        class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
        <x-heroicon-o-arrow-left class="size-4" /> Kembali
    </a>
    <button type="submit"
        class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
        <x-heroicon-o-arrow-right-on-rectangle class="size-4" /> Masuk Admin
    </button>
</div>
</form>


{{-- Single Sign-On placeholder --}}
<div class="mt-6 border-t pt-6">
    <p class="text-sm text-gray-600 mb-3">Atau masuk dengan</p>
    <div class="flex flex-wrap gap-2">
        <a href="#"
            class="inline-flex items-center justify-center gap-2 rounded-lg ring-1 ring-black/10 px-4 py-2 text-sm hover:bg-gray-50">
            <x-heroicon-o-key class="size-4" /> SSO Pemda (coming soon)
        </a>
    </div>
</div>
</div>
</div>
</article>


{{-- SIDEBAR --}}
<aside class="space-y-6 lg:sticky lg:top-20">
    {{-- Info Keamanan --}}
    <div class="rounded-xl bg-white shadow p-5 ring-1 ring-black/5">
        <div class="flex items-start gap-3">
            <span
                class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-green-50 ring-1 ring-green-200">
                <x-heroicon-o-shield-check class="size-6 text-green-700" />
            </span>
            <div class="min-w-0">
                <h3 class="font-semibold text-gray-900">Keamanan Data</h3>
                <p class="mt-1 text-sm text-gray-600">Data pribadi dilindungi dan hanya digunakan untuk verifikasi
                    layanan publik.</p>
            </div>
        </div>
    </div>


    {{-- Kontak Bantuan --}}
    <div class="rounded-xl bg-white shadow p-5 ring-1 ring-black/5">
        <h3 class="font-semibold text-gray-900 mb-2">Butuh Bantuan?</h3>
        <ul class="text-sm text-gray-700 space-y-1">
            <li>WhatsApp Admin: <a class="text-green-700 hover:underline"
                    href="https://wa.me/6281234567890">0812‑3456‑7890</a></li>
            <li>Email: <a class="text-green-700 hover:underline"
                    href="mailto:admin@mentuda.go.id">admin@mentuda.go.id</a></li>
        </ul>
    </div>


    {{-- Kembali --}}
    <div class="bg-white rounded-xl shadow p-4">
        <a href="{{ route('layanan') }}"
            class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
            <x-heroicon-o-arrow-left class="size-4" /> Kembali ke Layanan
        </a>
    </div>
</aside>
</div>
</section>
@endsection
