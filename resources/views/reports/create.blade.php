<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900">
                Buat Laporan
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Laporkan barang yang hilang atau barang yang kamu temukan.
            </p>
        </div>
    </x-slot>

    <div class="bg-gray-50 py-8">

        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Error Validasi --}}
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                    <h3 class="text-sm font-semibold text-red-800">
                        Terdapat kesalahan pada form:
                    </h3>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif

            <form
                action="{{ route('reports.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
            >

                @csrf

                {{-- Jenis Laporan --}}
<div class="border-b border-gray-200 px-6 py-6">

    <h3 class="text-lg font-semibold text-gray-900">
        Jenis Laporan
    </h3>

    <p class="mt-1 text-sm text-gray-500">
        Pilih salah satu jenis laporan yang sesuai dengan kondisi barang.
    </p>

    <div class="mt-5 grid gap-4 sm:grid-cols-2">

        {{-- Barang Hilang --}}
        <label class="block cursor-pointer">

            <input
                type="radio"
                name="type"
                value="LOST"
                class="peer sr-only"
                {{ old('type', 'LOST') === 'LOST' ? 'checked' : '' }}
            >

            <div
                class="rounded-xl border-2 border-gray-200 bg-white p-5 transition
                       hover:border-red-300 hover:bg-red-50
                       peer-checked:border-red-600
                       peer-checked:bg-red-100"
            >

                <h4 class="text-base font-bold text-gray-900">
                    Barang Hilang
                </h4>

                <p class="mt-1 text-sm leading-5 text-gray-600">
                    Saya kehilangan barang dan ingin melaporkannya.
                </p>

            </div>

        </label>


        {{-- Barang Ditemukan --}}
        <label class="block cursor-pointer">

            <input
                type="radio"
                name="type"
                value="FOUND"
                class="peer sr-only"
                {{ old('type') === 'FOUND' ? 'checked' : '' }}
            >

            <div
                class="rounded-xl border-2 border-gray-200 bg-white p-5 transition
                       hover:border-green-300 hover:bg-green-50
                       peer-checked:border-green-600
                       peer-checked:bg-green-100"
            >

                <h4 class="text-base font-bold text-gray-900">
                    Barang Ditemukan
                </h4>

                <p class="mt-1 text-sm leading-5 text-gray-600">
                    Saya menemukan barang dan ingin melaporkannya.
                </p>

            </div>

        </label>

    </div>

    @error('type')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror

</div>


                {{-- Informasi Dasar --}}
                <div class="border-b border-gray-200 px-6 py-6">

                    <h3 class="text-lg font-semibold text-gray-900">
                        Informasi Dasar
                    </h3>

                    <div class="mt-5 grid gap-5 sm:grid-cols-2">

                        {{-- Kategori --}}
                        <div>
                            <label
                                for="category_id"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Kategori
                            </label>

                            <select
                                id="category_id"
                                name="category_id"
                                class="mt-2 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                            >
                                <option value="">
                                    -- Pilih Kategori --
                                </option>

                                @foreach ($categories as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}
                                    >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Lokasi --}}
                        <div>
                            <label
                                for="location_id"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Lokasi
                            </label>

                            <select
                                id="location_id"
                                name="location_id"
                                class="mt-2 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                            >
                                <option value="">
                                    -- Pilih Lokasi --
                                </option>

                                @foreach ($locations as $location)
                                    <option
                                        value="{{ $location->id }}"
                                        {{ old('location_id') == $location->id ? 'selected' : '' }}
                                    >
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('location_id')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Judul --}}
                        <div class="sm:col-span-2">

                            <label
                                for="title"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Judul Laporan
                            </label>

                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="Contoh: Laptop ASUS hitam"
                                class="mt-2 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                            >

                            <p class="mt-1 text-xs text-gray-500">
                                Gunakan judul yang singkat dan mudah dikenali.
                            </p>

                            @error('title')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Detail Barang --}}
                <div class="border-b border-gray-200 px-6 py-6">

                    <h3 class="text-lg font-semibold text-gray-900">
                        Detail Barang
                    </h3>

                    <div class="mt-5 space-y-5">

                        {{-- Deskripsi --}}
                        <div>

                            <label
                                for="description"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Deskripsi
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                placeholder="Jelaskan ciri-ciri barang, kondisi, lokasi kejadian, atau informasi lain yang relevan."
                                class="mt-2 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        <div class="grid gap-5 sm:grid-cols-2">

                            {{-- Merek --}}
                            <div>

                                <label
                                    for="brand"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Merek
                                </label>

                                <input
                                    type="text"
                                    id="brand"
                                    name="brand"
                                    value="{{ old('brand') }}"
                                    placeholder="Contoh: ASUS"
                                    class="mt-2 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                                >

                                @error('brand')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Warna --}}
                            <div>

                                <label
                                    for="color"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Warna
                                </label>

                                <input
                                    type="text"
                                    id="color"
                                    name="color"
                                    value="{{ old('color') }}"
                                    placeholder="Contoh: Hitam"
                                    class="mt-2 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                                >

                                @error('color')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Tanggal --}}
                            <div>

                                <label
                                    for="event_date"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Tanggal Kejadian
                                </label>

                                <input
                                    type="date"
                                    id="event_date"
                                    name="event_date"
                                    value="{{ old('event_date') }}"
                                    class="mt-2 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                                >

                                @error('event_date')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Kontak --}}
                            <div>

                                <label
                                    for="contact_info"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Informasi Kontak
                                </label>

                                <input
                                    type="text"
                                    id="contact_info"
                                    name="contact_info"
                                    value="{{ old('contact_info') }}"
                                    placeholder="Contoh: WhatsApp / email"
                                    class="mt-2 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-gray-500 focus:ring-gray-500"
                                >

                                @error('contact_info')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Foto --}}
                <div class="border-b border-gray-200 px-6 py-6">

                    <h3 class="text-lg font-semibold text-gray-900">
                        Foto Barang
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Kamu dapat memilih lebih dari satu foto.
                    </p>

                    <div class="mt-4 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-5">

                        <input
                            type="file"
                            id="images"
                            name="images[]"
                            multiple
                            accept="image/*"
                            class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-gray-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-gray-800"
                        >

                        <p class="mt-2 text-xs text-gray-500">
                            Format: JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB per foto.
                        </p>

                        @error('images')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        @error('images.*')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                {{-- Action --}}
                <div class="flex flex-col-reverse gap-3 bg-gray-50 px-6 py-5 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('reports.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
                    >
                        Kirim Laporan
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>