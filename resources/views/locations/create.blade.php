<!DOCTYPE html>
<html>
<head>
    <title>Tambah Lokasi</title>
</head>
<body>

    <h1>Tambah Lokasi</h1>

    <form action="{{ route('locations.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">Nama Lokasi</label>
            <input
                type="text"
                id="name"
                name="name"
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
            <label for="latitude">Latitude</label>
            <input
                type="text"
                id="latitude"
                name="latitude"
            >
        </div>

        <br>

        <div>
            <label for="longitude">Longitude</label>
            <input
                type="text"
                id="longitude"
                name="longitude"
            >
        </div>

        <br>

        <button type="submit">Simpan</button>
    </form>

    <br>

    <a href="{{ route('locations.index') }}">Kembali</a>

</body>
</html>