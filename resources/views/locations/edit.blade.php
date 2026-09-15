<!DOCTYPE html>
<html>
<head>
    <title>Edit Lokasi</title>
</head>
<body>

    <h1>Edit Lokasi</h1>

    <form action="{{ route('locations.update', $location) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Nama Lokasi</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ $location->name }}"
            >
        </div>

        <br>

        <div>
            <label for="description">Deskripsi</label>
            <textarea
                id="description"
                name="description"
            >{{ $location->description }}</textarea>
        </div>

        <br>

        <div>
            <label for="latitude">Latitude</label>
            <input
                type="text"
                id="latitude"
                name="latitude"
                value="{{ $location->latitude }}"
            >
        </div>

        <br>

        <div>
            <label for="longitude">Longitude</label>
            <input
                type="text"
                id="longitude"
                name="longitude"
                value="{{ $location->longitude }}"
            >
        </div>

        <br>

        <button type="submit">Update</button>
    </form>

    <br>

    <a href="{{ route('locations.index') }}">Kembali</a>

</body>
</html>