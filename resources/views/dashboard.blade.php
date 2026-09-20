<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900">
                Dashboard
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Ringkasan aktivitas Campus Lost & Found.
            </p>
        </div>
    </x-slot>


    <div class="bg-gray-50 py-6">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- ========================================= --}}
            {{-- STATISTIK UTAMA --}}
            {{-- ========================================= --}}

            <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">

                {{-- Total Laporan --}}
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                    <p class="text-xs font-medium text-gray-500">
                        Total Laporan
                    </p>

                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ $totalReports }}
                    </p>

                    <p class="mt-1 text-xs text-gray-400">
                        Semua laporan
                    </p>
                </div>


                {{-- Laporan Kehilangan --}}
                <div class="rounded-xl border border-red-100 bg-red-50 p-4 shadow-sm">
                    <p class="text-xs font-medium text-red-700">
                        Kehilangan
                    </p>

                    <p class="mt-1 text-2xl font-bold text-red-900">
                        {{ $lostReports }}
                    </p>

                    <p class="mt-1 text-xs text-red-600">
                        Barang hilang
                    </p>
                </div>


                {{-- Laporan Ditemukan --}}
                <div class="rounded-xl border border-green-100 bg-green-50 p-4 shadow-sm">
                    <p class="text-xs font-medium text-green-700">
                        Ditemukan
                    </p>

                    <p class="mt-1 text-2xl font-bold text-green-900">
                        {{ $foundReports }}
                    </p>

                    <p class="mt-1 text-xs text-green-600">
                        Barang ditemukan
                    </p>
                </div>


                {{-- Menunggu Verifikasi --}}
                <div class="rounded-xl border border-yellow-100 bg-yellow-50 p-4 shadow-sm">
                    <p class="text-xs font-medium text-yellow-700">
                        Menunggu Verifikasi
                    </p>

                    <p class="mt-1 text-2xl font-bold text-yellow-900">
                        {{ $pendingReports }}
                    </p>

                    <p class="mt-1 text-xs text-yellow-700">
                        Menunggu staff
                    </p>
                </div>

            </div>


            {{-- ========================================= --}}
            {{-- STATISTIK TAMBAHAN --}}
            {{-- ========================================= --}}

            <div class="mt-3 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="grid grid-cols-2 divide-x divide-y divide-gray-200 sm:grid-cols-4 sm:divide-y-0">

                    {{-- Klaim Menunggu --}}
                    <div class="px-3 py-3 text-center">
                        <p class="text-xs text-gray-500">
                            Klaim Menunggu
                        </p>

                        <p class="mt-1 text-lg font-bold text-orange-600">
                            {{ $pendingClaims }}
                        </p>
                    </div>


                    {{-- Disetujui --}}
                    <div class="px-3 py-3 text-center">
                        <p class="text-xs text-gray-500">
                            Disetujui
                        </p>

                        <p class="mt-1 text-lg font-bold text-blue-600">
                            {{ $approvedReports }}
                        </p>
                    </div>


                    {{-- Diklaim --}}
                    <div class="px-3 py-3 text-center">
                        <p class="text-xs text-gray-500">
                            Diklaim
                        </p>

                        <p class="mt-1 text-lg font-bold text-purple-600">
                            {{ $claimedReports }}
                        </p>
                    </div>


                    {{-- Dikembalikan --}}
                    <div class="px-3 py-3 text-center">
                        <p class="text-xs text-gray-500">
                            Dikembalikan
                        </p>

                        <p class="mt-1 text-lg font-bold text-emerald-600">
                            {{ $returnedReports }}
                        </p>
                    </div>

                </div>

            </div>


            {{-- ========================================= --}}
            {{-- LAPORAN TERBARU --}}
            {{-- ========================================= --}}

            <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">

                    <div>
                        <h3 class="text-base font-semibold text-gray-900">
                            Laporan Terbaru
                        </h3>

                        <p class="mt-1 text-xs text-gray-500">
                            Laporan terbaru yang masuk.
                        </p>
                    </div>

                    <a
                        href="{{ route('reports.index') }}"
                        class="text-xs font-semibold text-indigo-600 transition hover:text-indigo-900"
                    >
                        Semua →
                    </a>

                </div>


                <div class="divide-y divide-gray-200">

                    @forelse ($latestReports->take(5) as $report)

                        <div class="px-5 py-3 transition hover:bg-gray-50">

                            <div class="flex items-center justify-between gap-3">

                                <div class="min-w-0">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <h4 class="truncate text-sm font-semibold text-gray-900">
                                            {{ $report->title }}
                                        </h4>

                                        @if ($report->type === 'LOST')

                                            <span class="shrink-0 rounded-full bg-red-100 px-2 py-0.5 text-[10px] font-semibold text-red-700">
                                                KEHILANGAN
                                            </span>

                                        @else

                                            <span class="shrink-0 rounded-full bg-green-100 px-2 py-0.5 text-[10px] font-semibold text-green-700">
                                                DITEMUKAN
                                            </span>

                                        @endif

                                    </div>


                                    <div class="mt-1 flex flex-wrap gap-x-2 text-xs text-gray-500">

                                        <span>
                                            {{ $report->category->name }}
                                        </span>

                                        <span>
                                            •
                                        </span>

                                        <span>
                                            {{ $report->location->name }}
                                        </span>

                                        <span>
                                            •
                                        </span>

                                        <span>
                                            {{ $report->event_date->format('d-m-Y') }}
                                        </span>

                                    </div>

                                </div>


                                <div class="shrink-0">

                                    @if ($report->status === 'PENDING')

                                        <span class="rounded-full bg-yellow-100 px-2.5 py-1 text-[10px] font-semibold text-yellow-700">
                                            PENDING
                                        </span>

                                    @elseif ($report->status === 'APPROVED')

                                        <span class="rounded-full bg-blue-100 px-2.5 py-1 text-[10px] font-semibold text-blue-700">
                                            APPROVED
                                        </span>

                                    @elseif ($report->status === 'REJECTED')

                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-[10px] font-semibold text-red-700">
                                            REJECTED
                                        </span>

                                    @elseif ($report->status === 'CLAIMED')

                                        <span class="rounded-full bg-purple-100 px-2.5 py-1 text-[10px] font-semibold text-purple-700">
                                            CLAIMED
                                        </span>

                                    @elseif ($report->status === 'RETURNED')

                                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-[10px] font-semibold text-green-700">
                                            RETURNED
                                        </span>

                                    @else

                                        <span class="rounded-full bg-gray-100 px-2.5 py-1 text-[10px] font-semibold text-gray-700">
                                            {{ $report->status }}
                                        </span>

                                    @endif

                                </div>

                            </div>


                            <div class="mt-2">

                                <a
                                    href="{{ route('reports.show', $report) }}"
                                    class="text-xs font-semibold text-indigo-600 transition hover:text-indigo-900"
                                >
                                    Lihat Detail →
                                </a>

                            </div>

                        </div>

                    @empty

                        <div class="px-5 py-8 text-center">

                            <p class="text-sm text-gray-500">
                                Belum ada laporan.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>


            {{-- ========================================= --}}
            {{-- LAPORAN SAYA --}}
            {{-- ========================================= --}}

            <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">

                    <div>
                        <h3 class="text-base font-semibold text-gray-900">
                            Laporan Saya
                        </h3>

                        <p class="mt-1 text-xs text-gray-500">
                            Laporan yang kamu buat.
                        </p>
                    </div>

                    <a
                        href="{{ route('reports.index') }}"
                        class="text-xs font-semibold text-indigo-600 transition hover:text-indigo-900"
                    >
                        Semua →
                    </a>

                </div>


                <div class="divide-y divide-gray-200">

                    @forelse ($myReports->take(5) as $report)

                        <div class="px-5 py-3 transition hover:bg-gray-50">

                            <div class="flex items-center justify-between gap-3">

                                <div class="min-w-0">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <h4 class="truncate text-sm font-semibold text-gray-900">
                                            {{ $report->title }}
                                        </h4>

                                        @if ($report->type === 'LOST')

                                            <span class="shrink-0 rounded-full bg-red-100 px-2 py-0.5 text-[10px] font-semibold text-red-700">
                                                KEHILANGAN
                                            </span>

                                        @else

                                            <span class="shrink-0 rounded-full bg-green-100 px-2 py-0.5 text-[10px] font-semibold text-green-700">
                                                DITEMUKAN
                                            </span>

                                        @endif

                                    </div>


                                    <div class="mt-1 flex flex-wrap gap-x-2 text-xs text-gray-500">

                                        <span>
                                            {{ $report->category->name }}
                                        </span>

                                        <span>
                                            •
                                        </span>

                                        <span>
                                            {{ $report->location->name }}
                                        </span>

                                        <span>
                                            •
                                        </span>

                                        <span>
                                            {{ $report->event_date->format('d-m-Y') }}
                                        </span>

                                    </div>

                                </div>


                                <div class="shrink-0">

                                    @if ($report->status === 'PENDING')

                                        <span class="rounded-full bg-yellow-100 px-2.5 py-1 text-[10px] font-semibold text-yellow-700">
                                            PENDING
                                        </span>

                                    @elseif ($report->status === 'APPROVED')

                                        <span class="rounded-full bg-blue-100 px-2.5 py-1 text-[10px] font-semibold text-blue-700">
                                            APPROVED
                                        </span>

                                    @elseif ($report->status === 'REJECTED')

                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-[10px] font-semibold text-red-700">
                                            REJECTED
                                        </span>

                                    @elseif ($report->status === 'CLAIMED')

                                        <span class="rounded-full bg-purple-100 px-2.5 py-1 text-[10px] font-semibold text-purple-700">
                                            CLAIMED
                                        </span>

                                    @elseif ($report->status === 'RETURNED')

                                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-[10px] font-semibold text-green-700">
                                            RETURNED
                                        </span>

                                    @else

                                        <span class="rounded-full bg-gray-100 px-2.5 py-1 text-[10px] font-semibold text-gray-700">
                                            {{ $report->status }}
                                        </span>

                                    @endif

                                </div>

                            </div>


                            <div class="mt-2">

                                <a
                                    href="{{ route('reports.show', $report) }}"
                                    class="text-xs font-semibold text-indigo-600 transition hover:text-indigo-900"
                                >
                                    Lihat Detail →
                                </a>

                            </div>

                        </div>

                    @empty

                        <div class="px-5 py-8 text-center">

                            <p class="text-sm text-gray-500">
                                Kamu belum memiliki laporan.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</x-app-layout>