<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Pengembalian Barang
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Catat proses pengembalian barang kepada pemilik.
            </p>
        </div>
    </x-slot>


    <div class="py-8">

        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Informasi Klaim --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-5">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                        <div>
                            <h3 class="text-xl font-bold text-gray-900">
                                {{ $claim->report->title }}
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Informasi klaim dan penerima barang
                            </p>
                        </div>

                        <span
                            class="inline-flex w-fit rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700"
                        >
                            {{ $claim->status }}
                        </span>

                    </div>

                </div>


                {{-- Detail --}}
                <div class="px-6 py-6">

                    <dl class="grid gap-5 sm:grid-cols-2">

                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Penerima
                            </dt>

                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                {{ $claim->user->name }}
                            </dd>
                        </div>


                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Email
                            </dt>

                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $claim->user->email }}
                            </dd>
                        </div>


                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Kategori
                            </dt>

                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $claim->report->category->name }}
                            </dd>
                        </div>


                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Lokasi
                            </dt>

                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $claim->report->location->name }}
                            </dd>
                        </div>

                    </dl>

                </div>

            </div>


            {{-- Form Pengembalian --}}
            <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-5">

                    <h3 class="text-lg font-semibold text-gray-900">
                        Catatan Pengembalian
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Tambahkan catatan mengenai proses penyerahan barang kepada pemilik.
                    </p>

                </div>


                <form
                    action="{{ route('returns.store', $claim) }}"
                    method="POST"
                >

                    @csrf

                    <div class="px-6 py-6">

                        <label
                            for="notes"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Catatan
                        </label>

                        <textarea
                            name="notes"
                            id="notes"
                            rows="6"
                            maxlength="2000"
                            placeholder="Contoh: Barang telah diserahkan langsung kepada pemilik."
                            class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('notes') }}</textarea>

                        @error('notes')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <p class="mt-2 text-xs text-gray-500">
                            Maksimal 2000 karakter.
                        </p>

                    </div>


                    {{-- Action --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('staff.claims.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
                        >
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                        >
                            Simpan Pengembalian
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>