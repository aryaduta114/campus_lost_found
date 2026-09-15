<!DOCTYPE html>
<html>
<head>
    <title>Daftar Kategori</title>
</head>
<body>

    <h1>Daftar Kategori</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('categories.create') }}">
        + Tambah Kategori
    </a>

    <hr>

    @forelse ($categories as $category)
    <div>
        <h2>{{ $category->name }}</h2>

        @if ($category->description)
            <p>{{ $category->description }}</p>
        @else
            <p>Tidak ada deskripsi.</p>
        @endif

        <a href="{{ route('categories.edit', $category) }}">
            Edit
        </a>

        <form
            action="{{ route('categories.destroy', $category) }}"
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
    <p>Belum ada kategori.</p>
@endforelse

</body>
</html>