<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Smart Matching
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Kemungkinan laporan lain yang memiliki kecocokan dengan laporan ini.
                </p>
            </div>

            <a
                href="{{ route('reports.show', $report) }}"
                class="inline-flex items-center justify-center rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-200"
            >
                ← Kembali ke Detail
            </a>

        </div>

    </x-slot>

    <div class="py-6">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            {{-- Laporan utama --}}
            <div class="mb-5 rounded-xl border border-gray-200 bg-white p-4 shadow-sm">

                <div class="flex items-center justify-between gap-3">

                    <div class="min-w-0">

                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                            Laporan yang sedang dicocokkan
                        </p>

                        <h1 class="mt-1 truncate text-base font-bold text-gray-900">
                            {{ $report->title }}
                        </h1>

                        <p class="mt-1 text-xs text-gray-500">
                            {{ $report->category->name }}
                            •
                            {{ $report->location->name }}
                            •
                            {{ $report->type }}
                        </p>

                    </div>

                    <span
                        class="shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold
                        {{ $report->type === 'LOST'
                            ? 'bg-red-50 text-red-700'
                            : 'bg-green-50 text-green-700' }}"
                    >
                        {{ $report->type }}
                    </span>

                </div>

            </div>

            {{-- Smart Matching --}}
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-4 py-4">

                    <div class="flex items-center justify-between gap-3">

                        <div>

                            <h2 class="text-lg font-bold text-gray-900">
                                Hasil Matching
                            </h2>

                            <p class="mt-1 text-xs text-gray-500">
                                Laporan lain yang memiliki kemungkinan kecocokan.
                            </p>

                        </div>

                        <span class="shrink-0 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                            {{ $matches->count() }} hasil
                        </span>

                    </div>

                </div>

                <div class="p-4">

                    @if ($matches->isEmpty())

                        <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 px-5 py-10 text-center">

                            <div class="text-3xl">
                                🔎
                            </div>

                            <h3 class="mt-3 text-sm font-semibold text-gray-900">
                                Belum ada kecocokan
                            </h3>

                            <p class="mx-auto mt-1 max-w-md text-xs leading-5 text-gray-500">
                                Belum ditemukan laporan yang memiliki kecocokan dengan laporan ini.
                            </p>

                        </div>

                    @else

                        <div class="space-y-3">

                            @foreach ($matches as $match)

                                @php
                                    $matchedReport = $report->type === 'LOST'
                                        ? $match->foundReport
                                        : $match->lostReport;
                                @endphp

                                <div class="overflow-hidden rounded-lg border border-gray-200">

                                    {{-- Header kandidat --}}
                                    <div class="flex flex-col gap-2 border-b border-gray-200 bg-gray-50 px-3 py-3 sm:flex-row sm:items-center sm:justify-between">

                                        <div class="min-w-0">

                                            <h3 class="truncate text-sm font-semibold text-gray-900">
                                                {{ $matchedReport->title }}
                                            </h3>

                                            <p class="mt-0.5 truncate text-xs text-gray-500">
                                                {{ $matchedReport->category->name }}
                                                •
                                                {{ $matchedReport->location->name }}
                                            </p>

                                        </div>

                                        <div class="flex shrink-0 items-center gap-1.5">

                                            @if ($match->score >= 80)

                                                <span class="rounded-full bg-green-50 px-2 py-0.5 text-[11px] font-semibold text-green-700">
                                                    Sangat Cocok
                                                </span>

                                            @else

                                                <span class="rounded-full bg-yellow-50 px-2 py-0.5 text-[11px] font-semibold text-yellow-700">
                                                    Kemungkinan Cocok
                                                </span>

                                            @endif

                                            <span class="rounded-full bg-blue-50 px-2 py-0.5 text-[11px] font-bold text-blue-700">
                                                {{ $match->score }}%
                                            </span>

                                        </div>

                                    </div>

                                    {{-- Isi kandidat --}}
                                    <div class="flex gap-3 p-3">

                                        {{-- Foto --}}
                                        <div class="shrink-0">

                                            @if ($matchedReport->images->isNotEmpty())

                                                <img
                                                    src="{{ asset('storage/' . $matchedReport->images->first()->path) }}"
                                                    alt="{{ $matchedReport->images->first()->original_name }}"
                                                    class="h-20 w-20 rounded-lg object-cover"
                                                >

                                            @else

                                                <div class="flex h-20 w-20 items-center justify-center rounded-lg bg-gray-100">
                                                    <span class="text-2xl">
                                                        📦
                                                    </span>
                                                </div>

                                            @endif

                                        </div>

                                        {{-- Informasi --}}
                                        <div class="min-w-0 flex-1">

                                            <div class="grid grid-cols-2 gap-x-4 gap-y-2 sm:grid-cols-4">

                                                <div>

                                                    <p class="text-[10px] font-medium uppercase tracking-wide text-gray-400">
                                                        Jenis
                                                    </p>

                                                    <p class="mt-0.5 text-xs font-medium text-gray-800">
                                                        {{ $matchedReport->type }}
                                                    </p>

                                                </div>

                                                <div>

                                                    <p class="text-[10px] font-medium uppercase tracking-wide text-gray-400">
                                                        Tanggal
                                                    </p>

                                                    <p class="mt-0.5 text-xs font-medium text-gray-800">
                                                        {{ $matchedReport->event_date->format('d-m-Y') }}
                                                    </p>

                                                </div>

                                                <div>

                                                    <p class="text-[10px] font-medium uppercase tracking-wide text-gray-400">
                                                        Merek
                                                    </p>

                                                    <p class="mt-0.5 truncate text-xs text-gray-700">
                                                        {{ $matchedReport->brand ?? '-' }}
                                                    </p>

                                                </div>

                                                <div>

                                                    <p class="text-[10px] font-medium uppercase tracking-wide text-gray-400">
                                                        Warna
                                                    </p>

                                                    <p class="mt-0.5 truncate text-xs text-gray-700">
                                                        {{ $matchedReport->color ?? '-' }}
                                                    </p>

                                                </div>

                                            </div>

                                            <p class="mt-2 line-clamp-2 text-xs leading-5 text-gray-600">
                                                {{ $matchedReport->description }}
                                            </p>

                                            <div class="mt-2">

                                                <a
                                                    href="{{ route('reports.show', $matchedReport) }}"
                                                    class="inline-flex items-center rounded-md bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-gray-800"
                                                >
                                                    Lihat Laporan

                                                    <span class="ml-1">
                                                        →
                                                    </span>
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

        </div>

    </div>

</x-app-layout>
