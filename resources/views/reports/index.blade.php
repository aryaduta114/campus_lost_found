<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Daftar Laporan
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Temukan laporan kehilangan atau barang yang ditemukan.
                </p>
            </div>

            <a
                href="{{ route('reports.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700 transition"
            >
                + Buat Laporan
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Search & Filter --}}
            <div class="mb-8 rounded-xl bg-white p-5 shadow-sm border border-gray-200">

                <form action="{{ route('reports.index') }}" method="GET">

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">

                        {{-- Search --}}
                        <div class="lg:col-span-1">
                            <label
                                for="search"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Cari laporan
                            </label>

                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Judul, deskripsi, brand..."
                                class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                            >
                        </div>

                        {{-- Type --}}
                        <div>
                            <label
                                for="type"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Tipe
                            </label>

                            <select
                                id="type"
                                name="type"
                                class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
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
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Kategori
                            </label>

                            <select
                                id="category_id"
                                name="category_id"
                                class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
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
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Lokasi
                            </label>

                            <select
                                id="location_id"
                                name="location_id"
                                class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
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
                    <div class="mt-5 flex flex-wrap items-center gap-3">

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-gray-800 px-5 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 transition"
                        >
                            Cari
                        </button>

                        @if ($search || $type || $categoryId || $locationId)
                            <a
                                href="{{ route('reports.index') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition"
                            >
                                Reset
                            </a>
                        @endif

                    </div>

                </form>
            </div>

            {{-- Report Count --}}
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        Laporan
                    </h3>

                    <p class="text-sm text-gray-500">
                        Menampilkan {{ $reports->count() }} dari {{ $reports->total() }} laporan
                    </p>
                </div>
            </div>

            {{-- Reports --}}
            @forelse ($reports as $report)

                <div class="mb-5 overflow-hidden rounded-xl bg-white shadow-sm border border-gray-200 hover:shadow-md transition">

                    <div class="flex flex-col md:flex-row">

                        {{-- Image --}}
                        <div class="w-full md:w-56 shrink-0">

                            @if ($report->images->first())
                                <img
                                    src="{{ asset('storage/' . $report->images->first()->path) }}"
                                    alt="{{ $report->title }}"
                                    class="h-52 w-full object-cover md:h-full"
                                >
                            @else
                                <div class="flex h-52 w-full items-center justify-center bg-gray-100 text-gray-400 md:h-full">
                                    <div class="text-center">
                                        <div class="text-3xl mb-1">
                                            📦
                                        </div>

                                        <span class="text-sm">
                                            Tidak ada foto
                                        </span>
                                    </div>
                                </div>
                            @endif

                        </div>

                        {{-- Content --}}
                        <div class="flex-1 p-5">

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800">
                                        {{ $report->title }}
                                    </h2>

                                    <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-gray-500">
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

                                    @if ($report->status === 'PENDING')
                                        <span class="inline-flex rounded-full bg-yellow-50 px-3 py-1 text-xs font-semibold text-yellow-700">
                                            PENDING
                                        </span>
                                    @elseif ($report->status === 'APPROVED')
                                        <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                            APPROVED
                                        </span>
                                    @elseif ($report->status === 'CLAIMED')
                                        <span class="inline-flex rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700">
                                            CLAIMED
                                        </span>
                                    @elseif ($report->status === 'RETURNED')
                                        <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                            RETURNED
                                        </span>
                                    @elseif ($report->status === 'REJECTED')
                                        <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                            REJECTED
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                            {{ $report->status }}
                                        </span>
                                    @endif

                                </div>

                            </div>

                            {{-- Report Information --}}
                            <div class="mt-4 grid grid-cols-1 gap-2 text-sm text-gray-600 sm:grid-cols-2">

                                <p>
                                    <span class="font-medium text-gray-700">
                                        Pelapor:
                                    </span>

                                    {{ $report->user->name }}
                                </p>

                                <p>
                                    <span class="font-medium text-gray-700">
                                        Tanggal kejadian:
                                    </span>

                                    {{ $report->event_date->format('d-m-Y') }}
                                </p>

                            </div>

                            {{-- Description --}}
                            <p class="mt-4 line-clamp-2 text-sm leading-relaxed text-gray-600">
                                {{ $report->description }}
                            </p>

                            {{-- Detail --}}
                            <div class="mt-5">
                                <a
                                    href="{{ route('reports.show', $report) }}"
                                    class="inline-flex items-center text-sm font-semibold text-gray-800 hover:text-gray-600 transition"
                                >
                                    Lihat Detail
                                    <span class="ml-1">
                                        →
                                    </span>
                                </a>
                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="rounded-xl bg-white border border-gray-200 px-6 py-12 text-center shadow-sm">

                    @if ($search || $type || $categoryId || $locationId)

                        <h3 class="text-lg font-semibold text-gray-800">
                            Tidak ada laporan yang sesuai
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Coba ubah kata pencarian atau filter yang digunakan.
                        </p>

                        <a
                            href="{{ route('reports.index') }}"
                            class="mt-4 inline-flex text-sm font-semibold text-gray-800 hover:text-gray-600"
                        >
                            Reset filter
                        </a>

                    @else

                        <h3 class="text-lg font-semibold text-gray-800">
                            Belum ada laporan
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Belum ada laporan kehilangan atau penemuan barang.
                        </p>

                    @endif

                </div>

            @endforelse

            {{-- Pagination --}}
            @if ($reports->hasPages())
                <div class="mt-8">
                    {{ $reports->links() }}
                </div>
            @endif

        </div>
    </div>

</x-app-layout>