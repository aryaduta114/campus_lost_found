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

                <div class="border-b border-gray-200 px-6 py-5">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ $report->title }}
                            </h1>

                            <p class="mt-2 text-sm text-gray-500">
                                Dilaporkan oleh {{ $report->user->name }}
                            </p>
                        </div>

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
                                    <div class="text-4xl">📦</div>

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

                            <div class="grid grid-cols-1 gap-1 px-4 py-3 sm:grid-cols-3">
                                <span class="text-sm font-medium text-gray-500">
                                    Kategori
                                </span>

                                <span class="text-sm text-gray-900 sm:col-span-2">
                                    {{ $report->category->name }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 gap-1 px-4 py-3 sm:grid-cols-3">
                                <span class="text-sm font-medium text-gray-500">
                                    Lokasi
                                </span>

                                <span class="text-sm text-gray-900 sm:col-span-2">
                                    {{ $report->location->name }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 gap-1 px-4 py-3 sm:grid-cols-3">
                                <span class="text-sm font-medium text-gray-500">
                                    Tanggal Kejadian
                                </span>

                                <span class="text-sm text-gray-900 sm:col-span-2">
                                    {{ $report->event_date->format('d-m-Y') }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 gap-1 px-4 py-3 sm:grid-cols-3">
                                <span class="text-sm font-medium text-gray-500">
                                    Merek
                                </span>

                                <span class="text-sm text-gray-900 sm:col-span-2">
                                    {{ $report->brand ?? '-' }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 gap-1 px-4 py-3 sm:grid-cols-3">
                                <span class="text-sm font-medium text-gray-500">
                                    Warna
                                </span>

                                <span class="text-sm text-gray-900 sm:col-span-2">
                                    {{ $report->color ?? '-' }}
                                </span>
                            </div>

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
            <div class="mt-8 rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-5">

                    <div class="flex items-center justify-between">

                        <div>
                            <h2 class="text-xl font-bold text-gray-900">
                                Smart Matching
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Kemungkinan laporan lain yang memiliki kecocokan.
                            </p>
                        </div>

                    </div>

                </div>

                <div class="p-6">

                    @if ($matches->isEmpty())

                        <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center">

                            <div class="text-4xl">🔎</div>

                            <h3 class="mt-3 text-base font-semibold text-gray-900">
                                Belum ada kecocokan
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Belum ditemukan laporan yang memiliki kecocokan dengan laporan ini.
                            </p>

                        </div>

                    @else

                        <div class="mb-5 rounded-lg bg-blue-50 px-4 py-3 text-sm text-blue-700">
                            Sistem menemukan
                            <strong>{{ $matches->count() }}</strong>
                            kemungkinan laporan yang cocok.
                        </div>

                        <div class="space-y-5">

                            @foreach ($matches as $match)

                                @php
                                    $matchedReport = $report->type === 'LOST'
                                        ? $match->foundReport
                                        : $match->lostReport;
                                @endphp

                                <div class="overflow-hidden rounded-xl border border-gray-200">

                                    <div class="flex flex-col gap-4 border-b border-gray-200 bg-gray-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                {{ $matchedReport->title }}
                                            </h3>

                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ $matchedReport->category->name }}
                                                •
                                                {{ $matchedReport->location->name }}
                                            </p>
                                        </div>

                                        <div class="flex items-center gap-2">

                                            @if ($match->score >= 80)

                                                <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                                    Sangat Cocok
                                                </span>

                                            @else

                                                <span class="rounded-full bg-yellow-50 px-3 py-1 text-xs font-semibold text-yellow-700">
                                                    Kemungkinan Cocok
                                                </span>

                                            @endif

                                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">
                                                {{ $match->score }}%
                                            </span>

                                        </div>

                                    </div>

                                    <div class="grid gap-6 p-5 lg:grid-cols-3">

                                        {{-- Foto Matching --}}
                                        <div>

                                            @if ($matchedReport->images->isNotEmpty())

                                                <img
                                                    src="{{ asset('storage/' . $matchedReport->images->first()->path) }}"
                                                    alt="{{ $matchedReport->images->first()->original_name }}"
                                                    class="h-48 w-full rounded-lg object-cover"
                                                >

                                            @else

                                                <div class="flex h-48 items-center justify-center rounded-lg bg-gray-100">
                                                    <div class="text-center">
                                                        <div class="text-3xl">📦</div>

                                                        <p class="mt-1 text-xs text-gray-500">
                                                            Tidak ada foto
                                                        </p>
                                                    </div>
                                                </div>

                                            @endif

                                        </div>

                                        {{-- Informasi Matching --}}
                                        <div class="lg:col-span-2">

                                            <div class="grid gap-4 sm:grid-cols-2">

                                                <div>
                                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                                        Jenis
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                                        {{ $matchedReport->type }}
                                                    </p>
                                                </div>

                                                <div>
                                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                                        Tanggal Kejadian
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                                        {{ $matchedReport->event_date->format('d-m-Y') }}
                                                    </p>
                                                </div>

                                                <div>
                                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                                        Merek
                                                    </p>

                                                    <p class="mt-1 text-sm text-gray-900">
                                                        {{ $matchedReport->brand ?? '-' }}
                                                    </p>
                                                </div>

                                                <div>
                                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                                        Warna
                                                    </p>

                                                    <p class="mt-1 text-sm text-gray-900">
                                                        {{ $matchedReport->color ?? '-' }}
                                                    </p>
                                                </div>

                                            </div>

                                            <div class="mt-5">

                                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                                    Deskripsi
                                                </p>

                                                <p class="mt-1 whitespace-pre-line text-sm leading-6 text-gray-700">
                                                    {{ $matchedReport->description }}
                                                </p>

                                            </div>

                                            <div class="mt-5">

                                                <a
                                                    href="{{ route('reports.show', $matchedReport) }}"
                                                    class="inline-flex items-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800"
                                                >
                                                    Lihat Laporan
                                                    <span class="ml-2">→</span>
                                                </a>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @endif

                </div>

            </div>


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

                <a
                    href="{{ route('reports.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    ← Kembali ke Daftar Laporan
                </a>


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