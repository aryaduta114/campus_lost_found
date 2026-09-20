<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Daftar Laporan
                </h2>

                <p class="mt-0.5 text-xs text-gray-500">
                    Temukan laporan kehilangan atau barang yang ditemukan.
                </p>
            </div>

            <a
                href="{{ route('reports.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-gray-800 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-gray-700"
            >
                + Buat Laporan
            </a>
        </div>
    </x-slot>


    <div class="bg-gray-50 py-5">

        <div class="mx-auto max-w-7xl px-3 sm:px-5 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-xs text-green-700">
                    {{ session('success') }}
                </div>
            @endif


            {{-- Search & Filter --}}
            <div class="mb-4 rounded-xl border border-gray-200 bg-white p-3 shadow-sm">

                <form action="{{ route('reports.index') }}" method="GET">

                    <div class="grid grid-cols-1 gap-2.5 md:grid-cols-2 lg:grid-cols-4">

                        {{-- Search --}}
                        <div>
                            <label
                                for="search"
                                class="mb-1 block text-[11px] font-medium text-gray-700"
                            >
                                Cari laporan
                            </label>

                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Judul, deskripsi, brand..."
                                class="w-full rounded-lg border-gray-300 px-3 py-1.5 text-xs shadow-sm focus:border-gray-500 focus:ring-gray-500"
                            >
                        </div>


                        {{-- Type --}}
                        <div>
                            <label
                                for="type"
                                class="mb-1 block text-[11px] font-medium text-gray-700"
                            >
                                Tipe
                            </label>

                            <select
                                id="type"
                                name="type"
                                class="w-full rounded-lg border-gray-300 px-3 py-1.5 text-xs shadow-sm focus:border-gray-500 focus:ring-gray-500"
                            >
                                <option value="">Semua</option>

                                <option
                                    value="LOST"
                                    {{ $type == 'LOST' ? 'selected' : '' }}
                                >
                                    LOST
                                </option>

                                <option
                                    value="FOUND"
                                    {{ $type == 'FOUND' ? 'selected' : '' }}
                                >
                                    FOUND
                                </option>
                            </select>
                        </div>


                        {{-- Category --}}
                        <div>
                            <label
                                for="category_id"
                                class="mb-1 block text-[11px] font-medium text-gray-700"
                            >
                                Kategori
                            </label>

                            <select
                                id="category_id"
                                name="category_id"
                                class="w-full rounded-lg border-gray-300 px-3 py-1.5 text-xs shadow-sm focus:border-gray-500 focus:ring-gray-500"
                            >
                                <option value="">Semua</option>

                                @foreach ($categories as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        {{ (string) $categoryId == (string) $category->id ? 'selected' : '' }}
                                    >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        {{-- Location --}}
                        <div>
                            <label
                                for="location_id"
                                class="mb-1 block text-[11px] font-medium text-gray-700"
                            >
                                Lokasi
                            </label>

                            <select
                                id="location_id"
                                name="location_id"
                                class="w-full rounded-lg border-gray-300 px-3 py-1.5 text-xs shadow-sm focus:border-gray-500 focus:ring-gray-500"
                            >
                                <option value="">Semua</option>

                                @foreach ($locations as $location)
                                    <option
                                        value="{{ $location->id }}"
                                        {{ (string) $locationId == (string) $location->id ? 'selected' : '' }}
                                    >
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>


                    {{-- Filter Buttons --}}
                    <div class="mt-3 flex flex-wrap items-center gap-2">

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-gray-800 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-gray-700"
                        >
                            Cari
                        </button>

                        @if ($search || $type || $categoryId || $locationId)
                            <a
                                href="{{ route('reports.index') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 transition hover:bg-gray-50"
                            >
                                Reset
                            </a>
                        @endif

                    </div>

                </form>

            </div>


            {{-- Report Count --}}
            <div class="mb-2.5">

                <h3 class="text-sm font-semibold text-gray-800">
                    Laporan
                </h3>

                <p class="text-[11px] text-gray-500">
                    Menampilkan {{ $reports->count() }} dari {{ $reports->total() }} laporan
                </p>

            </div>


            {{-- Reports --}}
            @forelse ($reports as $report)

                <div class="mb-2 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm transition hover:shadow-md">

                    <div class="flex gap-2.5 p-2.5">

                        {{-- Thumbnail --}}
                        <div class="shrink-0">

                            @if ($report->images->first())

                                <img
                                    src="{{ asset('storage/' . $report->images->first()->path) }}"
                                    alt="{{ $report->title }}"
                                    class="h-20 w-20 rounded-md object-cover sm:h-20 sm:w-20"
                                >

                            @else

                                <div class="flex h-20 w-20 items-center justify-center rounded-md bg-gray-100 text-gray-400">

                                    <div class="text-center">

                                        <div class="text-lg">
                                            📦
                                        </div>

                                        <span class="text-[9px]">
                                            Tidak ada foto
                                        </span>

                                    </div>

                                </div>

                            @endif

                        </div>


                        {{-- Content --}}
                        <div class="min-w-0 flex-1">

                            {{-- Title + Status --}}
                            <div class="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between">

                                <div class="min-w-0">

                                    <h2 class="truncate text-sm font-semibold text-gray-800">
                                        {{ $report->title }}
                                    </h2>

                                    <div class="mt-0.5 flex flex-wrap items-center gap-1 text-[11px] text-gray-500">

                                        <span>
                                            {{ $report->category->name }}
                                        </span>

                                        <span>•</span>

                                        <span>
                                            {{ $report->location->name }}
                                        </span>

                                    </div>

                                </div>


                                {{-- Status --}}
                                <div class="flex shrink-0 flex-wrap gap-1">

                                    @if ($report->type === 'LOST')

                                        <span class="inline-flex rounded-full bg-red-50 px-1.5 py-0.5 text-[9px] font-semibold text-red-700">
                                            LOST
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-green-50 px-1.5 py-0.5 text-[9px] font-semibold text-green-700">
                                            FOUND
                                        </span>

                                    @endif


                                    @if ($report->status === 'PENDING')

                                        <span class="inline-flex rounded-full bg-yellow-50 px-1.5 py-0.5 text-[9px] font-semibold text-yellow-700">
                                            PENDING
                                        </span>

                                    @elseif ($report->status === 'APPROVED')

                                        <span class="inline-flex rounded-full bg-blue-50 px-1.5 py-0.5 text-[9px] font-semibold text-blue-700">
                                            APPROVED
                                        </span>

                                    @elseif ($report->status === 'CLAIMED')

                                        <span class="inline-flex rounded-full bg-purple-50 px-1.5 py-0.5 text-[9px] font-semibold text-purple-700">
                                            CLAIMED
                                        </span>

                                    @elseif ($report->status === 'RETURNED')

                                        <span class="inline-flex rounded-full bg-green-50 px-1.5 py-0.5 text-[9px] font-semibold text-green-700">
                                            RETURNED
                                        </span>

                                    @elseif ($report->status === 'REJECTED')

                                        <span class="inline-flex rounded-full bg-red-50 px-1.5 py-0.5 text-[9px] font-semibold text-red-700">
                                            REJECTED
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-gray-100 px-1.5 py-0.5 text-[9px] font-semibold text-gray-700">
                                            {{ $report->status }}
                                        </span>

                                    @endif

                                </div>

                            </div>


                            {{-- Report Information --}}
                            <div class="mt-1.5 grid grid-cols-1 gap-x-3 gap-y-0.5 text-[11px] text-gray-600 sm:grid-cols-2">

                                <p class="truncate">
                                    <span class="font-medium text-gray-700">
                                        Pelapor:
                                    </span>

                                    {{ $report->user->name }}
                                </p>

                                <p>
                                    <span class="font-medium text-gray-700">
                                        Kejadian:
                                    </span>

                                    {{ $report->event_date->format('d-m-Y') }}
                                </p>

                            </div>


                            {{-- Description --}}
                            <p class="mt-1 line-clamp-1 text-[11px] leading-4 text-gray-500">
                                {{ $report->description }}
                            </p>


                            {{-- Detail --}}
                            <div class="mt-1">

                                <a
                                    href="{{ route('reports.show', $report) }}"
                                    class="inline-flex items-center text-[11px] font-semibold text-gray-800 transition hover:text-gray-600"
                                >
                                    Lihat Detail
                                    <span class="ml-0.5">
                                        →
                                    </span>
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="rounded-xl border border-gray-200 bg-white px-5 py-8 text-center shadow-sm">

                    @if ($search || $type || $categoryId || $locationId)

                        <h3 class="text-sm font-semibold text-gray-800">
                            Tidak ada laporan yang sesuai
                        </h3>

                        <p class="mt-1 text-xs text-gray-500">
                            Coba ubah kata pencarian atau filter yang digunakan.
                        </p>

                        <a
                            href="{{ route('reports.index') }}"
                            class="mt-2 inline-flex text-xs font-semibold text-gray-800 hover:text-gray-600"
                        >
                            Reset filter
                        </a>

                    @else

                        <h3 class="text-sm font-semibold text-gray-800">
                            Belum ada laporan
                        </h3>

                        <p class="mt-1 text-xs text-gray-500">
                            Belum ada laporan kehilangan atau penemuan barang.
                        </p>

                    @endif

                </div>

            @endforelse


            {{-- Pagination --}}
            @if ($reports->hasPages())

                <div class="mt-4">
                    {{ $reports->links() }}
                </div>

            @endif

        </div>

    </div>

</x-app-layout>