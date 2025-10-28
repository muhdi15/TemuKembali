@extends('admin.layout')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-maroon">📊 Dashboard Administrator</h2>
        <p class="text-muted">Selamat datang kembali! Berikut ringkasan data sistem Anda.</p>
        <hr class="w-25 mx-auto border-maroon opacity-75">
    </div>

    <!-- Statistik -->
    <div class="row g-4">
        @php
            $stats = [
                ['icon' => 'bi-people', 'title' => 'Total Pengguna', 'value' => $jumlahUser],
                ['icon' => 'bi-exclamation-triangle', 'title' => 'Laporan Hilang', 'value' => $jumlahHilang],
                ['icon' => 'bi-box-seam', 'title' => 'Laporan Temuan', 'value' => $jumlahTemuan],
                ['icon' => 'bi-link-45deg', 'title' => 'Pencocokan', 'value' => $jumlahPencocokan],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="col-md-3">
            <div class="card shadow-lg border-0 rounded-4 hover-lift bg-gradient-light">
                <div class="card-body d-flex align-items-center py-3">
                    <div class="me-3 p-3 bg-maroon-gradient text-white rounded-circle shadow-sm">
                        <i class="bi {{ $stat['icon'] }} fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold text-secondary mb-1">{{ $stat['title'] }}</h6>
                        <h3 class="fw-bold text-maroon mb-0">{{ $stat['value'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Laporan terbaru -->
    <div class="card mt-5 border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-header bg-maroon-gradient text-white py-3 d-flex align-items-center justify-content-between">
            <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i> Laporan Kehilangan Terbaru</h5>
            <a href="{{ route('admin.laporan-hilang') }}" class="btn btn-light btn-sm rounded-pill shadow-sm fw-semibold">
                Lihat Semua
            </a>
        </div>

        <div class="card-body bg-light">
            @if($laporanTerbaru->isEmpty())
                <p class="text-muted text-center py-3">Belum ada laporan kehilangan.</p>
            @else
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="bg-maroon text-white">
                        <tr>
                            <th>#</th>
                            <th>Nama Barang</th>
                            <th>Lokasi Hilang</th>
                            <th>Tanggal Hilang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporanTerbaru as $i => $laporan)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $laporan->nama_barang }}</td>
                            <td>{{ $laporan->lokasi_hilang }}</td>
                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal_hilang)->format('d M Y') }}</td>
                            <td>
                                <span class="badge 
                                    {{ $laporan->status == 'pending' ? 'bg-warning text-dark' : 
                                       ($laporan->status == 'terverifikasi' ? 'bg-success' : 'bg-secondary') }}">
                                    {{ ucfirst($laporan->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
/* Warna utama */
:root {
    --maroon: #8b1e3f;
    --maroon-light: #c46a78;
}

/* Warna custom */
.bg-maroon {
    background-color: var(--maroon) !important;
}
.text-maroon {
    color: var(--maroon) !important;
}
.border-maroon {
    border-color: var(--maroon) !important;
}

/* Gradient */
.bg-maroon-gradient {
    background: linear-gradient(135deg, var(--maroon), var(--maroon-light)) !important;
}
.bg-gradient-light {
    background: linear-gradient(145deg, #ffffff, #f8f9fa);
}

/* Hover efek */
.hover-lift {
    transition: all 0.3s ease-in-out;
}
.hover-lift:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 20px rgba(139, 30, 63, 0.15) !important;
}

/* Table styling */
.table thead th {
    border: none;
    font-weight: 600;
}
.table tbody tr:hover {
    background-color: rgba(196, 106, 120, 0.05);
}

/* Responsif teks */
@media (max-width: 768px) {
    .card-body h3 {
        font-size: 1.4rem;
    }
}
</style>
@endpush
@endsection
