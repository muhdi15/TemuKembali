@extends('admin.layout')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    

    <!-- Statistik Cards -->
    <div class="row g-2">
        @php
            $stats = [
                ['icon' => 'bi-people', 'label' => 'Total Pengguna', 'value' => $jumlahUser, 'color' => '#2563eb'],
                ['icon' => 'bi-exclamation-circle', 'label' => 'Laporan Hilang', 'value' => $jumlahHilang, 'color' => '#dc2626'],
                ['icon' => 'bi-box-seam', 'label' => 'Laporan Temuan', 'value' => $jumlahTemuan, 'color' => '#16a34a'],
                ['icon' => 'bi-link-45deg', 'label' => 'Pencocokan', 'value' => $jumlahPencocokan, 'color' => '#f59e0b'],
            ];
        @endphp

        @foreach ($stats as $stat)
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 stat-card" style="transition:0.3s;">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width:55px;height:55px;background-color:{{ $stat['color'] }}1A;">
                        <i class="bi {{ $stat['icon'] }}" style="font-size:1.6rem;color:{{ $stat['color'] }}"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 small">{{ $stat['label'] }}</p>
                        <h4 class="fw-bold mb-0" style="color:#2d2d2d;">{{ $stat['value'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Section Divider -->
    <div class="my-2 text-center">
        <hr class="w-25 mx-auto border-secondary opacity-25">
    </div>

    <!-- Laporan Terbaru -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between px-4 py-3">
            <h5 class="fw-semibold mb-0"><i class="bi bi-clock-history me-2 text-maroon"></i>Laporan Kehilangan Terbaru</h5>
            <a href="{{ route('admin.laporan-hilang') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="bi bi-eye me-1"></i> Lihat Semua
            </a>
        </div>

        <div class="table-responsive">
            @if($laporanTerbaru->isEmpty())
                <p class="text-center text-muted py-4 mb-0">Belum ada laporan kehilangan.</p>
            @else
            <table class="table align-middle mb-0">
                <thead style="background-color:#f3f4f6;">
                    <tr>
                        <th class="text-secondary small">#</th>
                        <th class="text-secondary small">Nama Barang</th>
                        <th class="text-secondary small">Lokasi Hilang</th>
                        <th class="text-secondary small">Tanggal Hilang</th>
                        <th class="text-secondary small">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporanTerbaru as $i => $laporan)
                    <tr class="align-middle">
                        <td>{{ $i + 1 }}</td>
                        <td class="fw-semibold">{{ $laporan->nama_barang }}</td>
                        <td>{{ $laporan->lokasi_hilang }}</td>
                        <td>{{ \Carbon\Carbon::parse($laporan->tanggal_hilang)->format('d M Y') }}</td>
                        <td>
                            <span class="badge rounded-pill px-3 py-2
                                @if($laporan->status == 'pending') bg-warning text-dark
                                @elseif($laporan->status == 'terverifikasi') bg-success
                                @else bg-secondary @endif">
                                {{ ucfirst($laporan->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.text-maroon { color: #8b1e3f !important; }

/* Hover effect */
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

/* Table clean style */
.table thead th {
    border: none;
    font-weight: 600;
    letter-spacing: .5px;
}
.table tbody td {
    border-top: 1px solid #f1f1f1 !important;
}
.table-hover tbody tr:hover {
    background-color: #f9fafb;
}
</style>
@endpush
@endsection
