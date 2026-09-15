<!DOCTYPE html>
<html>
<head>
    <title>Daftar Lokasi</title>
</head>
<body>

    <h1>Daftar Lokasi</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('locations.create') }}">
        + Tambah Lokasi
    </a>

    <hr>

    @forelse ($locations as $location)
        <div>
            <h2>{{ $location->name }}</h2>

            @if ($location->description)
                <p>{{ $location->description }}</p>
            @else
                <p>Tidak ada deskripsi.</p>
            @endif

            <p>
                Latitude: {{ $location->latitude ?? '-' }}
            </p>

            <p>
                Longitude: {{ $location->longitude ?? '-' }}
            </p>

            <a href="{{ route('locations.edit', $location) }}">
                Edit
            </a>

            <form
                action="{{ route('locations.destroy', $location) }}"
                method="POST"
                style="display: inline;"
            >
                @csrf
                @method('DELETE')

                <button type="submit">
                    Hapus
                </button>
            </form>
        </div>

        <hr>
    @empty
        <p>Belum ada lokasi.</p>
    @endforelse

</body>
</html>