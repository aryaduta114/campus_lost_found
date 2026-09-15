<!DOCTYPE html>
<html>
<head>
    <title>Edit Kategori</title>
</head>
<body>

    <h1>Edit Kategori</h1>

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Nama Kategori</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ $category->name }}"
            >
        </div>

        <br>

        <div>
            <label for="description">Deskripsi</label>
            <textarea
                id="description"
                name="description"
            >{{ $category->description }}</textarea>
        </div>

        <br>

        <button type="submit">Update</button>
    </form>

    <br>

    <a href="{{ route('categories.index') }}">Kembali</a>

</body>
</html>