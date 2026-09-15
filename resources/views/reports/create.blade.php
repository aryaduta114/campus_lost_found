<!DOCTYPE html>
<html>
<head>
    <title>Buat Laporan</title>
</head>
<body>

    <h1>Buat Laporan Kehilangan / Penemuan</h1>

    <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="type">Jenis Laporan</label>

            <select id="type" name="type">
                <option value="LOST">Kehilangan</option>
                <option value="FOUND">Penemuan</option>
            </select>
        </div>

        <br>

        <div>
            <label for="category_id">Kategori</label>

            <select id="category_id" name="category_id">
                <option value="">-- Pilih Kategori --</option>

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
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
                    <option value="{{ $location->id }}">
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
            >
        </div>

        <br>

        <div>
            <label for="description">Deskripsi</label>

            <textarea
                id="description"
                name="description"
            ></textarea>
        </div>

        <br>

        <div>
            <label for="brand">Merek</label>

            <input
                type="text"
                id="brand"
                name="brand"
            >
        </div>

        <br>

        <div>
            <label for="color">Warna</label>

            <input
                type="text"
                id="color"
                name="color"
            >
        </div>

        <br>

        <div>
            <label for="event_date">Tanggal Kejadian</label>

            <input
                type="date"
                id="event_date"
                name="event_date"
            >
        </div>

        <br>

        <div>
            <label for="contact_info">Informasi Kontak</label>

            <input
                type="text"
                id="contact_info"
                name="contact_info"
            >
        </div>

        <br>

        <div>
            <label for="images">Foto Barang</label>

            <input
                type="file"
                id="images"
                name="images[]"
                multiple
                accept="image/*"
            >
        </div>

        <br>

        <button type="submit">Kirim Laporan</button>

    </form>

    <br>

    <a href="{{ route('reports.index') }}">
        Kembali
    </a>

</body>
</html>