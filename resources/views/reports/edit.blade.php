<!DOCTYPE html>
<html>
<head>
    <title>Edit Laporan</title>
</head>
<body>

    <h1>Edit Laporan</h1>

    <form
        action="{{ route('reports.update', $report) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div>
            <label for="type">Jenis Laporan</label>

            <select id="type" name="type">
                <option
                    value="LOST"
                    {{ $report->type === 'LOST' ? 'selected' : '' }}
                >
                    Kehilangan
                </option>

                <option
                    value="FOUND"
                    {{ $report->type === 'FOUND' ? 'selected' : '' }}
                >
                    Penemuan
                </option>
            </select>
        </div>

        <br>

        <div>
            <label for="category_id">Kategori</label>

            <select id="category_id" name="category_id">
                <option value="">-- Pilih Kategori --</option>

                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ $report->category_id == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <br>

        <div>
            <label for="location_id">Lokasi</label>

            <select id="location_id" name="location_id">
                <option value="">-- Pilih Lokasi --</option>

                @foreach ($locations as $location)
                    <option
                        value="{{ $location->id }}"
                        {{ $report->location_id == $location->id ? 'selected' : '' }}
                    >
                        {{ $location->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <br>

        <div>
            <label for="title">Judul Laporan</label>

            <input
                type="text"
                id="title"
                name="title"
                value="{{ $report->title }}"
            >
        </div>

        <br>

        <div>
            <label for="description">Deskripsi</label>

            <textarea
                id="description"
                name="description"
            >{{ $report->description }}</textarea>
        </div>

        <br>

        <div>
            <label for="brand">Merek</label>

            <input
                type="text"
                id="brand"
                name="brand"
                value="{{ $report->brand }}"
            >
        </div>

        <br>

        <div>
            <label for="color">Warna</label>

            <input
                type="text"
                id="color"
                name="color"
                value="{{ $report->color }}"
            >
        </div>

        <br>

        <div>
            <label for="event_date">Tanggal Kejadian</label>

            <input
                type="date"
                id="event_date"
                name="event_date"
                value="{{ $report->event_date }}"
            >
        </div>

        <br>

        <div>
            <label for="contact_info">Informasi Kontak</label>

            <input
                type="text"
                id="contact_info"
                name="contact_info"
                value="{{ $report->contact_info }}"
            >
        </div>

        <br>

        <h3>Foto Saat Ini</h3>

        @forelse ($report->images as $image)

            <div>
                <img
                    src="{{ asset('storage/' . $image->path) }}"
                    alt="{{ $image->original_name }}"
                    width="200"
                >

                <p>{{ $image->original_name }}</p>
            </div>

        @empty

            <p>Belum ada foto.</p>

        @endforelse

        <br>

        <div>
            <label for="images">Tambah Foto Baru</label>

            <input
                type="file"
                id="images"
                name="images[]"
                multiple
                accept="image/*"
            >
        </div>

        <br>

        <button type="submit">
            Simpan Perubahan
        </button>

    </form>

    <br>

    <a href="{{ route('reports.show', $report) }}">
        Batal
    </a>

</body>
</html>