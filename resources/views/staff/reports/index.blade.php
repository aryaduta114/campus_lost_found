<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900">
                Verifikasi Laporan
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Periksa laporan yang menunggu verifikasi sebelum disetujui atau ditolak.
            </p>
        </div>
    </x-slot>


    <div class="bg-gray-50 py-8">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))

                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4">

                    <p class="text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </p>

                </div>

            @endif


            {{-- Header Informasi --}}
            <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h3 class="text-lg font-semibold text-gray-900">
                            Laporan Menunggu Verifikasi
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $reports->count() }}
                            laporan sedang menunggu pemeriksaan.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Daftar Laporan --}}
            <div class="space-y-5">

                @forelse ($reports as $report)

                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                        {{-- Header Card --}}
                        <div class="border-b border-gray-200 px-6 py-5">

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                                <div class="min-w-0">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $report->title }}
                                        </h3>

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

                                    <p class="mt-2 text-sm text-gray-500">
                                        Dilaporkan oleh
                                        <span class="font-medium text-gray-700">
                                            {{ $report->user->name }}
                                        </span>
                                    </p>

                                </div>


                                <span class="inline-flex w-fit rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                    PENDING
                                </span>

                            </div>

                        </div>


                        {{-- Informasi --}}
                        <div class="px-6 py-5">

                            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                                <div>

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                        Kategori
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                        {{ $report->category->name }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                        Lokasi
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                        {{ $report->location->name }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                        Tanggal Kejadian
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                        {{ $report->event_date->format('d-m-Y') }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                        Foto
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                        {{ $report->images->count() }} foto
                                    </p>

                                </div>

                            </div>


                            {{-- Deskripsi --}}
                            <div class="mt-5 rounded-lg bg-gray-50 p-4">

                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Deskripsi
                                </p>

                                <p class="mt-2 text-sm leading-6 text-gray-700">
                                    {{ $report->description }}
                                </p>

                            </div>

                        </div>


                        {{-- Action --}}
                        <div class="flex flex-col gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">

                            <a
                                href="{{ route('reports.show', $report) }}"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                            >
                                Lihat Detail
                            </a>


                            <div class="flex flex-col gap-3 sm:flex-row">

                                {{-- Setujui --}}
                                <form
                                    action="{{ route('staff.reports.approve', $report) }}"
                                    method="POST"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="inline-flex w-full items-center justify-center rounded-lg bg-green-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700 sm:w-auto"
                                    >
                                        Setujui
                                    </button>

                                </form>


                                {{-- Tolak --}}
                                <form
                                    action="{{ route('staff.reports.reject', $report) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menolak laporan ini?')"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="inline-flex w-full items-center justify-center rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 sm:w-auto"
                                    >
                                        Tolak
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="rounded-xl border border-gray-200 bg-white px-6 py-12 text-center shadow-sm">

                        <h3 class="text-base font-semibold text-gray-900">
                            Tidak ada laporan menunggu verifikasi
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Semua laporan sudah diproses.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</x-app-layout>