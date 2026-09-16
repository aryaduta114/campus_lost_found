<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900">
                Verifikasi Klaim
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Periksa klaim kepemilikan barang dan proses pengembalian.
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

                <h3 class="text-lg font-semibold text-gray-900">
                    Daftar Klaim
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $claims->count() }}
                    klaim sedang ditampilkan.
                </p>

            </div>


            {{-- Daftar Klaim --}}
            <div class="space-y-5">

                @forelse ($claims as $claim)

                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                        {{-- Header --}}
                        <div class="border-b border-gray-200 px-6 py-5">

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                                <div class="min-w-0">

                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $claim->report->title }}
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500">
                                        Klaim diajukan oleh
                                        <span class="font-medium text-gray-700">
                                            {{ $claim->user->name }}
                                        </span>
                                    </p>

                                </div>


                                @if ($claim->status === 'PENDING')

                                    <span class="inline-flex w-fit rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                        PENDING
                                    </span>

                                @elseif ($claim->status === 'APPROVED')

                                    @if ($claim->return)

                                        <span class="inline-flex w-fit rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            RETURNED
                                        </span>

                                    @else

                                        <span class="inline-flex w-fit rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                            APPROVED
                                        </span>

                                    @endif

                                @elseif ($claim->status === 'REJECTED')

                                    <span class="inline-flex w-fit rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                        REJECTED
                                    </span>

                                @else

                                    <span class="inline-flex w-fit rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                        {{ $claim->status }}
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- Informasi Klaim --}}
                        <div class="px-6 py-5">

                            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                                <div>

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                        Pengaju Klaim
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                        {{ $claim->user->name }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                        Email
                                    </p>

                                    <p class="mt-1 break-all text-sm font-medium text-gray-900">
                                        {{ $claim->user->email }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                        Kategori
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                        {{ $claim->report->category->name }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                        Lokasi
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                        {{ $claim->report->location->name }}
                                    </p>

                                </div>

                            </div>


                            {{-- Alasan Klaim --}}
                            <div class="mt-5 rounded-lg bg-gray-50 p-4">

                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Alasan Klaim
                                </p>

                                <p class="mt-2 text-sm leading-6 text-gray-700">
                                    {{ $claim->reason }}
                                </p>

                            </div>


                            {{-- Informasi Pengembalian --}}
                            @if ($claim->return)

                                <div class="mt-5 rounded-lg border border-green-200 bg-green-50 p-4">

                                    <p class="text-sm font-semibold text-green-800">
                                        Barang sudah dikembalikan
                                    </p>

                                    <p class="mt-1 text-sm text-green-700">
                                        Waktu pengembalian:
                                        {{ $claim->return->returned_at->format('d-m-Y H:i') }}
                                    </p>

                                </div>

                            @endif

                        </div>


                        {{-- Action --}}
                        <div class="flex flex-col gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">

                            <a
                                href="{{ route('reports.show', $claim->report) }}"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                            >
                                Lihat Laporan
                            </a>


                            <div class="flex flex-col gap-3 sm:flex-row">

                                {{-- PENDING --}}
                                @if ($claim->status === 'PENDING')

                                    <form
                                        action="{{ route('staff.claims.approve', $claim) }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="inline-flex w-full items-center justify-center rounded-lg bg-green-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700 sm:w-auto"
                                        >
                                            Setujui Klaim
                                        </button>

                                    </form>


                                    <form
                                        action="{{ route('staff.claims.reject', $claim) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menolak klaim ini?')"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="inline-flex w-full items-center justify-center rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 sm:w-auto"
                                        >
                                            Tolak Klaim
                                        </button>

                                    </form>


                                {{-- APPROVED --}}
                                @elseif ($claim->status === 'APPROVED' && ! $claim->return)

                                    <a
                                        href="{{ route('returns.create', $claim) }}"
                                        class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
                                    >
                                        Catat Pengembalian
                                    </a>

                                @endif

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="rounded-xl border border-gray-200 bg-white px-6 py-12 text-center shadow-sm">

                        <h3 class="text-base font-semibold text-gray-900">
                            Tidak ada klaim
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Tidak ada klaim yang perlu diproses saat ini.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- Navigation --}}
            <div class="mt-6">

                <a
                    href="{{ route('staff.reports.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    Kembali ke Verifikasi Laporan
                </a>

            </div>

        </div>

    </div>

</x-app-layout>