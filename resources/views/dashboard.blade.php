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


    <div class="bg-gray-50 py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Statistik --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Total Laporan --}}
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Total Laporan
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $totalReports }}
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Seluruh laporan
                    </p>
                </div>


                {{-- Laporan Kehilangan --}}
                <div class="rounded-xl border border-red-100 bg-red-50 p-6 shadow-sm">
                    <p class="text-sm font-medium text-red-700">
                        Laporan Kehilangan
                    </p>

                    <p class="mt-2 text-3xl font-bold text-red-900">
                        {{ $lostReports }}
                    </p>

                    <p class="mt-1 text-xs text-red-600">
                        Barang yang dilaporkan hilang
                    </p>
                </div>


                {{-- Laporan Ditemukan --}}
                <div class="rounded-xl border border-green-100 bg-green-50 p-6 shadow-sm">
                    <p class="text-sm font-medium text-green-700">
                        Laporan Ditemukan
                    </p>

                    <p class="mt-2 text-3xl font-bold text-green-900">
                        {{ $foundReports }}
                    </p>

                    <p class="mt-1 text-xs text-green-600">
                        Barang yang ditemukan
                    </p>
                </div>


                {{-- Menunggu Verifikasi --}}
                <div class="rounded-xl border border-yellow-100 bg-yellow-50 p-6 shadow-sm">
                    <p class="text-sm font-medium text-yellow-700">
                        Menunggu Verifikasi
                    </p>

                    <p class="mt-2 text-3xl font-bold text-yellow-900">
                        {{ $pendingReports }}
                    </p>

                    <p class="mt-1 text-xs text-yellow-700">
                        Laporan yang menunggu staff
                    </p>
                </div>


                {{-- Klaim Menunggu Verifikasi --}}
                <div class="rounded-xl border border-orange-100 bg-orange-50 p-6 shadow-sm">
                    <p class="text-sm font-medium text-orange-700">
                        Klaim Menunggu Verifikasi
                    </p>

                    <p class="mt-2 text-3xl font-bold text-orange-900">
                        {{ $pendingClaims }}
                    </p>

                    <p class="mt-1 text-xs text-orange-700">
                        Klaim yang menunggu staff
                    </p>
                </div>


                {{-- Sudah Disetujui --}}
                <div class="rounded-xl border border-blue-100 bg-blue-50 p-6 shadow-sm">
                    <p class="text-sm font-medium text-blue-700">
                        Sudah Disetujui
                    </p>

                    <p class="mt-2 text-3xl font-bold text-blue-900">
                        {{ $approvedReports }}
                    </p>

                    <p class="mt-1 text-xs text-blue-700">
                        Laporan yang telah disetujui
                    </p>
                </div>


                {{-- Sudah Diklaim --}}
                <div class="rounded-xl border border-purple-100 bg-purple-50 p-6 shadow-sm">
                    <p class="text-sm font-medium text-purple-700">
                        Sudah Diklaim
                    </p>

                    <p class="mt-2 text-3xl font-bold text-purple-900">
                        {{ $claimedReports }}
                    </p>

                    <p class="mt-1 text-xs text-purple-700">
                        Laporan dengan klaim disetujui
                    </p>
                </div>


                {{-- Sudah Dikembalikan --}}
                <div class="rounded-xl border border-emerald-100 bg-emerald-50 p-6 shadow-sm">
                    <p class="text-sm font-medium text-emerald-700">
                        Sudah Dikembalikan
                    </p>

                    <p class="mt-2 text-3xl font-bold text-emerald-900">
                        {{ $returnedReports }}
                    </p>

                    <p class="mt-1 text-xs text-emerald-700">
                        Barang yang telah dikembalikan
                    </p>
                </div>

            </div>


            {{-- Laporan Terbaru --}}
            <div class="mt-8 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-5">

                    <h3 class="text-lg font-semibold text-gray-900">
                        Laporan Terbaru
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Laporan terbaru yang masuk ke sistem.
                    </p>

                </div>


                <div class="divide-y divide-gray-200">

                    @forelse ($latestReports as $report)

                        <div class="px-6 py-5 transition hover:bg-gray-50">

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                                <div class="min-w-0">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <h4 class="font-semibold text-gray-900">
                                            {{ $report->title }}
                                        </h4>

                                        @if ($report->type === 'LOST')

                                            <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                                                KEHILANGAN
                                            </span>

                                        @else

                                            <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                                DITEMUKAN
                                            </span>

                                        @endif

                                    </div>


                                    <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-sm text-gray-500">

                                        <span>
                                            {{ $report->category->name }}
                                        </span>

                                        <span>
                                            {{ $report->location->name }}
                                        </span>

                                        <span>
                                            {{ $report->event_date->format('d-m-Y') }}
                                        </span>

                                    </div>

                                </div>


                                <div class="shrink-0">

                                    @if ($report->status === 'PENDING')

                                        <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                            PENDING
                                        </span>

                                    @elseif ($report->status === 'APPROVED')

                                        <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                            APPROVED
                                        </span>

                                    @elseif ($report->status === 'REJECTED')

                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            REJECTED
                                        </span>

                                    @elseif ($report->status === 'CLAIMED')

                                        <span class="inline-flex rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700">
                                            CLAIMED
                                        </span>

                                    @elseif ($report->status === 'RETURNED')

                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            RETURNED
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                            {{ $report->status }}
                                        </span>

                                    @endif

                                </div>

                            </div>


                            <div class="mt-4">

                                <a
                                    href="{{ route('reports.show', $report) }}"
                                    class="text-sm font-semibold text-indigo-600 transition hover:text-indigo-900"
                                >
                                    Lihat Detail
                                </a>

                            </div>

                        </div>

                    @empty

                        <div class="px-6 py-10 text-center">

                            <p class="text-sm text-gray-500">
                                Belum ada laporan.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>


            {{-- Laporan Saya --}}
            <div class="mt-8 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-5">

                    <h3 class="text-lg font-semibold text-gray-900">
                        Laporan Saya
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Daftar laporan yang kamu buat.
                    </p>

                </div>


                <div class="divide-y divide-gray-200">

                    @forelse ($myReports as $report)

                        <div class="px-6 py-5 transition hover:bg-gray-50">

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                                <div class="min-w-0">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <h4 class="font-semibold text-gray-900">
                                            {{ $report->title }}
                                        </h4>

                                        @if ($report->type === 'LOST')

                                            <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                                                KEHILANGAN
                                            </span>

                                        @else

                                            <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                                DITEMUKAN
                                            </span>

                                        @endif

                                    </div>


                                    <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-sm text-gray-500">

                                        <span>
                                            {{ $report->category->name }}
                                        </span>

                                        <span>
                                            {{ $report->location->name }}
                                        </span>

                                        <span>
                                            {{ $report->event_date->format('d-m-Y') }}
                                        </span>

                                    </div>

                                </div>


                                <div class="shrink-0">

                                    @if ($report->status === 'PENDING')

                                        <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                            PENDING
                                        </span>

                                    @elseif ($report->status === 'APPROVED')

                                        <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                            APPROVED
                                        </span>

                                    @elseif ($report->status === 'REJECTED')

                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            REJECTED
                                        </span>

                                    @elseif ($report->status === 'CLAIMED')

                                        <span class="inline-flex rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700">
                                            CLAIMED
                                        </span>

                                    @elseif ($report->status === 'RETURNED')

                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            RETURNED
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                            {{ $report->status }}
                                        </span>

                                    @endif

                                </div>

                            </div>


                            <div class="mt-4">

                                <a
                                    href="{{ route('reports.show', $report) }}"
                                    class="text-sm font-semibold text-indigo-600 transition hover:text-indigo-900"
                                >
                                    Lihat Detail
                                </a>

                            </div>

                        </div>

                    @empty

                        <div class="px-6 py-10 text-center">

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