<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Ajukan Klaim Barang
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Jelaskan alasan mengapa barang ini merupakan milik Anda.
            </p>
        </div>
    </x-slot>


    <div class="py-8">

        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Informasi Barang --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-5">

                    <div>
                        <h3 class="text-xl font-bold text-gray-900">
                            {{ $report->title }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Informasi barang yang ingin Anda klaim
                        </p>
                    </div>

                </div>


                <div class="px-6 py-6">

                    <dl class="grid gap-5 sm:grid-cols-2">

                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Kategori
                            </dt>

                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                {{ $report->category->name }}
                            </dd>
                        </div>


                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Lokasi
                            </dt>

                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                {{ $report->location->name }}
                            </dd>
                        </div>


                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Tanggal Kejadian
                            </dt>

                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $report->event_date->format('d-m-Y') }}
                            </dd>
                        </div>

                    </dl>


                    <div class="mt-6 rounded-lg bg-gray-50 p-4">

                        <h4 class="text-sm font-semibold text-gray-900">
                            Deskripsi Barang
                        </h4>

                        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-700">
                            {{ $report->description }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- Form Klaim --}}
            <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-5">

                    <h3 class="text-lg font-semibold text-gray-900">
                        Alasan Klaim
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Jelaskan informasi yang dapat membantu staff memverifikasi bahwa barang tersebut adalah milik Anda.
                    </p>

                </div>


                <form
                    action="{{ route('claims.store', $report) }}"
                    method="POST"
                >

                    @csrf

                    <div class="px-6 py-6">

                        <label
                            for="reason"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Alasan Klaim
                        </label>

                        <textarea
                            name="reason"
                            id="reason"
                            rows="8"
                            maxlength="2000"
                            required
                            placeholder="Contoh: Saya kehilangan barang ini di gedung A. Saya dapat menjelaskan ciri-ciri khusus barang yang tidak tercantum pada laporan."
                            class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('reason') }}</textarea>

                        @error('reason')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <p class="mt-2 text-xs text-gray-500">
                            Jelaskan ciri-ciri atau informasi lain yang dapat membantu proses verifikasi. Maksimal 2000 karakter.
                        </p>

                    </div>


                    {{-- Action --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('reports.show', $report) }}"
                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
                        >
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                        >
                            Ajukan Klaim
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>