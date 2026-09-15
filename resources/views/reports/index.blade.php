<!DOCTYPE html>
<html>
<head>
    <title>Daftar Laporan</title>
</head>
<body>

    <h1>Daftar Laporan</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('reports.create') }}">
        + Buat Laporan
    </a>

    <hr>

    @forelse ($reports as $report)
        <div>
            <h2>{{ $report->title }}</h2>

            <p>
                Tipe: {{ $report->type }}
            </p>

            <p>
                Kategori: {{ $report->category->name }}
            </p>

            <p>
                Lokasi: {{ $report->location->name }}
            </p>

            <p>
                Pelapor: {{ $report->user->name }}
            </p>

            <p>
                Tanggal kejadian: {{ $report->event_date }}
            </p>

            <p>
                Status: {{ $report->status }}
            </p>

            <p>
                {{ $report->description }}
            </p>
            <a href="{{ route('reports.show', $report) }}">
    Lihat Detail
</a>
        </div>

        <hr>

    @empty
        <p>Belum ada laporan.</p>
    @endforelse

</body>
</html>
