<!DOCTYPE html>
<html>
<head>
    <title>Detail Laporan</title>
</head>
<body>

    <h1>Detail Laporan</h1>

    <hr>

    <h2>{{ $report->title }}</h2>

    <p>
        <strong>Jenis:</strong>
        {{ $report->type }}
    </p>

    <p>
        <strong>Kategori:</strong>
        {{ $report->category->name }}
    </p>

    <p>
        <strong>Lokasi:</strong>
        {{ $report->location->name }}
    </p>

    <p>
        <strong>Pelapor:</strong>
        {{ $report->user->name }}
    </p>

    <p>
        <strong>Tanggal Kejadian:</strong>
        {{ $report->event_date }}
    </p>

    <p>
        <strong>Status:</strong>
        {{ $report->status }}
    </p>

    <p>
        <strong>Merek:</strong>
        {{ $report->brand ?? '-' }}
    </p>

    <p>
        <strong>Warna:</strong>
        {{ $report->color ?? '-' }}
    </p>

    <p>
        <strong>Informasi Kontak:</strong>
        {{ $report->contact_info ?? '-' }}
    </p>

    <p>
        <strong>Deskripsi:</strong>
    </p>

    <p>
        {{ $report->description }}
    </p>

    <hr>

    <h3>Foto Barang</h3>

    @forelse ($report->images as $image)

        <div>
            <img
                src="{{ asset('storage/' . $image->path) }}"
                alt="{{ $image->original_name }}"
                width="300"
            >

            <p>
                {{ $image->original_name }}
            </p>
        </div>

        <br>

    @empty

        <p>Belum ada foto.</p>

    @endforelse

    <hr>
    <a href="{{ route('reports.edit', $report) }}">
    Edit Laporan
</a>
<form
    action="{{ route('reports.destroy', $report) }}"
    method="POST"
    onsubmit="return confirm('Yakin ingin menghapus laporan ini?')"
>
    @csrf
    @method('DELETE')

    <button type="submit">
        Hapus Laporan
    </button>
</form>

<br>
<br>

    <a href="{{ route('reports.index') }}">
        Kembali ke Daftar Laporan
    </a>

</body>
</html>