<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-2">

            <h2 class="text-2xl font-semibold text-gray-900">
                Detail Laporan
            </h2>

            <p class="text-sm text-gray-500">
                Informasi lengkap mengenai laporan kehilangan atau barang yang ditemukan.
            </p>

        </div>

    </x-slot>


    <div class="bg-gray-50 py-8">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">


            {{-- Flash Message --}}
            @if (session('success'))

                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Detail Utama --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">


                {{-- Header Laporan --}}
                <div class="border-b border-gray-200 px-6 py-5">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                        <div class="min-w-0">

                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ $report->title }}
                            </h1>

                            <p class="mt-2 text-sm text-gray-500">
                                Dilaporkan oleh {{ $report->user->name }}
                            </p>

                        </div>


                        {{-- Badge --}}
                        <div class="flex flex-wrap gap-2">

                            @if ($report->type === 'LOST')

                                <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                    LOST
                                </span>

                            @else

                                <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                    FOUND
                                </span>

                            @endif


                            @switch($report->status)

                                @case('PENDING')

                                    <span class="inline-flex rounded-full bg-yellow-50 px-3 py-1 text-xs font-semibold text-yellow-700">
                                        PENDING
                                    </span>

                                    @break


                                @case('APPROVED')

                                    <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                        APPROVED
                                    </span>

                                    @break


                                @case('REJECTED')

                                    <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                        REJECTED
                                    </span>

                                    @break


                                @case('CLAIMED')

                                    <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                        CLAIMED
                                    </span>

                                    @break


                                @case('RETURNED')

                                    <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        RETURNED
                                    </span>

                                    @break


                                @case('CLOSED')

                                    <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                        CLOSED
                                    </span>

                                    @break


                                @default

                                    <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                        {{ $report->status }}
                                    </span>

                            @endswitch

                        </div>

                    </div>

                </div>


                {{-- Foto + Informasi --}}
                <div class="grid gap-8 p-6 lg:grid-cols-2">


                    {{-- Foto --}}
                    <div>

                        <h3 class="mb-4 text-lg font-semibold text-gray-900">
                            Foto Barang
                        </h3>


                        @if ($report->images->isNotEmpty())

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                                @foreach ($report->images as $image)

                                    <div class="overflow-hidden rounded-lg border border-gray-200 bg-gray-50">

                                        <img
                                            src="{{ asset('storage/' . $image->path) }}"
                                            alt="{{ $image->original_name }}"
                                            class="h-64 w-full object-cover"
                                        >

                                        <div class="px-3 py-2">

                                            <p class="truncate text-sm text-gray-600">
                                                {{ $image->original_name }}
                                            </p>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="flex h-64 items-center justify-center rounded-lg border border-dashed border-gray-300 bg-gray-50">

                                <div class="text-center">

                                    <div class="text-4xl">
                                        📦
                                    </div>

                                    <p class="mt-2 text-sm text-gray-500">
                                        Belum ada foto.
                                    </p>

                                </div>

                            </div>

                        @endif

                    </div>


                    {{-- Informasi --}}
                    <div>

                        <h3 class="mb-4 text-lg font-semibold text-gray-900">
                            Informasi Barang
                        </h3>


                        <div class="divide-y divide-gray-100 rounded-lg border border-gray-200">


                            {{-- Kategori --}}
                            <div class="grid grid-cols-1 gap-1 px-4 py-3 sm:grid-cols-3">

                                <span class="text-sm font-medium text-gray-500">
                                    Kategori
                                </span>

                                <span class="text-sm text-gray-900 sm:col-span-2">
                                    {{ $report->category->name }}
                                </span>

                            </div>


                            {{-- Lokasi --}}
                            <div class="grid grid-cols-1 gap-1 px-4 py-3 sm:grid-cols-3">

                                <span class="text-sm font-medium text-gray-500">
                                    Lokasi
                                </span>

                                <span class="text-sm text-gray-900 sm:col-span-2">
                                    {{ $report->location->name }}
                                </span>

                            </div>


                            {{-- Tanggal --}}
                            <div class="grid grid-cols-1 gap-1 px-4 py-3 sm:grid-cols-3">

                                <span class="text-sm font-medium text-gray-500">
                                    Tanggal Kejadian
                                </span>

                                <span class="text-sm text-gray-900 sm:col-span-2">
                                    {{ $report->event_date->format('d-m-Y') }}
                                </span>

                            </div>


                            {{-- Merek --}}
                            <div class="grid grid-cols-1 gap-1 px-4 py-3 sm:grid-cols-3">

                                <span class="text-sm font-medium text-gray-500">
                                    Merek
                                </span>

                                <span class="text-sm text-gray-900 sm:col-span-2">
                                    {{ $report->brand ?? '-' }}
                                </span>

                            </div>


                            {{-- Warna --}}
                            <div class="grid grid-cols-1 gap-1 px-4 py-3 sm:grid-cols-3">

                                <span class="text-sm font-medium text-gray-500">
                                    Warna
                                </span>

                                <span class="text-sm text-gray-900 sm:col-span-2">
                                    {{ $report->color ?? '-' }}
                                </span>

                            </div>


                            {{-- Kontak --}}
                            <div class="grid grid-cols-1 gap-1 px-4 py-3 sm:grid-cols-3">

                                <span class="text-sm font-medium text-gray-500">
                                    Kontak
                                </span>

                                <span class="break-words text-sm text-gray-900 sm:col-span-2">
                                    {{ $report->contact_info ?? '-' }}
                                </span>

                            </div>


                        </div>

                    </div>

                </div>


                {{-- Deskripsi --}}
                <div class="border-t border-gray-200 px-6 py-6">

                    <h3 class="mb-3 text-lg font-semibold text-gray-900">
                        Deskripsi
                    </h3>

                    <div class="rounded-lg bg-gray-50 p-4">

                        <p class="whitespace-pre-line text-sm leading-6 text-gray-700">
                            {{ $report->description }}
                        </p>

                    </div>

                </div>


            </div>


            {{-- Smart Matching --}}
            @if ($report->status === 'APPROVED')

                <div class="mt-5 rounded-xl border border-gray-200 bg-white p-4 shadow-sm">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">


                        <div class="min-w-0">

                            <h2 class="text-sm font-bold text-gray-900">
                                🔎 Smart Matching
                            </h2>

                            <p class="mt-1 text-xs text-gray-500">
                                Lihat laporan lain yang memiliki kemungkinan kecocokan
                                dengan laporan ini.
                            </p>

                        </div>


                        <a
                            href="{{ route('reports.matches', $report) }}"
                            class="inline-flex shrink-0 items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-blue-700"
                        >
                            Lihat Smart Matching →
                        </a>


                    </div>

                </div>

            @endif


            {{-- Claim --}}
            @if (
                auth()->check() &&
                $report->type === 'FOUND' &&
                $report->status === 'APPROVED' &&
                $report->user_id !== auth()->id()
            )

                <div class="mt-8 rounded-xl border border-blue-200 bg-blue-50 p-6">

                    <h2 class="text-lg font-bold text-gray-900">
                        Ajukan Klaim
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Jika kamu merasa barang ini adalah milikmu,
                        kamu dapat mengajukan klaim kepada staff untuk diverifikasi.
                    </p>

                    <div class="mt-4">

                        <a
                            href="{{ route('claims.create', $report) }}"
                            class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
                        >
                            Ajukan Klaim
                        </a>

                    </div>

                </div>

            @endif


            {{-- Action --}}
            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">


                {{-- Kembali --}}
                <a
                    href="{{ route('reports.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    ← Kembali ke Daftar Laporan
                </a>


                {{-- Edit & Hapus --}}
                @if (auth()->check() && auth()->id() === $report->user_id)

                    <div class="flex flex-col gap-3 sm:flex-row">


                        <a
                            href="{{ route('reports.edit', $report) }}"
                            class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800"
                        >
                            Edit Laporan
                        </a>


                        <form
                            action="{{ route('reports.destroy', $report) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus laporan ini?')"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-100 sm:w-auto"
                            >
                                Hapus Laporan
                            </button>

                        </form>


                    </div>

                @endif


            </div>


        </div>

    </div>

</x-app-layout>