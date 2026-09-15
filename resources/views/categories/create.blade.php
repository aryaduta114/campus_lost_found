<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kategori</title>
</head>
<body>

    <h1>Tambah Kategori</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">Nama Kategori</label>
            <input type="text" id="name" name="name">
        </div>

        <br>

        <div>
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description"></textarea>
        </div>

        <br>

        <button type="submit">Simpan</button>
    </form>

    <br>

    <a href="{{ route('categories.index') }}">Kembali</a>

</body>
</html>