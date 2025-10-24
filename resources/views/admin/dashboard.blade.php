@extends('admin.layout')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Statistik -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 bg-white rounded-3">
                <div class="d-flex align-items-center">
                    <div class="me-3 p-3 bg-maroon text-white rounded-circle">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-0">Total Pengguna</h6>
                        <h3 class="fw-bold text-maroon mb-0">{{ $jumlahUser }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 bg-white rounded-3">
                <div class="d-flex align-items-center">
                    <div class="me-3 p-3 bg-maroon text-white rounded-circle">
                        <i class="bi bi-exclamation-triangle fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-0">Laporan Hilang</h6>
                        <h3 class="fw-bold text-maroon mb-0">{{ $jumlahHilang }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 bg-white rounded-3">
                <div class="d-flex align-items-center">
                    <div class="me-3 p-3 bg-maroon text-white rounded-circle">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-0">Laporan Temuan</h6>
                        <h3 class="fw-bold text-maroon mb-0">{{ $jumlahTemuan }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 bg-white rounded-3">
                <div class="d-flex align-items-center">
                    <div class="me-3 p-3 bg-maroon text-white rounded-circle">
                        <i class="bi bi-link-45deg fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-0">Pencocokan</h6>
                        <h3 class="fw-bold text-maroon mb-0">{{ $jumlahPencocokan }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan terbaru -->
    <div class="card mt-5 border-0 shadow-sm rounded-3">
        <div class="card-header bg-maroon text-white">
            <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Laporan Kehilangan Terbaru</h5>
        </div>
        <div class="card-body">
            @if($laporanTerbaru->isEmpty())
                <p class="text-muted text-center">Belum ada laporan kehilangan.</p>
            @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
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
                            <td>{{ $laporan->nama_barang }}</td>
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
.bg-maroon {
    background-color: #c46a78 !important;
}
.text-maroon {
    color: #9b1b30 !important;
}
.card {
    transition: 0.3s;
}
.card:hover {
    transform: translateY(-3px);
}
</style>
@endpush
@endsection
